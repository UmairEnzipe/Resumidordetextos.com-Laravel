<section class="footer">
    <div class="container text-center">
        <img class="ft_logo text-center mb-10" src="{{asset('web_assets/frontend/img/logo2.svg')}}" width="200">
        <p class="text-center mb-26 mt-36">{!! @get_setting_by_key('footer_text')->value !!}</p>
        <div class="ft_links d-flex text-center mt-36 mb-26">
            <a href="{{ route('home') }}">Home</a>
            <a href="#news">Feature</a>
            <a href="{{ route('page.blog') }}">Blog</a>
            <a href="{{ route('page.about_us') }}">About</a>
            <a href="{{ route('page.contact_us') }}" class="btn">contact Us</a>
        </div>
        <div class="d-inline-flex text-center">
            <a href="#">
                <img src="{{@asset('web_assets/frontend/img/ft1.svg')}}" width="auto" alt="">
            </a><a href="#">
                <img src="{{@asset('web_assets/frontend/img/ft2.svg')}}" width="auto" alt="">
            </a><a href="#">
                <img src="{{@asset('web_assets/frontend/img/ft3.svg')}}" width="auto" alt="">
            </a>
            <a href="#">
                <img src="{{@asset('web_assets/frontend/img/ft4.svg')}}" width="auto" alt="">
            </a>
        </div>
    </div>
</section>
<section class="copyright">
    <div class="container text-center">
        <div class="ft-line"></div>
        <div class="text-center">{!! @get_setting_by_key('copywrite_text')->value !!}</div>
    </div>
</section>
