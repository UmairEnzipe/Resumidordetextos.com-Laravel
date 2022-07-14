<section class="menubar">
    <div class="container-1">
        <div class="topnav" id="myTopnav">
            <a href="#home" class="active"><img src="{{asset('web_assets/frontend/img/logo1.svg')}}" width="auto" alt=""></a>
            <a href="{{ route('home') }}">Home</a>
            <a href="#news">Feature</a>
            <a href="{{ route('page.blog') }}">Blog</a>
            <a href="{{ route('page.about_us') }}">About</a>
            <a href="{{ route('page.contact_us') }}" class="btn">contact Us</a>
            <img type="button" href="javascript:void(0);" class="icon" onclick="myFunction()" src="images/menu-icons.svg">
        </div>
    </div>
</section>
