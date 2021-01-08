@php
	$logos = explode(',', $theme_options['logo'] ?? '');
	$logo = '';
	foreach ($logos as $temp) {
		if ($temp != '') {
			$logo = $temp;
		}
	}
@endphp
@section('css')
    <style>
        .menu-open{
            margin: 0;
            padding: 0;
            top:0;
        }
    </style>
@endsection
{{-- <div class="menu-responsive-overlay"></div> --}}
<div class="navigation sticky-top bg-white">
    <div class="header-container p-md-3 border-bottom">
        <header class="" id="top" role="banner">
            <section class=" container menu-desktop d-none d-md-flex justify-content-center align-items-center">
                <div class="navbar-header">
                    <div class="" id="brand">
                        <a href="/"><img class="lazy" style="max-height: 75px" data-src="{{$logo}}" alt="brand"></a>
                    </div>
                </div>
                <nav class="d-flex align-items-center desktop-menu">
                    @foreach ($main_menu as $item)
                    <div class="menu-item p-3 @if(isset($item->childs) && $item->childs != []) has-child @endif"><a class="font-weight-400 text-uppercase main-text font-8" href="{{$item->href ?? '#'}}"> {{$item->title}}</a>
                        @isset($item->childs)
                            @if ($item->childs->isNotEmpty())
                                <ul class="child-navigation submenu-1 border px-3 bg-white rounded shadow-10">
                                    @foreach ($item->childs as $child)
                                    <li class="py-2"><a class="main-text" href="{{$child->href}}">{{$child->title}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        @endisset
                    </div>
                    @endforeach
                </nav>
                <div class="d-block pr-3">
                    <a style="position: relative; width: auto; top:0; z-index:2"  href="#" class="pl-3 d-xl-none menu-open font-15 text-secondary" ><i class="far fa-bars"></i></a>
                </div>
                <div class="header-right ml-auto d-none d-xl-flex align-items-center">
                    @if (Auth::check())
                    <div class="login-logout">
                        <a class="text-dark font-9" href="/tai-khoan">
                            <img data-src="{{auth()->user()->profile_image_path ?? '/images/empty-avatar.jpg'}}" style="width: 50px; height:50px" class="lazy img-thumbnail rounded-circle" alt="">
                            <strong class="border-right px-2">{{auth()->user()->name}}</strong>
                        </a>
                        <a class="text-dark font-9" href="/logout"><span class="px-2">Đăng xuất</span></a>
                        <a href="/dang-tin" class="ml-2 font-9 hrm-btn-info p-2"><strong>Đăng tin</strong></a>
                    </div>
                    @else
                    <div class="login-logout d-flex align-items-center text-uppercase">
                        <div href="/dang-tin" class="ml-2 btn font-8 btn-info" data-toggle="modal" data-target="#popup-login"><span>Đăng tin</span></div>
                        <div class="p-2">
                            <div class="btn border rounded">
                                <a href="#" class="text-info px-2 font-8" data-toggle="modal" data-target="#register">Đăng ký</a>
                                <a href="#" class="text-info font-8" data-toggle="modal" data-target="#popup-login"><span class="border-left px-2">Đăng nhập</span></a>
                            </div>
                        </div>

                    </div>
                    @endif
                </div>
            </section>
        </header>
    </div>
    <section class="header-mobile px-3 pt-2 pb-2 d-md-none" style="background: #024073">
        <div class="d-flex justify-content-between align-items-center">
            <div class="nav-search-btn-scroll  w-100" style="display: none">
                <a class="nav-search-open text-dark d-md-none rounded p-2 d-block bg-white" data-toggle="modal" data-target="#nav-search">
                    <i class="far fa-search font-10"></i> <span class="font-9" style="font-weight: 500">Tìm kiếm bất động sản</span>
                </a>
            </div>
            <a  href="/" class="logo-mobile"><img class="lazy" data-src="{{$logo}}" alt="brand"></a>
            <a style="position: relative; width: auto; top:0; z-index:2"  href="#" class="pl-3 menu-open font-15 text-white d-md-none" ><i class="far fa-bars"></i></a>
        </div>
        <div class="nav-search-btn">
            <a class="nav-search-open text-dark d-md-none rounded p-2  d-block bg-white w-100" data-toggle="modal" data-target="#nav-search">
                <i class="far fa-search font-10"></i> <span class="font-9" style="font-weight: 500">Tìm kiếm bất động sản</span>
            </a>
        </div>
</section>
</div>

@if (Agent::isMobile())
@include('customer.components.search.nav_search')
@endif

@section('script')
@parent
    <script>
        $(window).on('scroll', function(){
            var top = $(window).scrollTop();
            if (top > 100) {
                $('.nav-search-btn').hide();
                $('.nav-search-btn-scroll').show();
                $('.logo-mobile').hide();
            }else if(top == 0){
                $('.nav-search-btn').show();
                $('.nav-search-btn-scroll').hide();
                $('.logo-mobile').show();
            }
        })
    </script>
@endsection
