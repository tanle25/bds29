<div class="realty-by-address">
    <h2 class="text-center py-5">Bất Động Sản Theo Địa Điểm</h2>
    <div class="row no-gutters">
        @foreach ($featured_district->take(4) as $index => $district)
        <div class="col-12 col-md-6">
            <div class="row no-gutters
            @if ($index >= 2)
            flex-row-reverse
            @endif
            ">
                <div class="col-12 col-md-6">
                    <div class="embed-responsive embed-responsive-1by1 w-100">
                        <img class="embed-responsive-item" src="{{$district->details->avatar ?? ''}}" alt="">
                    </div>
                </div>
                <div class="col-12 col-md-6 p-5 d-flex align-items-center justify-content-center flex-column text-center">
                    <a href="/{{$district->slug}}"><h3 class="font-weight-600">{{$district->name}}</h3></a>
                    <p class="py-2 font-weight-300 font-9">{{$district->details->short_description ?? 'Rio de Janeiro được chia thành các quận với mỗi quận có một số khu vực lân cận. Có một số khu vực lân cận rất nổi tiếng với người dân địa phương cũng như khách du lịch.'}}</p>
                    <span class="font-14 font-weight-400">{{$district->realty_posts_count ?? ''}} tin đăng</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
