<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- CDN Styles --}}
    @include('dlr.layouts.cdn_style')

    {{-- Page Specific CSS --}}
    @stack('styles')
</head>

<body>

<div class="main">

    {{-- Sidebar --}}
    @include('dlr.layouts.aside')

    <div class="side-body">

        {{-- Navbar --}}
        @include('dlr.layouts.navbar')

        <div class="sidebodydiv">
            @yield('content')
        </div>

    </div>
</div>

@include('dlr.layouts.offcanvas')

{{-- CDN Scripts --}}
@include('dlr.layouts.cdn_script')

{{-- Page Specific Scripts --}}
@stack('scripts')

</body>
</html>
