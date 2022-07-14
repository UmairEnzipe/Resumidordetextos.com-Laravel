@extends('admin')
@section('head')
@endsection
@section('content')
    {{-- <ul>
        @forelse ($audits as $audit)
            <li>
                @lang('article.updated.metadata', $audit->getMetadata())

                @foreach ($audit->getModified() as $attribute => $modified)
                    <ul>
                        <li>@lang('article.' . $audit->event . '.modified.' . $attribute, $modified)</li>
                    </ul>
                @endforeach
            </li>
        @empty
            <p>@lang('article.unavailable_audits')</p>
        @endforelse
    </ul> --}}
@endsection
@section('script')
@endsection
