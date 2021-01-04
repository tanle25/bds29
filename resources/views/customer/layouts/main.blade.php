<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('customer.partials.head')
    <body>
        @include('customer.partials.mobile_menu')
        <section id="main-site">
            @include('customer.partials.app_bar')
            @include('customer.partials.header')
            <!-- Nội dung conter -->
            @yield('content')
            <!-- chân trang -->
            @include('customer.partials.footer')
        </section>
        @include('customer.partials.scripts')
    </body>
</html>
