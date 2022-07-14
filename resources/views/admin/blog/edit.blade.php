@extends('admin')
@section('head')
    <style>
        .tox .tox-notification--warn,
        .tox .tox-notification--warning {
            display: none !important;
        }

        .images_row {
            background: transparent;
            row-gap: 0.5em;
        }

        .images_row div.image-box {
            background: gainsboro;
        }

        .img-fluid.rounded {
            height: 150px;
            object-fit: contain;
            width: 100%;
            background: #8080802e;
            padding: 5px;
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
                <div class="message">

                </div>
                <h4 class="my-3">Edit Blog:</h4>
                <form id="blog_form">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $blog->id }}">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Blog Title"
                                value="{{ $blog->title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="blog" class="form-label">Status</label>
                            <select class="form-select" id="" name="pinch">
                                <option selected disabled>Add To Pinch</option>
                                <option value="1" @if ($blog->status == 1) selected @endif>True</option>
                                <option value="0" @if ($blog->status == 0) selected @endif>False</option>
                            </select>
                        </div>
                        <div class=" col-md-12 mb-3">
                            <label for="contact" class="form-label">Detail</label>
                            <input class="form-control tool_textarea" name="blog_detail" id="blog_textarea"
                                value="{{ $blog->detail }}" />
                        </div>
                        <div class="col-md-12">
                            <label for="contact" class="form-label">Featured Image URL</label>
                            <x-media :images="$images" name="featured_img" :imageId="$blog->img_id" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="Blog Slug"
                                value="{{ $blog->slug }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Blog Meta Title"
                                value="{{ $blog->meta_title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control"
                                placeholder="Blog Meta Description" value="{{ $blog->meta_description }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Gallary</label>
                            <div>
                                <x-gallary :images="$images" />
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
    {{-- TINYMCE SCRIPT END --}}

    <script src="{{ asset('web_assets/admin/js/tinymce-script.js') }}"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('label').on('click', function() {
                $(this).next().focus();
            });


            //...................... BLOG FORM SUBMIT ...........................
            $("#blog_form").on('submit', function(e) {
                e.preventDefault();
                var fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('blog.update') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (parseInt(response)) {
                            $(".message").html(
                                '<div class="col-12"><div class="my-0 mt-2 alert alert-success alert-dismissible bg-success text-white border-0 fade show"role="alert"><button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"aria-label="Close"></button>' +
                                'Blog Updated Successfully!' +
                                '</div></div>'
                            );
                            setTimeout(() => {
                                $(".message").html('');
                                window.location = "{{ route('blog.index') }}";
                            }, 3000);
                        }
                    },
                    error: function(error) {
                        alert(error.responseJSON.errors.featured[0]);
                        $("#feature_image").val('');
                    }
                });
            });
        });
    </script>
@endsection
