@php
    if (!isset($filter_seach)) {
        $filter_seach = [];
    }
    if (!isset($search_address)) {
        $search_address = null;
    }
    if (!isset($realty_post)) {
        $realty_post = null;
    }
@endphp

@section('css')
    @parent
    <style>
        .search-input {
            position: relative;
            width: 150px;
        }

        @media screen and (max-width: 767px) {
            .search-input {
                /*position: relative;*/
                width: 100%;
            }
        }

    </style>
@endsection

<div class="border-bottom search-top d-none d-lg-block">
    <form action="" id="form-search" class="font-9" method="POST">
        @csrf
        <div class="search-type d-flex align-items-lg-center flex-lg-row flex-column justify-content-center w-100">
            <div class="mx-auto mx-md-0 d-none d-xl-flex">
                <div class="search-type-item d-flex align-items-center">
                    <input type="radio"  class="d-none" name="loai-tin-dang" value="1" id="realty-sell" 
                        @isset($filter_search['loai-tin-dang'])
                            @if ($filter_search['loai-tin-dang'] == 1)
                                checked
                            @endif
                        @else
                            checked
                        @endisset

                        @isset($realty_post->type)
                            @if ($realty_post->type == 1)
                                checked
                            @endif
                        @else
                            checked
                        @endisset
                    >
                    <label class="m-0 p-2 border border-right-0"  for="realty-sell">Bán</label>
                </div>
                <div class="search-type-item d-flex align-items-center">
                    <input class="d-none" type="radio" name="loai-tin-dang" value="2" id="realty-rent"
                        @isset($filter_search['loai-tin-dang'])
                            @if ($filter_search['loai-tin-dang'] == 2)
                                checked
                            @endif
                        @endisset

                        @isset($realty_post->type)
                            @if ($realty_post->type == 2)
                                checked
                            @endif
                        @endisset
                    >
                    <label class=" m-0 border p-2" for="realty-rent">Cho thuê</label>
                </div>
            </div>

            <div class="address-input p-3 border-right ">
                <input style="width:300px; max-width:100%" type="text" class="ipad_input form-control rounded-0" name="dia-chi" placeholder="Nhập địa chỉ"
                @isset($filter_search['realty.full_address'])
                    value="{{$filter_search['realty.full_address']}}"
                @endisset
                >
            </div>

            <div class="search-input px-2">
                <select class="form-control select2-hide-search select2-info" id="district" name="huyen" data-dropdown-css-class="select2-info" style="width: 100%;">
                <option value="">Quận / Huyện</option>
                    @foreach ($featured_district as $district)
                        <option data-slug="{{$district->slug}}" value="{{$district->code}}" 
                            @isset($filter_search['huyen'])
                                @if ($filter_search['huyen'] == $district->code) selected @endif
                            @endisset
                        >
                            {{$district->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="search-input px-2">
                <select class="form-control select2-hide-search select2-info" id="project" name="du-an" data-dropdown-css-class="select2-info" style="width: 100%;">
                <option value="">Dự án</option>
                    @isset($filter_search['huyen'])
                        @foreach ($listProjectOfDistrictFilter as $home_project)
                            <option data-slug="{{$home_project->slug}}" value="{{$home_project->id}}" 
                                @isset($filter_search['du-an'])
                                    @if($filter_search['du-an'] == $home_project->id) selected @endif
                                @endisset
                            >{{$home_project->name}}
                            </option>
                        @endforeach
                    @else
                        @foreach ($home_projects as $home_project)
                            <option data-slug="{{$home_project->slug}}" value="{{$home_project->id}}" 
                                @isset($filter_search['du-an'])
                                    @if($filter_search['du-an'] == $home_project->id) selected @endif
                                @endisset
                            >{{$home_project->name}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>

            <div class=" search-input px-2">
                <select class="form-control select2-hide-search select2-info" value="" id="bedroom" name="so-phong-ngu" data-dropdown-css-class="select2-info" style="width: 100%;">
                    <option value="" selected="">Số phòng ngủ</option>
                    <option value="1" 
                        @isset($filter_search['so-phong-ngu'])
                            @if ($filter_search['so-phong-ngu'] == 1) selected @endif
                        @endisset
                    >1 phòng ngủ</option>
                    <option value="1.5"
                        @isset($filter_search['so-phong-ngu'])
                            @if ($filter_search['so-phong-ngu'] == '1.5') selected @endif
                        @endisset
                    >1.5 phòng ngủ</option>
                    <option value="2"
                        @isset($filter_search['so-phong-ngu'])
                            @if ($filter_search['so-phong-ngu'] == 2) selected @endif
                        @endisset
                    >2 phòng ngủ</option>
                    <option value="3"
                        @isset($filter_search['so-phong-ngu'])
                            @if ($filter_search['so-phong-ngu'] == 3) selected @endif
                        @endisset
                    >3 phòng ngủ</option>
                    <option value="4"
                        @isset($filter_search['so-phong-ngu'])
                            @if ($filter_search['so-phong-ngu'] == 4) selected @endif
                        @endisset
                    >4 phòng ngủ</option>
                </select>
            </div>

            <div class=" search-input px-2">
                <select class="form-control select2-hide-search select2-info search-realty-price"  name="gia" data-dropdown-css-class="select2-info" style="width: 100%;">
                    <option value="">Giá</option>

                    @foreach (config('constant.realty_post_type') as $type_id => $realty_post_type)
                        @foreach ($list = $realty_post_type['price_range'] as $index => $range)
                            @if ($index < count($list) - 1 )
                                <option data-realty-post-type="{{$type_id}}"  name="gia" value="{{$list[$index] *1000000}},{{$list[$index + 1] * 1000000}}"

                                @isset($filter_search['price_between'])
                                    @if ($filter_search['price_between'] == $list[$index] *1000000 . ',' . $list[$index + 1] * 1000000)
                                    selected
                                    @endif
                                @endisset

                                @isset($filter_search['loai-tin-dang'])
                                    @if ($filter_search['loai-tin-dang'] != $type_id)
                                        disabled
                                    @endif
                                @endisset

                                >{{beautyPrice($list[$index] * 1000000)}} - {{beautyPrice($list[$index + 1] * 1000000)}}</option>
                            @else
                                <option data-realty-post-type="{{$type_id}}" name="gia" value="{{$list[$index] *1000000}},10000000000000"
                                @isset($filter_search['price_between'])
                                    @if ($filter_search['price_between'] == $list[$index] *1000000 . ',' . "10000000000000")
                                    selected
                                    @endif
                                @endisset

                                @isset($filter_search['loai-tin-dang'])
                                    @if ($filter_search['loai-tin-dang'] != $type_id)
                                        disabled
                                    @endif
                                @endisset

                                >Trên {{beautyPrice($list[$index] * 1000000)}}</option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class=" search-input px-2">
                <select class="form-control select2-hide-search select2-info" value="" id="furniture" name="noi-that" data-dropdown-css-class="select2-info" style="width: 100%;">
                    <option value="" selected="">Nội thất</option>
                    <option value="0" 
                        @isset($filter_search['noi-that'])
                            @if ($filter_search['noi-that'] == 0) selected @endif
                        @endisset
                    >Cơ bản</option>
                    <option value="1"
                        @isset($filter_search['noi-that'])
                            @if ($filter_search['noi-that'] == 1) selected @endif
                        @endisset
                    >Nguyên bản</option>
                    <option value="2"
                        @isset($filter_search['noi-that'])
                            @if ($filter_search['noi-that'] == 2) selected @endif
                        @endisset
                    >Full đồ</option>
                </select>
            </div>
            <button id="apply-search" type="button" class="btn btn-info font-9 rounded-0">Tìm kiếm</button>
        </div>
    </form>
</div>

@section('script')
	@parent
	<script>
        $(document).on('click', '.search-top .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        $("[name=loai-tin-dang]").on('change', function(){
            $postType = $(this).val();
            $(`.realty-type option`).prop('disabled', true);
            $(`.realty-type option[data-realty-post-type=${$postType}]`).prop('disabled', false);

            $(`.search-realty-price option`).prop('disabled', true);
            $(`.search-realty-price option[data-realty-post-type=${$postType}]`).prop('disabled', false);
        })
        // function getDistricts(province_code) {
        //     url = '/get-district-of-province/' + province_code;
        //     return $.ajax({
        //         url: url,
        //         type: 'get',
        //     })
        // }

        function getProjects(district_code) {
            url = '/get-project-of-district/' + district_code;
            return $.ajax({
                url: url,
                typr: 'get',
            })
        }

        function renderProject(data){
            var project_inputs = `<option value="" selected>Dự án</option>`;
            console.log(data);
            if (data) {
                data.forEach(element => {
                    project_inputs += `<option value="${element.id}" data-slug="${element.slug}" >${element.name}</option>`
                });
            }
            $('#project').html(project_inputs);
        }

        $('#district').on('change', function () {
            var district_code = $(this).val();
            getProjects(district_code)
                .done(function (data) {
                    renderProject(data);
                });
        })

        // function renderDistrict(data){
        //     var district_inputs = `<option value="0" selected>Quận / huyện</option>`;
        //     if (data) {
        //         data.forEach(element => {
        //             district_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
        //         });
        //     }
        //     $('#district').html(district_inputs);
        // }

        // $('#province').on('change', function () {
        //     var province_code = $(this).val();
        //     getDistricts(province_code)
        //         .done(function (data) {
        //             renderDistrict(data);
        //         });
        // })

        // function getCommunes(district_code) {
        //     url = '/get-commune-of-district/' + district_code;
        //     return $.ajax({
        //         url: url,
        //         type: 'get',
        //     })
        // }

        // function getRenderCommune(data){
        //     var commune_inputs = `<option value="0" selected>Phường / xã</option>`;
        //     data.forEach(element => {
        //         commune_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
        //     });
        //     $('#commune').html(commune_inputs);
        // }

        // $(document).on('change', "[name='huyen']", function () {
        //     var district_code = $(this).val();
        //     getCommunes(district_code)
        //         .done(function (data) {
        //             getRenderCommune(data);
        //         });
        // })

        function getQuery() {
            var data = $('#form-search').serializeArray();
            // console.log(data);
            let realty_slug ='';
            var result = {};
            data.forEach(function (item) {
                if (result[item.name]) {
                    result[item.name] += ',' + item.value;
                } else {
                    result[item.name] = item.value;
                }
            });

            var queryElem = [];
            if (result['loai-tin-dang']) {
                queryElem.push( result['loai-tin-dang'] == 2 ? 'cho-thue' : 'ban' )
            }

            if (result['loai-bds']) {
                var realtyTypeSlug = $('.realty-type option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }
            if(result['huyen']){
            var realtyTypeSlug = $('#district option:selected').data('slug');
            
            queryElem.push(realtyTypeSlug)
            }

            if(result['du-an']){
                realty_slug = $('#project option:selected').data('slug');
            }

            var slug = '/' + queryElem.join('-');
            var query = '';
            var validParam = ['so-phong-ngu', 'noi-that', 'du-an', 'gia', 'dia-chi']
            Object.entries(result).forEach(function (item, index) {
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
            let url = window.location.origin + slug

            if(realty_slug != ""){
                url += '/'+realty_slug
            }

            $('#form-search').attr('action',url)
            $('#form-search').submit();
        }
        $(document).on('click', '#apply-search', function () {
            getQuery();
        })
        $('.ms-search').on('click', function(e){
            e.stopPropagation();

        })

        $('.search-type').on('click', function(){
            var type = $(this).data('value');
            $('.price_range input').prop('checked', false);
            $('.price_range').hide();
            $(`.price_range[data-value=${type}]`).show();
        })

        $('.search-type[data-value=1]').trigger('click');

    </script>

@endsection
