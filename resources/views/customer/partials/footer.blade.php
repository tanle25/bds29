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
                    <a href="/"><img class="lazy" data-src="{{$logo}}" alt="brand"></a>
                    <strong class="d-block text-light font-9 text-center mt-2">{{$theme_options['Tên_công_ty'] ?? ''}}</strong class="d-block text-light">
                    <div class="mb-1">
                        <i class="fal fa-map-marker-alt" style="width: 20px"></i> <span class="font-9">{{$theme_options['Trụ_sở'] ?? ''}}</span>
                    </div>
                    <div>
                        <i class="fal fa-phone-rotary" style="width: 20px" ></i> <span class="font-9">{{$theme_options['Số_điện_thoại'] ?? ''}}</span>
                    </div>
                </div>
                <div class="copyright col-md-4 text-center text-light font-8">
                    {!! $theme_options['footer_map_iframe'] ?? '' !!}
                </div>
                <div class="col-md-4 ">
                    {!! $theme_options['footer_fb_iframe'] ?? ''!!}
                </div>
            </div>
        </div>
    </div>
</div>
<button class="position-fixed btn up-to-top-btn rounded-circle btn-info" style="opacity:0 ; transition: .5s ; z-index: 100000; right:30px; bottom: 60px">
    <i class="far fa-arrow-up"></i>
</button>

@include('customer.auth.login')
@include('customer.auth.forgot-password')
@include('customer.auth.register')
@include('customer.auth.reset_pasword')

@section('script')
    @parent
    <script>
        $('.up-to-top-btn').on('click', function(){
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        })
        window.addEventListener('scroll', function(){
            if ($(window).scrollTop() >= 200) {
                $('.up-to-top-btn').css({
                    opacity: "1"
                });
            }else{
                $('.up-to-top-btn').css({
                    opacity: "0"
                });
            }
        }, {passive: true})
    </script>
@endsection
