@extends('admin')
@section('head')
    <style>
        .tox .tox-notification--warn,
        .tox .tox-notification--warning {
            display: none !important;
        }

        .feature_img_preview img {
            max-width: 300px;
            width: 100%;
            object-fit: contain;
        }

    </style>
@endsection
@section('content')
    <div class="row mt-4">

        <div class="card">
            <div class="card-body pt-0">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="message">

                </div>
                <h4 class="my-3">Add Blog:</h4>
                <form id="blog_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control js-blog-title" placeholder="Blog Title"
                                value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Blog Meta Title"
                                value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control"
                                placeholder="Blog Meta Description" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Slug</label>
                            <input type="text" name="slug" readonly class="form-control js-blog-slug"
                                placeholder="Blog Slug" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="blog" class="form-label">Status</label>
                            <select class="form-select" id="" name="pinch">
                                <option selected disabled>Add To Pinch</option>
                                <option value="1" selected>True</option>
                                <option value="0">False</option>
                            </select>
                        </div>
                        <div class=" col-md-12 mb-3">
                            <label for="contact" class="form-label">Detail</label>
                            <input class="form-control tool_textarea" name="blog_detail" id="blog_textarea" />
                        </div>
                        <div class="col-md-12">
                            <label for="contact" class="form-label">Featured Image URL</label>
                            <x-media :images="$images" name="featured_img" imageId="null" />
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Gallary</label>
                            <div>
                                @if (isset($images))
                                    <x-gallary :images="$images"></x-gallary>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            Submit
                        </button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div>
    </div>
    <!-- Full width modal content -->

    <!-- /.modal -->
@endsection
@section('script')
    {{-- TINYMCE SCRIPT --}}
    <script defer src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script defer src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin">
    </script>
    {{-- TINYMCE SCRIPT END --}}
    <script src="{{ asset('web_assets/admin/js/tinymce-script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".js-blog-title").on("keydown input change", function() {
                let slug = $(this)
                    .val()
                    .replace(/[^a-zA-Z0-9\s]/gi, '')
                    .replace(/[_\s]/g, '-')
                    .toLowerCase();
                $(".js-blog-slug").val(slug);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //...................... BLOG FORM SUBMIT
            $("#blog_form").on('submit', function(e) {
                e.preventDefault();
                var fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('blog.store') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (parseInt(response)) {
                            setTimeout(() => {
                                window.location = "{{ route('blog.index') }}";
                            }, 2000);
                        }
                    },
                    error: function(error) {

                    }
                });
            });
        });
    </script>
@endsection
