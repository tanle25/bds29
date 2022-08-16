@extends('customer.layouts.main')

@section('preset_seo')
@php
$tag = $realty_post->tags->pluck('name')->toArray();

$custom_keywords = implode(',', $tag);
$custom_title = $realty_post->title ?? '';
$custom_description = Str::limit($realty_post->description, 200, '...') ?? '';
$custom_og_image = $realty_post->thumb ?? '';
@endphp
@endsection

@section('title'){{$seo->title ?? $realty_post->title}}@endsection

@section('css')
@parent
<link rel="stylesheet" href="{{asset('plugins/lightgallery/dist/css/lightgallery.min.css')}}">
<style>
    .share-group {
        position: relative;
    }

    .share-btn-wraper {
        display: none;
        height: 100%;
        width: 150px;
        background: #fff;
        position: absolute;
        top: 0;
        right: calc(100%);
    }

    .realty-sort-desc ul {
        list-style-type: none;
        padding-left: 0;
    }

    .realty-sort-desc ul li {
        margin-top: 5px;
    }

    .realty-sort-desc ul li strong {
        color: #0F6A9D;
    }

    .post-label span {
        font-size: 14px;
        color: gray;
    }



    @media screen and (max-width: 767px) {
        .hotline-phone-2 {
            display: none;
        }

        .back-top {
            right: 10px;
            bottom: 80px;
        }

        .feature {
            margin: 0 -15px;
        }

        .furniture {
            display: none;
        }
    }
</style>
@endsection

@section('title')
{{$realty_post->title ?? 'Chi tiết Bất động sản'}}
@endsection

