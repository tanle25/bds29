<div class="p-3 rounded bg-white border">
    <h3 class="font-12 py-2 border-bottom">
        Nhà đất tại {{config('constant.province_name') ?? 'Thanh Hóa'}}
    </h3>
    <div class="">
        @foreach ($featured_district as $item)
            <a class="d-block secondary-text py-1 font-9" href="/cho-thue-{{$item->slug}}">{{$item->name_with_type}} ({{$item->realty_posts_count}})</a>
        @endforeach
    </div>
</div>

@if (!empty($links))
    @if ( $links[count($links) - 1]['name'] == 'Quận Cầu Giấy')
        <div class="p-3 my-3 rounded bg-white border">
            <h3 class="font-12 py-2 border-bottom">
                Liên kết nổi bật
            </h3>
            <div class="">
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=67">Cho thuê căn hộ FLC 265 Cầu Giấy</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=65">Cho thuê căn hộ Home City Trung Kính</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=66">Cho thuê căn hộ Central Field 219 Trung Kính</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=104">Cho thuê căn hộ Discovery Complex</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=155">Cho thuê căn hộ Golden Park Tower</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=71">Cho thuê căn hộ Luxury Park View</a>
                <a class="d-block secondary-text py-1 font-9" href="http://bds29.net/cho-thue-cau-giay-ha-noi?du-an=158">Cho thuê căn hộ Center Point 110 Cầu Giấy</a>
            </div>
        </div>
    @endif
@endif


@section('script')
    @parent
    <script>
        $('.sidebar-post-link').each(function(){
            maxText($(this), 60);
        })
    </script>
@endsection
