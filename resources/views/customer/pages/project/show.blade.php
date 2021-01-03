@extends('customer.layouts.main')

@section('title')
{{$project->name}}
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/lightgallery/dist/css/lightgallery.min.css')}}">

@endsection
@section('content')
<div class="page-details project-detail pt-5 hrm-bg-secondary">
	<div class="container">
		<div class="row">
			<div class="col-md-8 bg-white py-3 mb-5">
                <div class="feature">
                    <div class="thumnail">
                        <div id="big" class="lightgallery thumnail-big owl-carousel owl-theme">
                            @foreach ($project->overview_image_array ?? [] as $img)
                            <div data-src="{{$img}}" class="item embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item rounded" src="{{$img}}" alt="">
                            </div>
                            @endforeach
                        </div>
                        <div id="thumbs" class="thumnail-thumbs owl-carousel owl-theme mt-2">
                            @foreach ($project->overview_image_array ?? [] as $img)
                            <div class="item embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item rounded" src="{{$img}}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

				<div class="content-detail mt-4">
                    <div class=" pl-0">
                        <div class="breadcrumbs">
                            <a class="secondary-text" href="/">Trang chủ</a>
                            / <a class="secondary-text" href="/du-an-bat-dong-san">Dự án</a>
                            / <a class="main-text" href="#">{{$project->name}}</a>
                        </div>
                    </div>
                    <h1 class="text-dark font-15 entry-title mb-3">{{$project->name ?? 'Đang cập nhật'}}</h1>
                    <div class=" pb-4 mb-4 font-10">
                        <div class="py-2">{{$project->full_address}}</div>
                        <span class="mr-3">
                            Trạng thái: <strong class="main-blue">{{config('constant.project_status.'. $project->status)['name'] ?? 'Đang cập nhật'}}</strong>
                        </span>
                        <span class="mr-3">
                            Chủ đầu tư: <strong>{{$project->investor}}</strong>
                        </span>
                        <span class="">
                            Khoảng giá:
                            <strong>
                                @if ($project->min_price && $project->max_price)
                                {{\App\Helpers\CurrencyHelper::beautyPrice($project->min_price)}} - {{\App\Helpers\CurrencyHelper::beautyPrice($project->max_price)}}
                                @else
                                    Đang cập nhật
                                @endif
                            </strong>
                        </span>
                    </div>
                    <div class="py-4 d-md-flex justify-content-between align-items-center border-bottom border-top">
                        <div class="d-flex">
                            <div class="pr-3">
                                <p class="mb-1" >Mức giá</p>
                                <strong class="font-12">
                                    @if ($project->min_price && $project->max_price)
                                    {{\App\Helpers\CurrencyHelper::beautyPrice($project->min_price)}} - {{\App\Helpers\CurrencyHelper::beautyPrice($project->max_price)}}
                                    @else
                                        Đang cập nhật
                                    @endif
                                </strong>
                            </div>
                            <div class="px-3">
                                <p class="mb-1" >Diện tích xây dựng</p>
                                <strong class="font-12"> {{$project->site_area . ' m2' ?? 'Đang cập nhật'}}</strong>
                            </div>
                            <div class="pl-3">
                                <p class="mb-1" >Bàn giao</p>
                                <strong class="font-12">
                                    {{\Carbon\Carbon::parse($project->launch_time)->format('d/m/Y') ?? 'Đang cập nhật'}}
                                </strong>
                            </div>
                        </div>
                        <div>
                            <div class="group-btn share-group">
                                @include('customer.components.share_button')
                                <a class="btn btn-map" data-toggle="modal" data-target="#show-map"><i class="far fa-map-marker font-12"></i> Vị trí</a>
                            </div>
                        </div>
                    </div>
				</div>
				<div id="menu-project" class="menucontent menu-project my-3">
					<a class="font-14 secondary-text pr-3 py-2" href="#info">Thông tin</a>
					<a class="font-14 secondary-text px-3 py-2 " href="#gallery">Hình ảnh</a>
					<a class="font-14 secondary-text px-3 py-2 " href="#rental">BĐS THUÊ ({{$project->rent_realty->count()}})</a>
					<a class="font-14 secondary-text px-3 py-2 " href="#vendor">BĐS BÁN ({{$project->sell_realty->count()}})</a>
				</div>
				<div class="panel-group boxwidget" id="accordion">
					<div class="panel pt-2">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#info">Tổng quan <span class="triangle"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
							</h4>
						</div>
						<div id="info" class="panel-collapse">
							<div class="panel-body">
                                {!! $project->description !!}
							</div>
						</div>
					</div>
					<div class="panel pt-2">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#location">Vị trí hạ tầng <span class="triangle"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
							</h4>
						</div>
						<div id="location" class="panel-collapse">
							<div class="panel-body">
                                <div>
                                    {!! $project->location_description !!}
                                </div>
							</div>
						</div>
                    </div>
                    <div id="gallery" class="pt-2 panel picture page-section">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#picture">Sơ đồ dự án <span class="triangle"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
							</h4>
						</div>
						<div id="picture" class="panel-collapse">
							<div class="panel-body">
								<ul class="nav nav-tabs menucontent">
                                    <li class="py-2 pr-3"><a data-toggle="tab" href="#ground_total" class="active">Sơ đồ tổng thế</a></li>
                                    @foreach ($project->grounds as $item)
                                    <li class="py-2 px-3"><a data-toggle="tab" href="#ground{{$item->id}}">{{$item->name}}</a></li>
                                    @endforeach
								</ul>
								<div class="tab-content mt-3">
                                    <div id="ground_total" class="active tab-pane over-all-diagram">
										<div class="row">
                                            <div class="col-md-3">
                                                <div href="{{$project->over_all_diagram_array[0] ?? ''}}" class="img-wraper item">
                                                    <img src="{{$project->over_all_diagram_array[0] ?? ''}}" alt="" />
                                                </div>
                                            </div>
										</div>
									</div>
                                    @foreach ($project->grounds as $item)
                                    <div id="ground{{$item->id}}" class="tab-pane fade">
										<div class="row">
                                            @foreach ($item->image_array as $item)
                                                <div class="col-md-3">
                                                    <div class="item">
                                                        <div href="{{$item}}" class="img-wraper item" >
                                                            <img src="{{$item}}" alt="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
										</div>
									</div>
                                    @endforeach
								</div>
							</div>
						</div>
                    </div>
					<div class="panel pt-2">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#investor">Chủ đầu tư <span class="triangle"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
							</h4>
						</div>
						<div id="investor" class="panel-collapse">
							<div class="panel-body">
                                {{$project->investor}}
                            </div>
						</div>
					</div>
				</div>
				<div id="rental" class="rental page-section">
					<div class="entry-head text-center pb-2 d-flex  justify-content-between align-items-center">
                        <h2 class="font-14 home-title">Bất động sản nổi cho thuê</h2>
                        <a href="/{{config('constant.realty_post_type.2.slug')}}-{{$project->slug}}" class="text-dark">Xem tất cả <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
					<div class="list-project">
						<div class="list-rental owl-carousel">
                            @foreach ($project->rent_realty as $item)
                                <div class="item p-2">
                                    @include('customer.components.realty_post.realty_block', ['item' => $item])
                                </div>
                            @endforeach
						</div>
					</div>
				</div>
				<div id="vendor" class="vendor page-section pt-3">
					<div class="entry-head text-center pb-2 d-flex  justify-content-between align-items-center">
                        <h2 class="font-14 home-title">Bất động sản bán</h2>
                        <a href="/{{config('constant.realty_post_type.1.slug')}}-{{$project->slug}}" class="text-dark">Xem tất cả <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
					<div class="list-project">
						<div class="list-vendor owl-carousel">
                            @foreach ($project->sell_realty as $item)
                                <div class="item p-2">
                                    @include('customer.components.realty_post.realty_block', ['item' => $item])
                                </div>
                            @endforeach
						</div>
					</div>
				</div>
            </div>
            <div class="col-md-4">
                @include('customer.components.sidebars.realty_sidebar')
            </div>
		</div>
	</div>
</div>
@endsection

@section('script')
    @parent
    <script src="{{asset('plugins/lightgallery/dist/js/lightgallery.min.js')}}"></script>
    <script>

        lightGallery(document.querySelector('.lightgallery'), {
            selector: '.item'
        });

        lightGallery(document.querySelector('.over-all-diagram'), {
            selector: '.item'
        });

        @foreach ($project->grounds as $item)
        lightGallery(document.getElementById("ground{{$item->id}}"), {
            selector: '.item'
        });
        @endforeach

        $('.list-rental, .list-vendor').owlCarousel({
            items: 3,
            loop: true,
            margin: 0,
            dots: false,
            nav: false,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplaySpeed: 1200,
            smartSpeed: 1200,
        });
    </script>
@endsection
