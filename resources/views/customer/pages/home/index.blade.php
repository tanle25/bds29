@extends('customer.layouts.main')
@section('preset_seo')
    @php
    $custom_title = 'Trang chủ bất động sản' . config('constant.province_name');
    $custom_description = 'Trang chủ bất động sản' . config('constant.province_name');
    @endphp
@endsection

@section('css')
    @parent
    <style>
        .hidden-field {
            display: none;
        }
        span.clickeds {
            position: relative;
            padding-top: 80%;
            display: block;
        }
        img.img-rounded {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            object-fit: cover;
        }

        .search-input {
            position: relative;
            width: 20%;
        }

        .search-input>i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            font-size: 1.2em;
            z-index: 1000;
            color: rgb(87, 87, 87)
        }

        #overlay {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            background:black;
            background:rgba(0,0,0,0.4);

            filter:blur(4px);
            -o-filter:blur(4px);
            -ms-filter:blur(4px);
            -moz-filter:blur(4px);
            -webkit-filter:blur(4px);
        }

        @media screen and (max-width: 767px) {
            .search-input {
                /*position: relative;*/
                width: 100%;
            }
        }
        h1.font-weight-bold{
            font-size: 32px;
        }

    </style>
@endsection

@section('title')
    {{ $seo->title ?? 'Trang chủ' }}
@endsection

@section('title')
    Trang chủ
@endsection

