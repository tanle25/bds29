<nav id="nav-search" class="modal d-md-none">
    <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tìm kiếm Bất động sản</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
              <form action="" id="nav-form-search">
                  <div class="search-type d-flex px-2">
                      <div class="search-type-item mr-1">
                          <input type="radio"  class="d-none" name="loai-tin-dang" value="1" id="realty-sell">
                          <label class="py-2 px-4 font-9 m-0 rounded" data-value="1" for="realty-sell"><strong>BDS BÁN</strong></label>
                      </div>
                      <div class="search-type-item">
                          <input class="d-none" type="radio" name="loai-tin-dang" checked value="2" id="realty-rent">
                          <label class="py-2 px-4 m-0 font-9 rounded" for="realty-rent" data-value="2"><strong>BDS CHO THUÊ</strong></label>
                      </div>
                  </div>
                  <div class="search-field p-2 ">

                    <div class="search-criteria d-md-flex mt-2">
                        <div class="address-input form-group mb-2 border search-input">
                            <select class="realty-type form-control border-0 select2-hide-search border-0" name="loai-bds">
                                <option data-realty-post-type="1" value="">Loại nhà đất</option>
                                <option data-realty-post-type="2" value="">Loại nhà đất</option>
                                @foreach (config('constant.realty_post_type') as $type =>  $item)
                                    @foreach ($item['realty_type_list'] as  $realty_type)
                                        <option data-slug="{{config('constant.realty_type.'.$realty_type)['slug']}}" data-realty-post-type="{{$type}}" value="{{$realty_type}}">{{config('constant.realty_type.'.$realty_type)['name']}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="address-input form-group mb-2 search-input">
                            <input type="text" class="form-control rounded-0" name="dia-chi" placeholder="Nhập địa chỉ" >
                        </div>
                        <div class="form-group mb-2 border search-input pr-1">
                            <select class="form-control select2-hide-search select2-info" id="nav_province" name="tinh" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Tỉnh / Thành phố</option>
                                @foreach ($provinces as $province)
                                    <option data-slug="{{$province->slug}}" value="{{$province->code}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info nav-realty-price"  name="gia" data-dropdown-css-class="select2-info" style="width: 100%;">
                                @foreach (config('constant.realty_post_type') as $type_id => $realty_post_type)
                                    <option value="">Giá</option>
                                    @foreach ($list = $realty_post_type['price_range'] as $index => $range)
                                        @if ($index < count($list) - 1 )
                                            <option data-realty-post-type="{{$type_id}}"  name="gia" value="{{$list[$index] *1000000}},{{$list[$index + 1] * 1000000}}">{{\App\Helpers\CurrencyHelper::beautyPrice($list[$index] * 1000000)}} - {{\App\Helpers\CurrencyHelper::beautyPrice($list[$index + 1] * 1000000)}}</option>
                                        @else
                                            <option data-realty-post-type="{{$type_id}}" name="gia" value="{{$list[$index] *1000000}},10000000000000">Trên {{\App\Helpers\CurrencyHelper::beautyPrice($list[$index] * 1000000)}}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" name="dien-tich" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Diện tích</option>
                                @foreach ($list =  config('constant.realty_area_range') as $index => $item)
                                <li>
                                    @if ($index < count($list) - 1 )
                                    <option value="{{$item}},{{$list[$index + 1]}}">{{$item}} m2 - {{$list[$index + 1]}} m2</option>
                                    @else
                                    <option value="{{$item}},10000">Trên {{$item}} m2</option>
                                    @endif
                                    </span></label>
                                </li>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" name="huong" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Hướng</option>
                                @foreach (config('constant.direction') as $index => $item)
                                    <option value="{{$index}}" >{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" id="nav_district" name="huyen" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Quận / Huyện</option>

                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" id="nav_commune" name="xa" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Phường / xã</option>
                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" id="" value="" name="du-an" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Dự án</option>
                            </select>
                        </div>
                        <div class="px-2  mb-2 search-input border d-flex align-items-center" >
                            <div class="bg-white closed btn-expand-nav-search w-100 btn rounded-0 text-left">
                                <i class="fas fa-expand-arrows-alt"></i>
                                Thêm
                            </div>
                        </div>
                      </div>
                  </div>
              </form>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button id="apply-nav-search" type="button" class="mx-auto btn btn-info px-5"><i class="far fa-search"></i> Tìm kiếm</button>
          </div>
        </div>
    </div>
</nav>

@section('script')
@parent
    <script>
         $('.btn-expand-nav-search').on('click', function(){
            $('.hidden-field').toggle();
        })

        $("[name=loai-tin-dang]").on('change', function(){
            $postType = $(this).val();
            $(`.realty-type option`).prop('disabled', true);
            $(`.realty-type option[data-realty-post-type=${$postType}]`).prop('disabled', false);

            $(`.nav-realty-price option`).prop('disabled', true);
            $(`.nav-realty-price option[data-realty-post-type=${$postType}]`).prop('disabled', false);
        })

        //GEt district
        function getDistricts(province_code) {
            url = '/get-district-of-province/' + province_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        $('#nav_province').on('change', function () {
            console.log('hello');
            var province_code = $(this).val();
            var district_inputs = `<option value="" selected>Quận / huyện</option>`;
            getDistricts(province_code)
                .done(function (data) {
                    data.forEach(element => {
                        district_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
                    });
                    $('#nav_district').html(district_inputs);
                });
        })

        function getCommunes(district_code) {
            url = '/get-commune-of-district/' + district_code;
            return $.ajax({
                url: url,
                type: 'get',
            })
        }

        $(document).on('change', "[name='huyen']", function () {
            var district_code = $(this).val();
            var commune_inputs = `<option value="" selected>Phường / xã</option>`;
            getCommunes(district_code)
                .done(function (data) {
                    data.forEach(element => {
                        commune_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
                    });
                    $('#nav_commune').html(commune_inputs);
                });
        })

        // Apply search
        function getQueryNav() {
            var data = $('#nav-form-search').serializeArray();
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

            if (result['xa']){
                var realtyTypeSlug = $('#nav_commune option:selected').data('slug');
                queryElem.push(realtyTypeSlug);
            }else if(result['huyen']){
                var realtyTypeSlug = $('#nav_district option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }else if(result['tinh']){
                var realtyTypeSlug = $('#nav_province option:selected').data('slug');
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
        $(document).on('click', '#apply-nav-search', function () {
            getQueryNav();
        })

        $('.search-type label:first').trigger('click');
    </script>
@endsection
