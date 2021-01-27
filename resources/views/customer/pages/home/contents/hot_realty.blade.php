<section class="random-realty py-3 py-lg-5 section hrm-bg-secondary">
	<div class="container">
        <div class="">
            <h2 class="color-dark home-title">Bất động sản dành cho bạn</h2>
        </div>
        <div>
            <span href="/api/get-realty-post?filter[loai-tin-dang]=1" class="btn realty-post-selector btn-muted mr-2 rounded-pill">Mua bán</span>
            <span href="/api/get-realty-post?filter[loai-tin-dang]=2" class="btn realty-post-selector btn-muted  rounded-pill">Cho thuê</span>
        </div>
        <div class="row pt-4 hot-realties">
            @foreach ($random_realties as $index => $item)
            <div class="item col-md-3 my-2 wow fadeIn"
            data-wow-offset="1"
            data-wow-delay="{{0.1 * $index}}s"
            >
                @include('customer.components.realty_post.realty_block', ['item' => $item])
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="/dat-dong-san" class="main-text letter-spacing-1 btn btn-outline-primary font-14 font-weight-500 mx-auto mt-4 py-2 px-4">Xem thêm</a>
        </div>
    </div>
</section>

@section('script')
    @parent
    <script>
        function getRealties(url){
            return $.ajax({
                type: "get",
                url: url,
                data: {
                    type: 'html',
                },
            });
        }

        $('.realty-post-selector').on('click', function(){
            var url = $(this).attr('href');
            $('.realty-post-selector').addClass('btn-muted').removeClass('btn-info');
            $(this).removeClass('btn-muted');
            $(this).addClass('btn-info');
            getRealties(url).done(function(data){
                $(".hot-realties").html(data);
            })
        })
    </script>
@endsection
