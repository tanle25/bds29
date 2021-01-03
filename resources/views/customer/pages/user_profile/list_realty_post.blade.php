@extends('customer.pages.user_profile.index')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('form')
<div class="table-wraper col-12" style="overflow: scroll;">
    <table id="realty-post-table" class="table table-bordered table-hover bg-white">
        <thead>
          <tr>
              <th>ID</th>
              <th>Ảnh</th>
              <th>Link bài đăng</th>
              <th>Thời gian đăng tin</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($realty_posts as $key => $post)
            <tr>
                <td>{{$post->id ?? ''}}</td>
                <td style="height:50px; width: 80px">
                    <div>
                        <img  class="img-fluid" src="{{$post->thumb ?? ''}}" alt="{{$post->title ?? ''}}">
                    </div>
                </td>
                <td><a class="font-9" href="{{route('customer.realty_post.show', $post->slug)}}">{{$post->title ?? ''}}</a> </td>
                <td class="font-9">{{Carbon\Carbon::parse($post->open_at)->format('d/m/Y') ?? ''}} - {{ Carbon\Carbon::parse($post->close_at ?? '')->format('d/m/Y') ?? ''}}</td>
                <td><span class="font-9">{{config('constant.realty_post_status.' . $post->status)}}</span></td>
                <td><a class="font-9" href="{{route('customer.realty_post.edit', $post->id)}}">Sửa</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
@parent
<script src="{{asset('template/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('template/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
 $("#realty-post-table").dataTable({
    "autoWidth": true,
    "scrollX": true,
    "columnDefs": [
        { "width": "200px", "targets": 2 }
    ]
 });
</script>
@endsection
