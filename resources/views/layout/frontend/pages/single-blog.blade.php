@extends('main')
@section('content')
    <section class="hero">
        <div class="container">
            <div class="blogimg">
                <img class="feature-img" src="{{ asset(@$blog['images']['original']) }}" width="100%" alt="image">
            </div>
            <div class="heroinner">
                <h2>{{ @$blog['title'] }}</h2>
                <div class="articlecontent mt-36"> {!! @$blog['detail'] !!} </div>
                <div class="info-footer d-flex align-items-center space-between">
                    <span>By Abdur Rehman</span>
                    <p>{{ \Carbon\Carbon::parse(@$blog['created_at'])->diffForhumans() }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="recentblog ">
        <div class="container blogs">
            <div class="blog-card space-between d-flex mt-36 f-wrap">
                @foreach (@get_blogs_by_limit(3, $blog['id']) as $blog)
                    <a href="{{ route('page.single_blog', $blog['slug'])}}" class="img-card mt-36">
                        <img src=" {{ asset(@$blog['images']['original']) }}" alt="">
                        <div class="card-wrapper">
                            <div class="inner_card">
                                <p>{{ \Illuminate\Support\Str::limit(@$blog['title'], 80)}}</p>
                            </div>
                            <div class="imgcard_ft d-flex space-between">
                                <div class=""> By Abdur Rehman</div>
                                <p>{{ \Carbon\Carbon::parse(@$blog['created_at'])->diffForhumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
    </section>
@endsection
