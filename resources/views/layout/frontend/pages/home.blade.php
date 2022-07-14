@extends('main')

@section('content')
    <section class="header">
        <div class="container text-center">
            <h1 class="text-center mb-10">{{ @$content->h1->value }}</h1>
            <p class="text-center mb-26">{{ @$content->h1_des->value }}</p>

            <div class="wrapper d-flex mt-36">

                <div class="inner-box d-block">

                    <div class="text-box text-input">
                        <textarea name="" id=""
                            placeholder="Lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."></textarea>
                        <div class="input-box-footer d-flex f-wrap space-between">
                            <div class="d-flex">
                                <div class="out-put-icon"><img src="{{ asset('web_assets/frontend/img/upload.png') }}"
                                        width="22" height="27" alt="upload img"></div>
                                <div class="out-put-icon"><img src=" {{ asset('web_assets/frontend/img/delete.png') }}"
                                        width="22" height="27" alt="del img"></div>
                            </div>
                            <div class="counter-box">
                                <p class="word-count">{{ @$content->words->value }}: 45/500</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class=" btn-input">
                        <button>{{ @$content->submit_btn->value }}</button>
                    </div>
                </div>

                <div class="inner-box d-block">

                    <div class="text-box text-output">
                        <div class="output-area"></div>
                        <div class="counter-box text-right">
                            <p>{{ @$content->words->value }}:47</p>
                        </div>
                    </div>
                    <br>
                    <div class="btn output-btn">
                        <button>{{ @$content->copy_btn->value }}</button>
                        <button>{{ @$content->download_btn->value }}</button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="feature">
        <div class="container">
            <h2 class="text-center mb-10">{{ @$content->feature_h2->value }}</h2>
            <p class="text-center mb-26">{{ @$content->feature_h2_des->value }}</p>
            <div class="card f-wrap text-left d-flex">
                <div class="feature-card active_card mt-36">
                    <div class="card_img mb-26"><img src="{{ asset('web_assets/frontend/img/upload1.svg') }}"
                            width="35" height="50" alt="upload"></div>
                    <h4 class="mb-26">{{ @$content->feature1_title->value }}</h4>
                    <p>{{ @$content->feature1_des->value }}</p>
                </div>
                <div class="feature-card mt-36">
                    <div class="card_img mb-26"><img src="{{ asset('web_assets/frontend/img/delete.svg') }}" width="35"
                            height="50" alt="upload"></div>
                    <h4 class="mb-26">{{ @$content->feature2_title->value }}</h4>
                    <p>{{ @$content->feature2_des->value }}</p>
                </div>
                <div class="feature-card mt-36">
                    <div class="card_img mb-26"><img src="{{ asset('web_assets/frontend/img/copy.svg') }}" width="35"
                            height="50" alt="upload"></div>
                    <h4 class="mb-26">{{ @$content->feature3_title->value }}</h4>
                    <p>{{ @$content->feature3_des->value }}</p>
                </div>
                <div class="feature-card mt-36  ">
                    <div class="card_img mb-26"><img src="{{ asset('web_assets/frontend/img/download.svg') }}"
                            width="35" height="50" alt="upload"></div>
                    <h4 class="mb-26">{{ @$content->feature4_title->value }}</h4>
                    <p>{{ @$content->feature4_des->value }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="working">
        <div class="container d-flex">
            <div class="tool-img tool_tips">
                <div class="tool_imgcolor text-left "></div>
                <img src="{{ asset('web_assets/frontend/img/toolimg.svg') }}" width="550" alt="tool img">
            </div>
            <div class="tool-option tool_tips">
                <div class="inner_option">
                    <h2 class="mb-26">{{ @$content->how_work_h2->value }}</h2>
                    <p class="mt-36 mb-26">{{ @$content->how_work_h2_des->value }}</p>
                    <div class="options f-wrap d-flex mt-36">
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Upload file</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Paste text</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Delete text</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Paraphrase text</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Total Words</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25" alt="">
                            <p>Copy paraphrase text</p>
                        </div>
                        <div class=" d-flex">
                            <img src="{{ asset('web_assets/frontend/img/bluetick.svg') }}" width="25"
                                alt="">
                            <p>Download paraphrase text</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog">
        <div class="container text-center">
            <h2 class="text-center mb-10">Blog</h2>
            <p class="text-center mb-26">Lorem ipsum is simply dummied text of the printing and typesetting <br> industry
                lorem ipsum has been</p>
            <div class="blog-card space-between d-flex mt-36">
                @foreach (get_blogs_by_limit(3) as $blog)
                <a href="{{ route('page.single_blog', $blog['slug'])}}" class="img-card mt-36">
                    <img src=" {{ asset(@$blog['images']['original']) }}" alt="">
                    <div class="card-wrapper">
                        <div class="inner_card">
                            <p class="text-left" >{{ \Illuminate\Support\Str::limit(@$blog['title'], 80)}}</p>
                        </div>
                        <div class="imgcard_ft d-flex space-between">
                            <div class=""> By Abdur Rehman</div>
                            <p>{{ \Carbon\Carbon::parse(@$blog['created_at'])->diffForhumans() }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