@section('content')
    {{-- @include('customer.pages.home.contents.banner_home') --}}
    @php
    $banners = explode(',', $theme_options['Banner'] ?? '');
    $banner_mobile = explode(',', $theme_options['Banner_mobile'] ?? '');
    @endphp


    <section class="banner-home position-relative">
        @if (Agent::isMobile())
            <div class="banner-home-slider owl-carousel">
                @foreach ($banner_mobile as $item)
                    @if ($item)
                        <div class="item img-responsive">
                            <img class="lazy" data-src="{{ $item }}" src="{{$item}}" title="bất động sản 29" alt="bất động sản 29" srcset="" width="100%" height="250" >
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="banner-home-slider owl-carousel" style="z-index: 1">
                @foreach ($banners as $item)
                    @if ($item)
                        <div class="item w-100 banner-item">
                            <img data-src="{{ $item }}" class="lazy" alt="bất động sản 29" title="bất động sản 29" style="height: 100%; object-fit:cover"
                                srcset="">
                            <div id="overlay"></div>
                        </div>
                    @endif
                @endforeach
            </div>
            
        @endif

        <div class="container search-home clearfix pt-md-5 ">
            <div class="divtext text-center d-none d-md-block">
                <h1 class="text-uppercase text-white font-weight-bold"> BẤT ĐỘNG SẢN {{ config('constant.province_name') }} </h1>
                
            </div>
            <div class="section-filter-home d-none d-md-block">
                <form action="" id="form-search" method="POST">
                    @csrf
                    <div class="search-type d-flex">
                        <div class="search-type-item mr-1" id="nhadatban">
                            <input type="radio" class="d-none" name="loai-tin-dang" value="1" id="realty-sell">
                            <label class="py-2 px-4 font-9 m-0 rounded-top" for="realty-sell"><strong>NHÀ ĐẤT
                                    BÁN</strong></label>
                        </div>
                        <div class="search-type-item" id="nhadatthue">
                            <input class="d-none" type="radio" name="loai-tin-dang" checked value="2" id="realty-rent">
                            <label class="py-2 px-4 m-0 font-9 rounded-top" for="realty-rent" class="cho_thue">
                                <strong>NHÀ ĐẤT CHO THUÊ</strong>
                            </label>
                        </div>
                    </div>
                    <div class="search-field p-2 ">
                        <div class="pt-2">
                            <div class="search-field-header bg-white d-md-flex align-items-center mx-2">
                                <div class="d-md-flex search-criteria  search-input  align-items-center"
                                    style="flex: 0 0 calc(20%)">
                                    <i class="fal fa-car-building"></i>
                                    <select class="realty-type form-control border-0 select2 border-0" name="loai-bds">
                                        <option data-realty-post-type="1" value="" disabled>Loại nhà đất</option>
                                        <option data-realty-post-type="2" value="">Loại nhà đất</option>
                                        @foreach (config('constant.realty_post_type') as $type => $item)

                                            @foreach ($item['realty_type_list'] as $realty_type)
                                                <option
                                                    data-slug="{{ config('constant.realty_type.' . $realty_type)['slug'] }}"
                                                    data-realty-post-type="{{ $type }}"
                                                    value="{{ $realty_type }}" @if ($type == 1) disabled @endif>
                                                    {{ config('constant.realty_type.' . $realty_type)['name'] }}
                                                </option>
                                            @endforeach
                                            <?php //break; ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="address-input search-input">
                                    <i class="far fa-search "></i>
                                    <input type="text" class="form-control pl-5 rounded-0" name="dia-chi"
                                        placeholder="Nhập địa chỉ">
                                </div>
                                <button style="width:" id="apply-search" type="button" style="flex: 0 0 calc(20%)"
                                    class="d-none d-md-block  btn btn-info rounded-0">Tìm kiếm</button>
                            </div>
                        </div>



                        <div class="search-criteria d-flex mt-2">
                            <div class="form-group mb-2 py-2 search-input pl-2 pr-1">
                                <i class="fal fa-map-marked-alt ml-2"></i>
                                <select class="border form-control select2 select2-info" id="district" name="huyen"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">
                                    <option value="">Quận / Huyện</option>
                                    @foreach ($featured_district as $district)
                                        <option data-slug="{{ $district->slug }}" value="{{ $district->code }}">
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-2 py-2 search-input px-2 ">
                                <i class="fal fa-building ml-2"></i>
                                <select class="form-control select2 select2-info" id="project" name="du-an"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">
                                    <option value="" selected="">Dự án</option>
                                    @foreach ($home_projects as $home_project)
                                        <option data-slug="{{ $home_project->slug }}"
                                            value="{{ $home_project->province_code }}">{{ $home_project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group mb-2 py-2 search-input px-2 ">
                                <i class="fal fa-bed ml-2"></i>
                                <select class="form-control select2 select2-info" id="bedroom" value="" name="so-phong-ngu"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">

                                    <option value="" selected="">Số phòng ngủ</option>
                                    <option value="1" name="number-of-bed-room">1</option>
                                    <option value="1.5" name="number-of-bed-room">1.5</option>
                                    <option value="2" name="number-of-bed-room">2</option>
                                    <option value="3" name="number-of-bed-room">3</option>
                                    <option value="4" name="number-of-bed-room">4</option>
                                </select>

                            </div>

                            <div class="form-group mb-2 py-2 search-input px-2 ">
                                <i class="fal fa-usd-circle ml-2"></i>

                                {{-- thue --}}
                                <select class="form-control select2 select2-info realty-price" name="gia"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">
                                    @foreach (config('constant.realty_post_type') as $type_id => $realty_post_type)
                                        <option value="" @if ($type_id == 1) disabled @endif>Giá</option>
                                        @foreach ($list = $realty_post_type['price_range'] as $index => $range)
                                            @if ($index < count($list) - 1)
                                                <option data-realty-post-type="{{ $type_id }}" name="gia"
                                                    value="{{ $list[$index] * 1000000 }},{{ $list[$index + 1] * 1000000 }}"
                                                    @if ($type_id == 1) disabled @endif 
                                                >
                                                    {{ beautyPrice($list[$index] * 1000000) }} -
                                                    {{ beautyPrice($list[$index + 1] * 1000000) }}</option>
                                            @else
                                                <option data-realty-post-type="{{ $type_id }}" name="gia"
                                                    value="{{ $list[$index] * 1000000 }},10000000000000"
                                                    @if ($type_id == 1) disabled @endif
                                                >Trên
                                                    {{ beautyPrice($list[$index] * 1000000) }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach

                           
                                </select>


                            </div>

                            <div class="hidden-field form-group mb-2 py-2 search-input px-2 ">

                            </div>
                            <div class="hidden-field form-group mb-2 py-2 search-input pl-2 pr-1">
                                <i class="fal fa-toilet ml-2"></i>
                                <select class="form-control select2 select2-info" value="" id="bathroom" name="so-ve-sinh"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">
                                    <option value="" selected="">Số vệ sinh</option>
                                    <option value="1" name="">1</option>
                                    <option value="2" name="">2</option>
                                    <option value="3" name="">3</option>

                                </select>
                            </div>
                            <div class="hidden-field form-group mb-2 py-2 search-input px-2 ">
                                <i class="fal fa-couch ml-2"></i>
                                <select class="form-control select2 select2-info" value="" id="furniture" name="noi-that"
                                    data-dropdown-css-class="select2-info" style="width: 100%;">
                                    <option value="">Nội thất</option>
                                    <option value="0" name="option-noi-that">Nội thất cơ bản</option>
                                    <option value="1" name="option-noi-that">Nội thất nguyên bản</option>
                                    <option value="2" name="option-noi-that">Nội thất full đồ</option>

                                </select>
                            </div>

                            <div class="hidden-field px-2  form-group mb-2 py-2 search-input">

                            </div>
                            <div class="hidden-field px-2  form-group mb-2 py-2 search-input">

                            </div>
                            <div class="px-2  mb-2 py-2 search-input d-flex align-items-center">
                                <div class="bg-white closed btn-expand-search w-100 btn rounded-0 text-left border font-9">
                                    <i class="far fa-chevron-down"></i>
                                    Thêm
                                </div>
                            </div>
                            <button id="apply-search" type="button"
                                class=" d-block d-md-none btn btn-info px-5 mx-auto rounded">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('customer.pages.home.contents.list_bds_hot')


    <section class="random-realty py-3 py-lg-5 section hrm-bg-secondary">
        <div class="container">
            <div class="d-md-flex">
                <h2 class="font-18 font-weight-600 color-dark home-title">Bất động sản cho thuê</h2>
                <div class="ml-auto d-flex align-items-center ">
                    <a href="/cho-thue" class="px-md-2 secondary-text">Tin nhà đất cho thuê mới nhất</a>
                </div>
            </div>

            <ul class="row pt-3 type2 p-0">
                @foreach ($random_realties_type2 as $index => $item)
                    <li class="item col-md-3 my-2 wow fadeIn" data-wow-offset="1" data-wow-delay="{{ 0.1 * $index }}s">
                        @include('customer.components.realty_post.realty_block', ['item' => $item])
                    </li>
                @endforeach
                </ul>
        </div>
    </section>

    @isset($horizontal_advertisments)
        @include('customer.components.advertisments.horizontal', ['items' => $horizontal_advertisments, 'items_mobile' =>
        $mobile_horizontal_advertisments])
    @endisset
@endsection

@section('script')
    @parent
    <script>


        $('.btn-expand-search').on('click', function() {
            $('.hidden-field').toggle();
            if ($(this).hasClass('closed')) {
                console.log('hello');
                $(this).removeClass('closed');
                $(this).addClass('opened');
                $(this).html(`
                            <i class="far fa-chevron-up"></i> Thu gọn
                            `);
            } else if ($(this).hasClass('opened')) {
                $(this).removeClass('opened');
                $(this).addClass('closed');
                $(this).html(`
                            <i class="far fa-chevron-down"></i> Thêm
                            `);
            }
        })

        $("[name=loai-tin-dang]").on('change', function() {
            $postType = $(this).val();
            $(`.realty-type option`).prop('disabled', true);
            $(`.realty-type option[data-realty-post-type=${$postType}]`).prop('disabled', false);

            $(`.realty-price option`).prop('disabled', true);
            $(`.realty-price option[data-realty-post-type=${$postType}]`).prop('disabled', false);
        })


        function getProjects(district_code) {
            url = '/get-project-of-district/' + district_code;
            return $.ajax({
                url: url,
                typr: 'get',
            })
        }

        function renderProject(data) {
            var project_inputs = `<option value="" selected>Dự án</option>`;
            console.log(data);
            if (data) {
                data.forEach(element => {
                    project_inputs += `<option value="${element.id}" >${element.name}</option>`
                });
            }
            $('#project').html(project_inputs);
        }

        $('#district').on('change', function() {
            var district_code = $(this).val();
            getProjects(district_code)
                .done(function(data) {
                    renderProject(data);
                });
        })

        function getQuery() {
            var data = $('#form-search').serializeArray();
            var result = {};
            data.forEach(function(item) {
                if (result[item.name]) {
                    result[item.name] += ',' + item.value;
                } else {
                    result[item.name] = item.value;
                }

            });

            var query = '/tim-kiem?';
            var queryElem = [];
            if (result['loai-tin-dang']) {
                queryElem.push(result['loai-tin-dang'] == 2 ? 'cho-thue' : 'ban')
            }
            if (result['loai-bds']) {
                var realtyTypeSlug = $('.realty-type option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }
            if (result['huyen']) {
                var realtyTypeSlug = $('#district option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }
            var slug = '/' + queryElem.join('-');
            var query = '';
            var validParam = ['so-phong-ngu', 'so-ve-sinh', 'du-an', 'gia', 'dia-chi', 'noi-that']
            Object.entries(result).forEach(function(item, index) {
                if (validParam.includes(item[0])) {
                    if (query === '' && item[1] != '') {
                        query += item[0] + '=' + item[1];
                        return
                    };

                    if (query !== '' && item[1] != '') {
                        query += '&' + item[0] + '=' + item[1];
                        return
                    }
                }
            });

            let url = "{{url('/')}}"+ slug;
            $('#form-search').attr('action',url)
            $('#form-search').submit();
        }
        $(document).on('click', '#apply-search', function() {
            getQuery();
        })

        $('.ms-search').on('click', function(e) {
            e.stopPropagation();
        })


        $('.search-type label').on('click', function() {
            var type = $(this).data('value');
            // $('.price_range input').prop('checked', true);
            $('.price_range').hide();
            $(`.price_range[data-value=${type}]`).show();
        })
        $('.search-type .cho_thue').trigger('click');

        $('.banner-home-slider').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayHoverPause: true,
            dots: false,
            nav: true,
            navText: ["<div class='owl-nav-btn banner-nav prev-slide'><i class='fas fa-chevron-left'></i></div>",
                "<div class='owl-nav-btn next-slide banner-nav'><i class='fas fa-chevron-right'></i></div>"
            ],
            autoplayTimeout: 10000,
            autoplaySpeed: 1000,
            smartSpeed: 1000,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 1,
                },
            }
        });


        $('.horizon-advertisment').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: false,
            nav: false,
            autoplayTimeout: 10000,
            autoplaySpeed: 1000,
            smartSpeed: 1000,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 1,
                },
            }
        });

        $('.vertical-advertisment').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: false,
            nav: false,
            autoplayTimeout: 10000,
            autoplaySpeed: 1000,
            smartSpeed: 1000,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 1,
                },
            }
        });

        $('.partner-slider').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dot: false,
            autoplay: true,
            slideTransition: 'linear',
            smartSpeed: 3000,
            autoplayTimeout: 3050,
            navText: ["<div class='owl-nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>",
                "<div class='owl-nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"
            ],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 6
                }
            }
        })

    </script>
@endsection
