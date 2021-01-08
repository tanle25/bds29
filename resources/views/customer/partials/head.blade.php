<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{Str::replaceLast(',', '', $theme_options['favicon'] ?? '')}}"/>
    <meta name="author" content="ThemeStarz">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="FmPO275g37H5kixUCgMLJmeKmuYpk-ZX5SXaa6iFhGU" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap" as="font" crossorigin="anonymous" />
    @include('seo_manager.seo_frontend_component')
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700' rel='stylesheet' type='text/css'>
    @include('customer.partials.css')
</head>
