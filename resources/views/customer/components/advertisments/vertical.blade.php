<section class="vertical-advertisment container owl-carousel">
    @foreach ($items as $ad)
        <div class="item">{!!$ad->content!!}</div>
    @endforeach
</section>
