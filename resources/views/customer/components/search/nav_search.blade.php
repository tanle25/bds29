
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
              <form action="" id="nav-form-search" method="POST">
                @csrf
                  <div class="search-type d-flex px-2">
                    <div class="search-type-item mr-1">
                        <input type="radio"  class="d-none" name="loai-tin-dang" value="1" id="realty-sell"
                            @isset($filter_search['loai-tin-dang'])
                                @if ($filter_search['loai-tin-dang'] == 1)
                                    checked
                                @endif
                                data_filter_search = "{{ $filter_search['loai-tin-dang'] }}"
                            @endisset

                            @isset($realty_post->type)
                                @if ($realty_post->type == 1)
                                    checked
                                @endif
                            @endisset
                        >
                        <label class="py-2 px-4 font-9 m-0 rounded" data-value="1" for="realty-sell"><strong>BDS BÁN</strong></label>
                    </div>
                    <div class="search-type-item">
                        <input class="d-none" type="radio" name="loai-tin-dang"  value="2" id="realty-rent"
                            @if(isset($filter_search['loai-tin-dang']))
                                @if ($filter_search['loai-tin-dang'] == 2)
                                    checked
                                @endif
                                
                                data-filter-search="{{ $filter_search['loai-tin-dang'] }}"
                            @elseif (isset($realty_post->type))
                                @if ($realty_post->type == 2)
                                    checked
                                @endif
                            @else
                                checked
                            @endif
                        >
                        <label class="py-2 px-4 m-0 font-9 rounded" for="realty-rent" data-value="2" class="cho_thue"><strong>BDS CHO THUÊ</strong></label>
                    </div>
                  </div>
                  <div class="search-field p-2 ">

                    <div class="search-criteria d-md-flex mt-2">
                        <div class="address-input form-group mb-2 border search-input pr-1">
                            <select class="realty-type form-control select2-hide-search select2-info" name="loai-bds" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option data-realty-post-type="1" value="" disabled>Loại nhà đất</option>
                                <option data-realty-post-type="2" value="">Loại nhà đất</option>
                                @foreach (config('constant.realty_post_type') as $type =>  $item)
                                    @foreach ($item['realty_type_list'] as  $realty_type)
                                        <option data-slug="{{config('constant.realty_type.'.$realty_type)['slug']}}" data-realty-post-type="{{$type}}" value="{{$realty_type}}" 
                                            @if ($type == 1) disabled @endif
                                            @isset($filter_search['loai-bds'])
                                                @if ($filter_search['loai-bds'] == $realty_type) selected @endif
                                            @endisset
                                        >{{config('constant.realty_type.'.$realty_type)['name']}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="address-input form-group mb-2 search-input">
                            <input type="text" class="form-control rounded-0" name="dia-chi" placeholder="Nhập địa chỉ"
                                @isset($filter_search['realty.full_address'])
                                    value="{{$filter_search['realty.full_address']}}"
                                @endisset
                            >
                        </div>
                        <div class="form-group mb-2 border search-input pr-1">
                            <select class="form-control select2-hide-search select2-info" id="nav_district" name="huyen" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Quận / Huyện</option>
                                @foreach ($featured_district as $district)
                                    <option data-slug="{{$district->slug}}" value="{{$district->code}}"
                                        @isset($filter_search['huyen'])
                                            @if ($filter_search['huyen'] == $district->code) selected @endif
                                        @endisset
                                    >{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2 border search-input pr-1">
                            <select class="form-control select2-hide-search select2-info" id="nav_project" name="du-an" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Dự án</option>
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
                        <div class="form-group mb-2 border search-input pr-1">
                            <select class="form-control select2-hide-search select2-info" id="nav_bedroom" name="so-phong-ngu" data-dropdown-css-class="select2-info" style="width: 100%;">
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
                        <div class="form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info nav-realty-price"  name="gia" data-dropdown-css-class="select2-info" style="width: 100%;">
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

                        <div class="hidden-field form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" id="nav_bathroom" name="so-ve-sinh" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="" selected="">Số vệ sinh</option>
                                <option value="1" 
                                    @isset($filter_search['so-ve-sinh'])
                                        @if ($filter_search['so-ve-sinh'] == 1) selected @endif
                                    @endisset
                                >1 vệ sinh</option>
                                <option value="2"
                                    @isset($filter_search['so-ve-sinh'])
                                        @if ($filter_search['so-ve-sinh'] == 2) selected @endif
                                    @endisset
                                >2 vệ sinh</option>
                                <option value="3"
                                    @isset($filter_search['so-ve-sinh'])
                                        @if ($filter_search['so-ve-sinh'] == 3) selected @endif
                                    @endisset
                                >3 vệ sinh</option>
                            </select>
                        </div>
                        <div class="hidden-field form-group mb-2 search-input border px-1">
                            <select class="form-control select2-hide-search select2-info" value="" id="nav_furniture" name="noi-that" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option value="">Nội thất</option>
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
                        <div class="px-2  mb-2 search-input border d-flex align-items-center" >
                            <div class="bg-white closed btn-expand-nav-search w-100 btn rounded-0 text-left">
                                <i class="fas fa-expand-arrows-alt"></i>
                                Thêm | Thu gọn
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

        function getProjects(district_code) {
            url = '/get-project-of-district/' + district_code;
            return $.ajax({
                url: url,
                typr: 'get',
            })
        }

        // function renderProject(data){
        //     var project_inputs = `<option value="0" selected>Dự án</option>`;
        //     if (data) {
        //         data.forEach(element => {
        //             project_inputs += `<option value="${element.id}" >${element.name}</option>`
        //         });
        //     }
        //     $('#nav_project').html(project_inputs);
        // }

        // $('#nav_district').on('change', function () {
        //     var district_code = $(this).val();
        //     getProjects(district_code)
        //         .done(function (data) {
        //             renderProject(data);
        //         });
        // })

        $(document).on('change', "[name='huyen']", function () {
            var district_code = $(this).val();
            var project_inputs = `<option value="" selected>Dự án</option>`;
            getProjects(district_code)
                .done(function (data) {
                    data.forEach(element => {
                        project_inputs += `<option value="${element.id}"  data-slug="${element.slug}" >${element.name}</option>`
                    });
                    $('#nav_project').html(project_inputs);
                });
        })

        //GEt district
        // function getDistricts(province_code) {
        //     url = '/get-district-of-province/' + province_code;
        //     return $.ajax({
        //         url: url,
        //         type: 'get',
        //     })
        // }

        // $('#nav_province').on('change', function () {
        //     console.log('hello');
        //     var province_code = $(this).val();
        //     var district_inputs = `<option value="" selected>Quận / huyện</option>`;
        //     getDistricts(province_code)
        //         .done(function (data) {
        //             data.forEach(element => {
        //                 district_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
        //             });
        //             $('#nav_district').html(district_inputs);
        //         });
        // })

        // function getCommunes(district_code) {
        //     url = '/get-commune-of-district/' + district_code;
        //     return $.ajax({
        //         url: url,
        //         type: 'get',
        //     })
        // }

        // $(document).on('change', "[name='huyen']", function () {
        //     var district_code = $(this).val();
        //     var commune_inputs = `<option value="" selected>Phường / xã</option>`;
        //     getCommunes(district_code)
        //         .done(function (data) {
        //             data.forEach(element => {
        //                 commune_inputs += `<option data-slug="${element.slug}" value="${element.code}" >${element.name_with_type}</option>`
        //             });
        //             $('#nav_commune').html(commune_inputs);
        //         });
        // })

        // Apply search
        function getQueryNav() {
            var data = $('#nav-form-search').serializeArray();
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
                var realtyTypeSlug = $('#nav_district option:selected').data('slug');
                queryElem.push(realtyTypeSlug)
            }
            if(result['du-an']){
                realty_slug = $('#nav_project option:selected').data('slug');
            }
            var slug = '/' + queryElem.join('-');
            var query = '';
            var validParam = ['so-phong-ngu', 'so-ve-sinh', 'du-an', 'gia', 'dia-chi', 'noi-that']
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
            $('#nav-form-search').attr('action',url)
            $('#nav-form-search').submit();
            // window.location = slug + query ;
            // console.log(url);
            
        }
        $(document).on('click', '#apply-nav-search', function () {
            getQueryNav();
            // console.log('test');
        })

        $('.search-type .cho_thue').trigger('click');
    </script>
@endsection
