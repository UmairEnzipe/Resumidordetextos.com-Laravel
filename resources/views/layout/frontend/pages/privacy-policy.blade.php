@extends('main')
@section('content')

<section class="about">
    <div class="container">
        {!! @get_setting_by_key('privacy_policy')->value !!}
    </div>
</section>

@endsection
