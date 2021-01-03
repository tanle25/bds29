<section class="horizon-advertisment container owl-carousel">
    @foreach ($items as $ad)
    <div class="item">{!!$ad->content ?? ''!!}</div>
    @endforeach
</section>
