<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('customer.partials.head')
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W9S683L"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @include('customer.partials.header')
        <!-- Nội dung conter -->
         <div id="main-site">
            @yield('content')
         </div><!--  end -->
        <!-- chân trang -->
        @include('customer.partials.footer')
        @include('customer.partials.scripts')
    </body>

</html>
