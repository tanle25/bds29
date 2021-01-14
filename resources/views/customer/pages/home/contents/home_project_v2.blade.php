<section class="home-post pt-5 pb-2 section bg-white">
	<div class="container">
        <div class="p-0">
            <div>
                <div class="text-center mb-5">
                    <h2 class="font-18 home-title color-dark">Dự án nổi bật</h2>
                </div>
                <div class="project-container owl-carousel">
                    @foreach ($home_projects as $item)
                        <div class="item pb-3">
                            @include('customer.components.project.project_block', ['project' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                @isset($vertical_advertisments)
                    @include('customer.components.advertisments.vertical', ['items' => $vertical_advertisments, 'items_mobile' => $mobile_vertical_advertisments])
                @endisset
            </div>
        </div>
	</div>
</section>

@section('script')
@parent
<script>
    $('.project-container').owlCarousel({
        loop:true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        margin: 20,
        dots:true,
        nav:false,
        autoplayTimeout:3000,
        autoplaySpeed:1200,
        smartSpeed:1200,
        responsive:{
            0:{
                items:3,
            },
        }
    });
</script>
@endsection