@section('content')
@include('customer.components.search_top')
<div class="page-details realty-detail pt-md-4">
    <div class="container pb-4">
        <div class="row">
            <div class="col-md-9">
                <div class="feature">
                    @if ($realty_post->rank == 4)
                    @endif
                    <div class="thumnail">
                        <div id="big" class="lightgallery thumnail-big owl-carousel">
                            @foreach ($realty_post->images as $img)
                            <div data-src="{{Agent::isMobile() ? getThumbnail($img->link) : $img->link}}"
                                class="item embed-responsive embed-responsive-16by9 position-relative">
                                {{-- @if (Agent::isDesktop()) --}}
                                <div class="blur-bg position-absolute w-100 h-100"
                                    style="top: 0;  background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{Agent::isMobile() ? getThumbnail($img->link) : $img->link}}');">
                                </div>
                                {{-- @endif --}}

                                <img class="embed-responsive-item rounded lazy"
                                    data-src="{{Agent::isMobile() ? getThumbnail($img->link) : $img->link}}"
                                    style="object-fit: contain" alt="{{$img->alt}}" title="{{$img->title}}">
                            </div>
                            @endforeach
                        </div>
                        <div id="thumbs" class="thumnail-thumbs owl-carousel owl-theme mt-2">
                            @foreach ($realty_post->images as $img)
                            <div class="item embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item rounded lazy" data-src="{{getThumbnail($img->link)}}"
                                    alt="{{$img->alt}}" title="{{$img->title}}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="content-detail pt-4">
                    <div class=" pl-0 my-2">
                        {{\App\Helpers\Breadcrumbs\RealtyDetailsBreadcrumbHelper::render($realty_post)}}
                    </div>
                    <h1 class="text-dark font-14 entry-title mb-3">{{$realty_post->title}}</h1>
                    <div class="py-4 d-md-flex justify-content-between align-items-center border-bottom border-top">
                        <div class="d-flex">
                            <div class="pr-3">
                                <p class="mb-1">Mức giá</p>
                                <strong class="font-1">
                                    @if ($realty_post->price_type !== 0)
                                    {{ beautyPrice($realty_post->price)}}
                                    @endif
                                    {{config('constant.price_type.'. $realty_post->price_type)['front_view']}}
                                </strong>
                            </div>
                            <div class="px-3">
                                <p class="mb-1">Diện tích</p>
                                <strong class="font-1">{{$realty_post->realty->area}}m<sup>2</sup></strong>
                            </div>
                            <div class="px-3">
                                <p class="mb-1">Phòng ngủ</p>
                                <strong class="font-1">{{$realty->number_of_bed_rooms ?? 0}} PN</sup></strong>
                            </div>
                            <div class="pl-3 furniture">
                                <p class="mb-1">Nội thất</p>
                                <strong class="font-1">
                                    @if($realty_post->realty->furniture == 0)
                                    Cơ bản
                                    @elseif($realty_post->realty->furniture == 1)
                                    Nguyên bản
                                    @else
                                    Full đồ
                                    @endif
                                    </sup></strong>
                            </div>
                        </div>
                        <div>
                            <div class="group-btn share-group d-none d-lg-block">
                                <span class="btn btn-like pl-0">Lưu tin
                                    <span data-post-id="{{$realty_post->id ?? ''}}"
                                        class="btnlike like-heart unchecked">
                                        <i class="far fa-heart text-info font-12"></i>
                                    </span>
                                </span>
                                @include('customer.components.share_button')
                                <a class="btn btn-map" href="#map-show"><i
                                        class="far fa-map-marker text-info font-12"></i> Vị trí</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-content mt-4">
                    <div class="post-description">
                        <h2 class="font-15 pb-2 widget-title">Thông tin chi tiết</h2>
                        <p class="font-9" style="line-height: 30px">
                            {!! $realty_post->description !!}
                        </p>
                    </div>
                    <div class="bg-light w-100 py-2 px-3 text-center">
                        <div class="btn font-9 show-hidden-block text-info" data-open="2"><span
                                class="font-weight-500">Mở rộng </span><i class="fas fa-chevron-down"></i></div>
                    </div>

                </div>

                <div class="about-content mt-4">
                    <div class="">
                        <h2 class="font-15 pb-2 widget-title">Đặc điểm bất động sản</h2>

                        <div class="mb-4 font-9 border p-2" style="line-height: 2em">
                            <div class=""><strong>Địa chỉ: </strong>{{$realty_post->realty->full_address}}</div>
                            <div class="mr-3">
                                <span class="font-weight-500">Loại tin đăng: </span> <span
                                    class="main-blue">{{config('constant.realty_post_type.'.
                                    $realty_post->type)['name']}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="author-info p-3 rounded bg-white border d-block my-4">
                    <div class="author-head pb-3 d-flex">
                        @php
                        $author = $realty_post->author;
                        @endphp
                        <img class="py-1 border d-block rounded-circle" width="60px" height="60px"
                            src="{{$author->profile_image_path ?? '/images/empty-avatar.jpg'}}" alt="{{$author->name}}"
                            title="{{$author->name}}">
                        <div class="pl-3">
                            <h5 class="font-10 pt-2 text-dark">
                                {{$author->name ?? ''}}
                            </h5>
                            <a href="/bat-dong-san-theo-nguoi-dang?us={{$author->id ?? 1}}"
                                class="font-9 text-secondary">Bài đăng liên quan</a>
                        </div>
                    </div>
                    <div class="author-btn-group">
                        <span data-toggle="modal" data-target="#myModal"
                            class="font-9 font-weight-bold d-block shadow-5 mt-2 w-100 py-2 hrm-btn-info">Yêu cầu liên
                            hệ lại</span>
                    </div>
                </div>
                @if ($realty_post->tags->isNotEmpty())
                <div class="mt-4 border-bottom pb-5">
                    <h2 class="font-15 pb-2">Tìm kiếm theo từ khóa</h2>
                    <div class="">
                        @foreach ($realty_post->tags as $tag)
                        <a class="d-inline-block shadow-2 font-9 mt-2 mr-3 py-2 px-3 btn-muted text-secondary rounded-pill"
                            href="{{route('customer.realty_tag.get_all', $tag->slug)}}"><strong>#{{$tag->name}}</strong></a>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-4 pb-4">
                    <h2 class="font-15 pb-2">Bất động sản cùng khu vực</h2>
                    <div>
                        <div class="realted-post-slider2 @if(Agent::isDesktop()) owl-carousel @endif ">
                            @foreach ($realty_post->realty->district->realty_posts->where('status',3)->take(6) as $item)
                            <div class="item p-0 p-md-2 mb-2 mb-md-0">
                                @include('customer.components.realty_post.realty_block', ['item' => $item])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <h2 class="font-15 pb-2">Bất động sản nổi bật</h2>
                    <div>
                        <div class="realted-post-slider2  @if(Agent::isDesktop()) owl-carousel @endif ">
                            @foreach ($newest_post as $item)
                            <div class="item p-0 p-md-2">
                                @include('customer.components.realty_post.realty_block', ['item' => $item])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="author-info p-3 rounded bg-white border mb-4 d-none d-md-block">
                    <div class="author-head text-center py-3">

                        <h5 class="font-12 pt-2 text-dark">Liên hệ</h5>
                    </div>
                    <div class="author-btn-group">
                        <a class="font-9 font-weight-bold  d-block shadow-5 mt-2 w100 py-2 hrm-btn-info call-to-us-detail"
                            href="tel:+{{$realty_post->contact_phone_number ?? ''}}">SĐT:
                            {{$realty_post->contact_phone_number ??''}}</a>
                        <a class="font-9 font-weight-bold  d-block shadow-5 mt-2 w100 py-2 hrm-btn-info"
                            href="mailto:{{$author->email ?? ''}}">Gửi Email</a>
                        <span data-toggle="modal" data-target="#myModal"
                            class="font-9 font-weight-bold d-block shadow-5 mt-2 w-100 py-2 hrm-btn-info">Gửi yêu
                            cầu</span>
                    </div>
                </div>
                {{-- @dd($side_lists) --}}
                @include('customer.pages.realty_post.sidebar')
            </div>
        </div>
    </div>
</div>

<div id="fb-root"></div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin liên hệ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-advisory">
                    <div class="form-group row py-2 m-0">
                        <span class="col-4">Họ và tên</span>
                        <input name="name" id="customer-name" type="text" class="col-7 input ml-2 form-control"
                            placeholder="Họ tên khách hàng (bắt buộc)" value="" value="">
                    </div>
                    <div class="form-group row py-2 m-0">
                        <span class="col-4">Email</span>
                        <input name="name" id="customer-email" type="text" class="col-7 input ml-2 form-control"
                            placeholder="Email" value="">
                    </div>
                    <div class="form-group row py-2 m-0">
                        <span class="col-4">Số điện thoại</span>
                        <input name="name" id="customer-phone" type="text" class="col-7 input ml-2 form-control"
                            placeholder="Số điện thoại (bắt buộc)" value="" required>
                    </div>
                    <div class="form-group row py-2 m-0">
                        <span class="col-4">Lời nhắn</span>
                        <textarea name="message" id="customer-message" class="col-7 form-control ml-2" cols="20"
                            rows="5" placeholder="Lời nhắn"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-info send-contact-btn">Gửi yêu cầu</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<style>
    #navbar {
        /*overflow: hidden;*/
        background-color: #ffffff;
        padding: 1rem 10px;
        transition: 0.2s;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 99;
        box-shadow: 0 4px 18px 0 rgb(0 0 0 / 12%), 0 7px 10px -5px rgb(0 0 0 / 15%);
    }

    #logo {
        font-size: 35px;
        font-weight: bold;
        transition: 0.2s;
    }

    .login-logout {
        padding-right: 15px;
    }

    #main-site {
        padding-top: 108px;
    }

    /*==================Preloader======================*/
    /* The Loader */
    #loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100000;
        overflow: hidden;
    }

    .no-js #loader-wrapper {
        display: none;
    }

    #loader {
        display: block;
        position: relative;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #16a085;
        -webkit-animation: spin 1.7s linear infinite;
        animation: spin 1.7s linear infinite;
        z-index: 11;
    }

    #loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #e74c3c;
        -webkit-animation: spin-reverse 0.6s linear infinite;
        animation: spin-reverse 0.6s linear infinite;
    }

    #loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin-reverse {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(-360deg);
        }
    }

    @keyframes spin-reverse {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
        }
    }

    #loader-wrapper .loader-background {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.767);
        z-index: 10;
    }

    #loader-wrapper .loader-section.section-left {
        left: 0;
    }

    #loader-wrapper .loader-section.section-right {
        right: 0;
    }

    /* Loaded styles */
    .loaded #loader-wrapper .loader-section.section-left {
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .loaded #loader-wrapper .loader-section.section-right {
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .loaded #loader {
        opacity: 0;
        -webkit-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    .loaded #loader-wrapper {
        visibility: hidden;
        /* -webkit-transform: translateY(-100%); */
        /* transform: translateY(-100%); */
        opacity: 0;
        -webkit-transition: all 0.2s 0.5s ease-out;
        transition: all 0.2s 0.5s ease-out;
    }

    .back-top {
        opacity: 0;
        transition: .5s;
        z-index: 100000;
        right: 30px;
        bottom: 30px;
        width: 48px;
        height: 48px;
    }

    #histats_counter {
        display: none;
    }

    /*SCREEN 640*/
    @media screen and (max-width: 767px) {
        #navbar {
            background: #024073;
            transition: 0.2s;
            padding: 0;
        }

        #main-site {
            padding-top: 118px;
        }
    }
