@if (!isset($show_main))
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}" />
    @if (config('constants.nofollow_noindex') == 'yes')
        <meta name="robots" content="noindex , nofollow" />
    @endif
    <title>{!! @$meta_title !!}</title>
    <meta name="description" content="{!! @$meta_description !!}" />
    {{-- HOME TOOL --}}
    @if (isset($show_canonicals))
        @if ($is_home)
            <link rel="canonical" href="{{ request()->url() }}" />
            <link rel="alternate" hreflang="x-default" href=" {{ route('home') }}" />
            <link rel="alternate" hreflang="{{ config('constants.native_languge') }}" href="{{ route('home') }}" />
            @foreach ($links as $item)
                @if ($item->tool_lang != config('constants.native_languge'))
                    <link rel="alternate" hreflang="{{ $item->tool_lang }}"
                        href="{{ route('other_language_tool', ['lang' => $item->tool_lang, 'slug' => $item->tool_slug]) }}" />
                @endif
            @endforeach
        @else
            {{-- FOR OTHER TOOL --}}
            <link rel="canonical" href="{{ request()->url() }}" />
            <link rel="alternate" hreflang="x-default"
                href=" {{ route('native_language_tool', ['slug' => $parent_slug]) }}" />
            <link rel="alternate" hreflang="en"
                href="{{ route('native_language_tool', ['slug' => $parent_slug]) }}" />
            @foreach ($links as $item)
                @if ($item->tool_lang != config('constants.native_languge'))
                    <link rel="alternate" hreflang="{{ $item->tool_lang }}"
                        href="{{ route('other_language_tool', ['lang' => $item->tool_lang, 'slug' => $item->tool_slug]) }}" />
                @endif
            @endforeach
        @endif
    @endif
@endif
