<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{Str::replaceLast(',', '', $theme_options['favicon'] ?? '')}}"/>
    <meta name="author" content="ThemeStarz">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="FmPO275g37H5kixUCgMLJmeKmuYpk-ZX5SXaa6iFhGU" />
    
    @include('seo_manager.seo_frontend_component')
    <link rel="preconnect" href="https://fonts.gstatic.com" >
    <link rel="canonical" href="{{URL::current()}}">
    <link rel="preload" href="{{asset('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,300;1,400;1,500&display=swap')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,300;1,400;1,500&display=swap')}}"></noscript>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet"> --}}
    @include('customer.partials.css')

    <!-- GrabCallMobileCRM -->
    <!-- <script id='NAPhoneMobileCRM-widget-script' src='https://cdn.na.com.vn/scripts/NAPhoneCRM.js?business_id=6f83c5e589f646b282f19f25906c93fb' type='text/javascript' charset='UTF-8' async></script> -->
    {{-- <script id="GrabCallMobileCRM-widget-script" type="text/javascript" src="https://cdn.datatuoi.com/scripts/GrabCallCRM.js?business_id=b7202ca45043433b878163dde570c0ba" async></script> --}}

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W9S683L');</script>
    <!-- End Google Tag Manager -->
</head>