</style>
@endsection
@section('script')
@parent

<div class="fixed-bottom d-flex bg-white d-block d-lg-none">
    <a style="line-height: 1.8em" class="px-3 font-20 d-block "
        href="sms:{{$realty_post->contact_phone_number ?? ''}}"><i class="fas fa-sms"></i></a>
    <a style="line-height: 1.8em" class="px-3 font-16 d-block "
        href="https://zalo.me/{{$realty_post->contact_phone_number ?? ''}}"><img src="{{ asset('images/zalo.png') }}"
            alt="zalo" style="width: 100%" title="zalo"></a>
    <a style="line-height: 1.8em" class="font-14 btn btn-success rounded-0 d-block w-100 call-to-us-detail"
        href="tel:{{$realty_post->contact_phone_number ?? ''}}"><i class="fas fa-phone-alt call-to-us-detail"></i>
        @if (is_numeric($realty_post->contact_phone_number ?? 0))
        0{{number_format($realty_post->contact_phone_number ?? 0, 0, ' ', ' ') ??''}}</a>
    @endif
    </a>
</div>

<script defer src="https://maps.googleapis.com/maps/api/js?key={{config('api_keys.google_map')}}&callback=initMap">
</script>
<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=369134871016071&autoLogAppEvents=1"
    nonce="KzqM94bd"></script>
{{-- <script src="https://sp.zalo.me/plugins/sdk.js"></script> --}}

