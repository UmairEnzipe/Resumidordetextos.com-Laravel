@extends('main')
@section('content')

<section class="about">
    <div class="container">
        {!! @get_setting_by_key('about_us')->value !!}
    </div>
</section>

@endsection
