<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{Str::replaceLast(',', '', $theme_options['favicon'] ?? '')}}"/>
    <meta name="author" content="ThemeStarz">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="FmPO275g37H5kixUCgMLJmeKmuYpk-ZX5SXaa6iFhGU" />
    @include('seo_manager.seo_frontend_component')
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700&display=swap' rel='preload' type='text/css'>
    @include('customer.partials.css')
</head>