<script src="{{asset('plugins/lightgallery/dist/js/lightgallery.min.js')}}"></script>

<script>
    hideBlockByHeight($('.post-description'), '200px');
$(document).on('click', '.show-hidden-block' , function(){
toggleHiddenBlock($('.post-description'), "200px");
if ($(this).data('open') == 2) {
$(this).data('open', 1);
$(this).html('<strong class="font-weight-500">Đóng </strong><i class="fas fa-chevron-up"></i>')
}else{
$(this).data('open', 2);
$(this).html('<strong class="font-weight-500">Mở rộng </strong><i class="fas fa-chevron-down"></i>')
}
})

lightGallery(document.querySelector('.lightgallery'), {
selector: '.item'
});

$('.realted-post-title span').each(function(){
maxText($(this), 50);
})

$('.realted-post-address').each(function(){
maxText($(this), 30);
})

@if(Agent::isDesktop())

$('.realted-post-slider2').owlCarousel({
loop:true,
// autoplay:true,
autoplayHoverPause:true,
margin: 10,
dots:false,
nav:true,
autoplaySpeed:1200,
autoplayTimeout:3000,
navText:["<div class='owl-nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"],
responsive:{
0:{
items:1,
},
600:{
items:2
},
1000:{

items:3
}
}
});

@endif



function initMap() {
@isset($realty_post->realty)
var current = {
lat: {{$realty_post->realty->google_map_lat ?? 0}},
lng: {{$realty_post->realty->google_map_lng ?? 0}},
};
@else
var current = {
lat:  0,
lng: 0
};
@endisset
}
$(document).ready(function(){
$('.btn-share').on('click', function(){
$('.share-btn-wraper').toggle();
})
})

$('.send-contact-btn').on('click', function(){
showPreloader();

var name = $('#customer-name').val();
var email = $('#customer-email').val();
var phone = $('#customer-phone').val();
var message = $('#customer-message').val();

$.ajax({
url : '/advisory/send-request-to-realty-owner',
type: 'POST',
data: {
name: name,
email: email,
phone: phone,
message: message,
link: "{{request()->url()}}",
realty_owner_email: "{{$realty_post->contact_email ?? ''}}",
},
success: function(data){
hidePreloader();

alert(data.msg);
},
error: function(error){
hidePreloader();

if (error.status == 422) {
console.log(error);
var errors = error.responseJSON.errors;
var error_string = '';
for (const [key, value] of Object.entries(errors)) {
error_string += value + '\n';
}
alert(error_string);
}
}
})
})

</script>
@endsection