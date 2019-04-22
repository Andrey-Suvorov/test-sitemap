<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ Html::style( 'vendor/sitemap/css/main.css' ) }}
{{--    <link rel="stylesheet" href="{{ __DIR__ . '' }}">--}}
</head>
<body class="page-body">

<div class="page-container" style="margin-top: 55px;"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
        <div class="container body">
            <div class="main_container">
                @yield('left-sidebar')
                <div class="right_col" role="main">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title">
                                <div class="title_left">
                                    <h3>@yield('title')
                                        <small class="badge badge-info">@yield('title_sm')</small>
                                    </h3>
                                </div>
                                @yield('search')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <div class="text-center" style="font-size: large">{{ session('success') }}</div>
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <div class="text-center"style="font-size: large">{{ session('success') }}</div>
                                </div>
                            @endif

                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<footer class="main-footer sticky footer-type-1">
    <!-- Add your copyright text here -->
    <div class="footer-text">
        &copy; {{ \Carbon\Carbon::now()->format("Y")  }}
        <strong>{{ config('app.name') }}</strong>
    </div>
</footer>


@yield('styles')

@yield('scripts')

</body>
</html>