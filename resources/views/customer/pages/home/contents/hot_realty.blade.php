<section class="random-realty py-3 py-lg-5 section hrm-bg-secondary">
	<div class="container">
        <div class="d-md-flex justify-content-center">
            <h2 class="color-dark home-title">Bất động sản dành cho bạn</h2>
        </div>

        <div class="row pt-4">
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
