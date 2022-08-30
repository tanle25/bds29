<div class="breadcrumbs">
    <a class="text-secondary" href="/">Trang chủ</a>
    @if (!empty($links))
        /
    @endif
    @foreach ($links as $index =>  $item)
    @if ($index !== 0)
     /
    @endif
    <a class="text-secondary detail-breadcumb" href="javascript:void(0);" data-href="{{$item['link']}}" >{{$item['name']}}</a>
    @endforeach
</div>


