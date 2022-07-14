@extends('main')
@section('content')

<section class="about">
    <div class="container">
        {!! @get_setting_by_key('terms_and_condition')->value !!}
    </div>
</section>



@endsection
