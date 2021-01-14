@extends('customer.layouts.main')

@section('preset_seo')
    @php
        $custom_title = 'Trang chủ bất động sản Tây Ninh';
        $custom_description = 'Trang chủ bất động sản Tây Ninh';
    @endphp
@endsection

@section('title')
  {{$seo->title ?? 'Trang chủ'}}
@endsection

@section('title')
Trang chủ
@endsection

 @section('content')
    @include('customer.pages.home.contents.banner_home')
    @include('customer.pages.home.contents.list_bds_hot')
    @include('customer.pages.home.contents.home_post_v2')
    @include('customer.pages.home.contents.hot_realty')
    @if($home_projects->isNotEmpty())
        @include('customer.pages.home.contents.home_project_v2')
    @endif
    <section class="container">
        <div class="d-flex">
            <h3 class="font-18 font-weight-600 home-title color-dark">Doanh nghiệp nổi bật</h3>
        </div>
        <div class="owl-carousel partner-slider mb-5">
            @foreach ($partners as $partner)
                <div class="item d-flex align-items-center  p-2" style="height: 120px;" >
                    <div class="w-100 border h-100 p-2 partner-item">
                        <img class="lazy" style="height: 100%; object-fit:contain" data-src="{{$partner->logo}}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @isset($horizontal_advertisments)
        @include('customer.components.advertisments.horizontal', ['items' => $horizontal_advertisments, 'items_mobile' => $mobile_horizontal_advertisments])
    @endisset
@endsection

@section('script')
@parent
<script>
    $('.horizon-advertisment').owlCarousel({
        loop:true,
        autoplay: true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots:false,
        nav:false,
        autoplayTimeout:10000,
        autoplaySpeed:1000,
        smartSpeed:1000,
        animateOut: 'fadeOut',
        responsive:{
            0:{
                items:1,
            },
        }
    });

    $('.vertical-advertisment').owlCarousel({
        loop:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots:false,
        nav:false,
        autoplayTimeout:10000,
        autoplaySpeed:1000,
        smartSpeed:1000,
        animateOut: 'fadeOut',
        responsive:{
            0:{
                items:1,
            },
        }
    });

    $('.partner-slider').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    dot:false,
    autoplay:true,
    slideTransition: 'linear',
    smartSpeed:3000,
    autoplayTimeout:3050,
    navText:["<div class='owl-nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"],
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})
</script>
@endsection

