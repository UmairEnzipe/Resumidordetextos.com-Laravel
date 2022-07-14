<!DOCTYPE html>
<html lang="{{ config('constants.native_languge') }}">

<head>
    {{-- HEAD --}}
    @include('layout.frontend.head')
    {{-- HEAD END --}}
    <style>
        .admin-navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999999;
        }

        .admin-navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 5px 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    @if (Auth::check() && in_array(Auth::user()->admin_level, [1, 2]))
        @if (isset($tool) || isset($blog))
            <div class="admin-navbar">
                @if (isset($tool))
                    <a href="{{ route('tool.edit', ['id' => $tool->id]) }}" target="_blank">Edit Tool</a>
                @endif
                @if (isset($blog))
                    <a href="{{ route('blog.edit', ['id' => $blog['id']]) }}" target="_blank">Edit Blog</a>
                @endif
            </div>
        @endif
    @endif
    {{-- HEADER --}}
    @include('layout.frontend.header')
    {{-- HEADER END --}}
    {{-- CONTENT --}}
    @yield('content')
    {{-- CONTENT END --}}
    {{-- FOOTER --}}
    @include('layout.frontend.footer')
    {{-- FOOTER END --}}
</body>

</html>
