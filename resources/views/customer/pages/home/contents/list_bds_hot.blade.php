<section class="bds-noibat py-3 py-lg-5 section hrm-bg-secondary">
	<div class="container">
		<div class="entry-head text-center pb-2 d-flex  justify-content-between align-items-center">
            <h2 class="home-title">Bất động sản nổi bật</h2>
            <a href="/bat-dong-san" class="text-dark">Xem tất cả <i class="fas fa-long-arrow-alt-right"></i></a>
		</div>
		<div class="tab-bds">
			<div class="type-listing owl-carousel ">
                @foreach ($featured_district as $index => $item)
                <div class="item-district bg-light">
                    <span class="@if($index == 0) clicked  @endif font-500 font-9 btn btn-outline-info rounded-0" href="/api/get-realty-post?filter[huyen]={{$item->code}}">{{$item->name_with_type}}</span>
				</div>
                @endforeach
			</div>
			<div class="mt-3">
				<div id="" >
					<div class="bds-hot-district rounded-top">
						<div class="slider-bds-hot owl-carousel p-2">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@section('script')
    @parent
    <script>
        $(document).ready(function(){
            // List featured Realty
            function renderFeaturedRealtySlider(data){
                data = data.slice(0,5);
                $('.bds-hot-district').html(`<div class="${isMobile() ? "" :  'slider-bds-hot owl-carousel'} list-realty"></div>`);
                data.forEach((item, index) => {
                    let is_featured = false;
                    if(featured_realties.includes(item.post_id)){
                        is_featured = true;
                    };
                    var ribbon = '';
                    var titleColor = '';
                    switch (item.post_rank) {
                        case "3":
                        titleColor = 'text-info';
                        ribbon = `
                                <div class="ribbon-wrapper ribbon">
                                    <div class="ribbon bg-info font-6 text-white">
                                    Vip
                                    </div>
                                </div>
                                `
                            break;
                        case "4":
                        titleColor = 'text-danger';
                        ribbon =`
                                <div class="ribbon-wrapper ribbon">
                                    <div class="ribbon bg-danger font-6 text-white">
                                    Nổi bật
                                    </div>
                                </div>
                                `
                            break
                        default:
                            break;
                    }
                    var element= `
                    <div class="block realty ${isMobile() ? 'mt-3' : ''}">
                        <div class="realty-container flex-wrap border rounded d-flex d-md-block">
                            <div class="overflow-hidden col-5 px-0 col-md-12 order-2 bg-white">
                                <a href="${item.link}"class="d-block ml-2 ml-md-0 img-wraper height-md-180 height-120">
                                    <img src="${item.thumb}" alt="" srcset="">
                                </a>
                                ${ribbon}

                            </div>
                            <div class="order-1 col-12 bg-white px-2 pt-2 pb-md-0 pb-2">
                                <a href="${item.link}" class="d-block main-text hrm-truncate" style="height: 2.6em; line-height: 1.2em">
                                    <span class="font-9 ${titleColor}" style="font-weight: 500">${item.title}</span>
                                </a>
                            </div>
                            <div class="realty-body col-7 col-md-12  bg-white order-3 px-2">
                                <div class="font-9 pt-2">
                                    ${item.commune}, ${item.district}
                                </div>
                                <div class="imeta-3 text-muted mt-2 font-9">
                                    <span><i class="fa fa-compass"></i> <span class="border-right pr-1">${item.direction}</span></span>
                                    <span><i class="fa fa-bed"></i> <span class="border-right px-1">${item.number_of_bed_rooms ? item.number_of_bed_rooms: ''}</span></span>
                                    <span class="pl-1"><i class="fa fa-bath"></i> <span>${item.number_of_bath_rooms ? item.number_of_bath_rooms : ''}</span></span>
                                </div>
                                <div class="d-flex justify-content-between text-info py-1 font-9">
                                    <span class="font-weight-500"><i class="fas fa-dollar-sign"></i>${item.string_price}</span>
                                    <span class="font-weight-500"><i class="fas fa-expand"></i> ${item.area} m²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $('.list-realty').append(element);
                });
                wow.init();
                $('.slider-bds-hot').owlCarousel({
                    loop:true,
                    autoplay:true,
                    autoplayTimeout:2000,
                    autoplayHoverPause:true,
                    margin: 20,
                    dots:false,
                    nav:true,
                    autoplayTimeout:3000,
                    autoplaySpeed:1200,
                    smartSpeed:1200,
                    navText:["<div class='owl-nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>","<div class='owl-nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"],
                    responsive:{
                        0:{
                            items:1,
                        },
                        600:{
                            items:3
                        },
                        1000:{

                            items:4
                        }
                    }
                });
            }
            $('.item-district span').on('click', function(e){
                $('.item-district span').removeClass('clicked');
                $(this).addClass('clicked');
                e.preventDefault();
                var url = $(this).attr('href') + '&random=8';
                getRealtyFromApi(url)
                .done(function(data){
                    renderFeaturedRealtySlider(data);
                });
            })
            $('.item-district > span:first').trigger('click');
        })
    </script>
@endsection
