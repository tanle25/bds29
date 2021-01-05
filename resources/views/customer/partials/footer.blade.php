{{-- @include('customer.contents.home_contact') --}}
@php
	$logos = explode(',', $theme_options['logo'] ?? '');
	$logo = '';
	foreach ($logos as $temp) {
		if ($temp != '') {
			$logo = $temp;
		}
	}
@endphp

<div id="footer" class="footer">
	<div class="footer-top">
		<div class="container">
            <div class="row pt-4">
                @foreach ($footer_menu as $item)
                <div class="col-md-3 col-6">
                    <h5 class="text-white font-12">{{$item->title ?? ''}}</h5>
                    <ul class="p-0 font-9">
                        @foreach ($item->childs as $child)
                        <li class="font-9">
                            @if ($child->icon)
                            <i class="text-danger {{$child->icon}}"></i>
                            @endif
                            <a class="" href="{{$child->href ?? ''}}">{{$child->title ?? ''}}</a> </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
                <div class="col-12 divider">
                    <hr class="m-0">
                </div>
            </div>
		</div>
    </div>
    <div class="footer-bottom pt-3">
        <div class="container">
            <div class="row pb-4">
                <div class="col-md-4 text-light text-center">
                    <a href="/"><img src="{{$logo}}" alt="brand"></a>
                    <strong class="d-block text-light font-9 text-center mt-2">{{$theme_options['Tên_công_ty'] ?? ''}}</strong class="d-block text-light">
                    <div class="mb-1">
                        <i class="fal fa-map-marker-alt" style="width: 20px"></i> <span class="font-9">{{$theme_options['Trụ_sở'] ?? ''}}</span>
                    </div>
                    <div>
                        <i class="fal fa-phone-rotary" style="width: 20px" ></i> <span class="font-9">{{$theme_options['Số_điện_thoại'] ?? ''}}</span>
                    </div>
                </div>
                <div class="copyright col-md-4 text-center text-light font-8">
                    {!! $theme_options['Script'] ?? '' !!}
                </div>
                <div class="col-md-4 ">
                    <div class="fb-page" data-href="{{$theme_options['facebook'] ?? ''}}" data-tabs="false" data-width="" data-height="" data-lazy="true" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{$theme_options['facebook'] ?? ''}}" class="fb-xfbml-parse-ignore"><a href="{{$theme_options['facebook'] ?? ''}}">Facebook</a></blockquote></div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav id="menu-responsive" class="d-md-none">
    <ul>
        <li class="border-bottom">
            @if (Auth::check())
            <div class="login-logout">
                <a class="text-dark font-9 py-2" href="/tai-khoan">
                    <img src="{{auth()->user()->profile_image_path ?? '/images/empty-avatar.jpg'}}" style="width: 50px; height:50px" alt="">
                    <span class="px-2">{{auth()->user()->name}}</span>
                </a>
                <a href="/dang-tin" class="font-10 font-500 hrm-btn-info p-2"><strong>Đăng tin</strong></a>
            </div>
            @else
            <div class="login-logout row">
                <div class="col-6 p-2">
                    <span href="#" class="mobile-login-btn font-9 btn-outline-info btn w-100" data-toggle="modal" data-target="#register">Đăng ký</span>
                </div>
                <div class="col-6 p-2">
                    <span href="#" class="mobile-logout-btn font-9 btn-outline-info btn w-100" data-toggle="modal" data-target="#popup-login"><span>Đăng nhập</span></span>
                </div>
                <div class="col-12 p-2">
                    <span href="#" class="mobile-logout-btn font-9 btn-info btn w-100" data-toggle="modal" data-target="#popup-login"><span>Đăng Tin</span></span>
                </div>
            </div>
            @endif
        </li>
        @foreach ($main_menu as $item)
            <li>
                <a href="{{$item->href ?? '#'}}"> <i class="{{$item->icon}} font-12 pr-2" aria-hidden="true"></i> {{$item->title}} </a>
                @isset($item->childs)
                    @if ($item->childs->isNotEmpty())
                        <ul>
                            @foreach ($item->childs as $child)
                            <li><a href="{{$child->href}}">{{$child->title}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                @endisset
            </li>
        @endforeach
        @if (Auth::check())
        <li>
            <a class="font-9" href="/logout"><span><i class="far fa-sign-out-alt pr-2 font-12"></i> Đăng xuất</span></a>
        </li>
        @endif
    </ul>
</nav>
<button class="position-fixed btn up-to-top-btn rounded-circle btn-info" style="opacity:0 ; transition: .5s ; z-index: 100000; right:30px; bottom: 60px">
    <i class="far fa-arrow-up"></i>
</button>

@include('customer.auth.login')
@include('customer.auth.forgot-password')
@include('customer.auth.register')
@include('customer.auth.reset_pasword')

@section('script')
    @parent
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=303008451114050&autoLogAppEvents=1" nonce="80UFbrIn"></script>
    <script>
        $('.up-to-top-btn').on('click', function(){
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        })
        $(window).on('scroll', function(){
            if ($(window).scrollTop() >= 200) {
                $('.up-to-top-btn').css({
                    opacity: "1"
                });
            }else{
                $('.up-to-top-btn').css({
                    opacity: "0"
                });
            }
        })
    </script>
@endsection
