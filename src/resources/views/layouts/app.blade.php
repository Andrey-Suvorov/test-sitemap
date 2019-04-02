<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="page-body">

<div class="page-container" style="margin-top: 55px;"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
    <div class="main-content">
        @yield('content')
    </div>
</div>

<footer class="main-footer sticky footer-type-1">
    <!-- Add your copyright text here -->
    <div class="footer-text">
        &copy; {{ \Carbon\Carbon::now()->format("Y")  }}
        <strong>{{ config('app.name') }}</strong>
    </div>

    <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
    <div class="go-up">
        <a href="#" rel="go-top">
            <i class="fa-angle-up"></i>
        </a>
    </div>
</footer>


@yield('styles')

@yield('scripts')

</body>
</html>