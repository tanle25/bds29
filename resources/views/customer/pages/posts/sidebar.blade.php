@section('css')
@parent
<style>
    .sidebar-post-link{
        color: #222d44;
        font-weight: 600;
    }
    .font-24{
        font-size: 24px !important;
    }
</style>
@endsection

<div class="col-md-4 sidebar">
    {{-- Chuyên mục được yêu thích --}}
    {{-- @isset($featured_posts)
    <div class="rounded-1 bg-white p-3 mb-3 border-bottom" >
        <h4 class="font-w-600 uppercase">Tin xem nhiều nhất</h4>
        @foreach ($featured_posts->take(5) as $item)
        <div class="d-flex py-3 border-top">
            <a class="flex-fixed-width rounded-1 mr-3 img-wraper" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}" class="rounded-1" style="width: 125px">
                <img style="width: 100px; height:70px" src="{{$item->thumb}}" alt="{{$item->name}}">
            </a>
            <div>
                <a class="font-10 secondary-text sidebar-link" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}"> {{$item->name}} </a>
            </div>
        </div>
        @endforeach
    </div>
    @endisset --}}

    @isset($featured_districts)
    <div class="rounded-1 bg-white p-3 mb-3 border-bottom" >
        <h3 class="uppercase font-w-600 font-24">Mua bán nhà đất tại {{config('constant.province_name') ?? 'Thanh Hóa'}}</h3>
        <div class="row">
            @foreach ($featured_districts as $district)
            <h4 class="col-6 py-1 mb-0">
                <a class="cl-light-blue font-9" href="/{{$district->slug ?? ''}}">{{$district->name}}</a>
                <span class="font-9">({{$district->realty_posts_count}})</span>
            </h4>
            @endforeach
        </div>
    </div>
    @endisset

    {{-- Chuyên mục được yêu thích --}}
    {{-- @isset($featured_posts)
    <div class="rounded-1 bg-white p-3 mb-3 border-bottom" >
        <h4 class="font-w-600 uppercase">Tin hay cho bạn</h4>
        @foreach ($featured_posts->skip(5)->take(5) ?? [] as $item)
        <div class="d-flex py-3 border-top">
            <a class="flex-fixed-width rounded-1 mr-3" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}" class="rounded-1" style="width: 125px">
                <img style="width: 100px; height:70px" src="{{$item->thumb}}" alt="{{$item->name}}">
            </a>
            <div>
                <a class="font-10 sidebar-link secondary-text" href="{{route('customer.post.show',['cat_slug' => $item->categories->first()->slug ?? 'danh-muc', 'post_slug' => $item->slug] )}}"> {{$item->name}} </a>
            </div>
        </div>
        @endforeach
    </div>
    @endisset --}}

</div>
@section('script')
@parent
<script>
    $('.sidebar-link').each(function(){
        maxText($(this), 50);
    })
</script>
@endsection
