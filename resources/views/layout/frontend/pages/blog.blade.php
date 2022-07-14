
@extends('main')
@section('content')
{{-- @dd($blogs) --}}
    <section class="blogpage">
        @foreach ($blogs as $blog)
        <a href="{{ route('page.single_blog', $blog['slug'])}}" class="container blogs d-flex space-between">
            <div class="latestblog-img">
                <img src=" {{ asset(@$blog ['images']['original']) }}" alt="">
            </div>
            <div class="latestblog-info d-block">
                <div class="info_body">
                    <p>{{ \Carbon\Carbon::parse(@$blog['created_at'])->diffForhumans() }}</p>
                    <div class="posttitle">  {{ \Illuminate\Support\Str::limit(@$blog['title'], 65)}} </div>
                    <div class="postdetail">  {!! \Illuminate\Support\Str::limit(@$blog['detail'], 180) !!} </div>
                </div>
                <div class="info-footer d-flex align-items-center space-between">
                    <span>By Abdur Rehman</span>
                    <button class="btn">Read More</button>
                </div>
            </div>
        </a>
        @break($loop->iteration < 2)
        @endforeach
    </section>
    <section class="recentblog ">
        <div class="container blogs">
            <div class="blog-card space-between d-flex f-wrap">
                @foreach ($blogs as $blog)
                @if (!$loop->first)
                <a href="{{ route('page.single_blog', $blog['slug'])}}" class="img-card mt-36">
                    <img src="{{ asset(@$blog ['images']['original']) }}" alt="">
                    <div class="card-wrapper">
                        <div class="inner_card">
                            <p>{{ \Illuminate\Support\Str::limit(@$blog['title'], 80)}}</p>
                        </div>
                        <div class="imgcard_ft align-items-center d-flex space-between">
                            <div class=""> By Abdur Rehman</div>
                            <p>{{ \Carbon\Carbon::parse(@$blog['created_at'])->diffForhumans() }}</p>
                        </div>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </section>
@endsection
