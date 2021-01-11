@php
    if (!isset($filter_seach)) {
        $filter_seach = [];
    }
    if (!isset($search_address)) {
        $search_address = null;
    }
@endphp
<div class="border-bottom search-top d-none d-lg-block">
    <form action="" id="form-search" class="font-9">
        <div class="search-type d-flex align-items-lg-center flex-lg-row flex-column justify-content-center w-100">
            <div class="mx-auto mx-md-0 d-none d-xl-flex">
                <div class="search-type-item d-flex align-items-center">
                    <input type="radio"  class="d-none" name="loai-tin-dang"
                    @isset($filter_search['loai-tin-dang'])
                        @if ($filter_search['loai-tin-dang'] == 1)
                        checked
                        @endif
                    @else
                        checked
                    @endisset
                    value="1" id="realty-sell">
                    <label class="m-0 p-2 border border-right-0"  for="realty-sell">Bán</label>
                </div>
                <div class="search-type-item d-flex align-items-center">
                    <input class="d-none" type="radio" name="loai-tin-dang" value="2" id="realty-rent"
                    @isset($filter_search['loai-tin-dang'])
                        @if ($filter_search['loai-tin-dang'] == 2)
                        checked
                        @endif
                    @endisset
                    >
                    <label class=" m-0 border p-2" for="realty-rent">Cho thuê</label>
                </div>
            </div>

            <div class="address-input p-3 border-right">
                <input style="width:400px; max-width:100%" type="text" class=" form-control rounded-0" name="dia-chi" placeholder="Nhập địa chỉ"
                @isset($filter_search['realty.full_address'])
                    value="{{$filter_search['realty.full_address']}}"
                @endisset
                >
            </div>

            <div class="search-input px-2">
                <select class="form-control select2-hide-search select2-info" id="province" name="tinh" data-dropdown-css-class="select2-info" style="width: 100%;">
                <option value="0">Tỉnh / Thành phố</option>
                    @foreach ($provinces as $province)
                        <option data-slug="{{$province->slug}}" value="{{$province->code}}"
                            @isset($search_address->current_province)
                                @if ($search_address->current_province == $province->code)
                                selected
                                @endif
                            @endisset
                        >{{$province->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class=" search-input px-2">
                <select class="form-control select2-hide-search select2-info" value="" id="district" name="huyen" data-dropdown-css-class="select2-info" style="width: 100%;">
                    <option value="0" selected="">Quận / Huyện</option>
                    @isset($search_address )
                        @foreach ($search_address->districts ?? [] as $district)
                            <option data-slug="{{$district->slug}}" value="{{$district->code}}"
                            @if (isset($search_address->current_district) && $search_address->current_district == $district->code )
                                selected
                            @endif
                            >{{$district->name_with_type}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>

            <div class="search-input px-2">
                <select class="form-control select2-hide-search select2-info" value="" name="dien-tich" data-dropdown-css-class="select2-info" style="width: 100%;">
                    <option value="">Diện tích</option>
                    @foreach ($list =  config('constant.realty_area_range') as $index => $item)
                    <li>
                        @if ($index < count($list) - 1 )
                        <option value="{{$item}},{{$list[$index + 1]}}"
                        @isset($filter_search['realty.area_between'])
                            @if ($filter_search['realty.area_between'] == $item . "," .$list[$index + 1])
                            selected
                            @endif
                        @endisset
                        >{{$item}} m2 - {{$list[$index + 1]}} m2</option>
                        @else
                        <option value="{{$item}},10000"
                        @isset($filter_search['realty.area_between'])
                            @if ($filter_search['realty.area_between'] == $item . "," . "10000")
                            selected
                            @endif
                        @endisset
                        >Trên {{$item}} m2</option>
                        @endif
                        </span></label>
                    </li>
                    @endforeach
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

                                >{{\App\Helpers\CurrencyHelper::beautyPrice($list[$index] * 1000000)}} - {{\App\Helpers\CurrencyHelper::beautyPrice($list[$index + 1] * 1000000)}}</option>
                            @else
                                <option data-realty-post-type="{{$type_id}}" name="gia" value="{{$list[$index] *1000000}},10000000000000"
                                @isset($filter_search['price_between'])
                                    @if ($filter_search['price_between'] == $list[$index] *1000000 . ',' . "10000000000000")
                                    selected
                                    @endif
                                @endisset

                                >Trên {{\App\Helpers\CurrencyHelper::beautyPrice($list[$index] * 1000000)}}</option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="dropdown mr-3">
                <button class="btn text-dark font-9 dropdown-toggle bg-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Nâng cao
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3 shadow-10 border-0 p-3 " style="width:300px; z-index: 100" aria-labelledby="dropdownMenuButton">

                    <div class="">
                        <div>Loại tin rao</div>
                        <div class="border rounded form-group">
                            {{-- <i class="d-block fa fa-address-book" aria-hidden="true"></i> --}}
                            <select class="realty-type form-control border-0 select2-hide-search " style="width: 100%;" name="loai-bds">
                                <option data-realty-post-type="1" value="">Tất cả</option>
                                <option data-realty-post-type="2" value="">Tất cả</option>
                                @foreach (config('constant.realty_post_type') as $type =>  $item)
                                    @foreach ($item['realty_type_list'] as  $realty_type)
                                        <option data-slug="{{config('constant.realty_type.'.$realty_type)['slug']}}" data-realty-post-type="{{$type}}" value="{{$realty_type}}"
                                        @isset($filter_search['loai-bds'])
                                            @if ($filter_search['loai-bds'] == $realty_type)
                                            selected
                                            @endif
                                        @endisset
                                        >{{config('constant.realty_type.'.$realty_type)['name']}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="">Phường xã</label>
                        <div class="rounded border">
                            <select class="select2 select2-info" value="" id="commune" name="xa" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Tất cả</option>
                                @isset($search_address )
                                    @foreach ($search_address->communes ?? [] as $commune)
                                        <option data-slug="{{$commune->slug}}" value="{{$commune->code}}"
                                        @if (isset($search_address->current_commune) && $search_address->current_commune == $commune->code )
                                            selected
                                        @endif
                                        >{{$commune->name_with_type}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>

                    <div class="search-input mt-3">
                        <label for="">Dự án</label>
                        <div class="rounded border">
                            <select class="select2 select2-info" id="" value="" name="du-an" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Tất cả</option>
                            </select>
                        </div>
                    </div>

                    <div class="search-input mt-3">
                        <label for="">Hướng</label>
                        <div class="rounded border">
                            <select class="form-control select2-hide-search select2-info" value="" name="huong" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Tất cả</option>
                                @foreach (config('constant.direction') as $index => $item)
                                    <option value="{{$index}}"
                                    @isset($filter_search['huong'])
                                        @if ($filter_search['huong'] == $index)
                                        selected
                                        @endif
                                    @endisset
                                    >{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
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
        function getDistricts(province_code) {
            url = '/get-district-of-province/' + province_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        function renderDistrict(data){
            var district_inputs = `<option value="0" selected>Quận / huyện</option>`;
            if (data) {
                data.forEach(element => {
                    district_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
                });
            }
            $('#district').html(district_inputs);
        }

        $('#province').on('change', function () {
            var province_code = $(this).val();
            getDistricts(province_code)
                .done(function (data) {
                    renderDistrict(data);
                });
        })

        function getCommunes(district_code) {
            url = '/get-commune-of-district/' + district_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        function getRenderCommune(data){
            var commune_inputs = `<option value="0" selected>Phường / xã</option>`;
            data.forEach(element => {
                commune_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
            });
            $('#commune').html(commune_inputs);
        }

        $(document).on('change', "[name='huyen']", function () {
            var district_code = $(this).val();
            getCommunes(district_code)
                .done(function (data) {
                    getRenderCommune(data);
                });
        })

        function getQuery() {
            var data = $('#form-search').serializeArray();
            console.log(data);
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

            if (result['xa'] && result['xa'] != 0){
                var realtyTypeSlug = $('#commune option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }else if(result['huyen'] && result['huyen'] != 0){
                var realtyTypeSlug = $('#district option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }else if(result['tinh'] && result['tinh'] != 0){
                var realtyTypeSlug = $('#province option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }
            var slug = '/' + queryElem.join('-') + '?';
            var query = '';
            var validParam = ['dien-tich', 'du-an', 'huong', 'gia', 'dia-chi']
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
            window.location = slug + query ;
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
