@extends('admin.main_layout')
@section('title')
  Trang chủ
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Trang chủ'])
<style>
    .bs-alert {
        color: #004085;
        background-color: #cce5ff;
        border-color: #b8daff;
    }
</style>
<div class="alert alert-primary bs-alert" role="alert">
    <span class="text-danger">
        Chú ý:
    </span>
    Chuyển hình ảnh sang phiên bản mới trước khi tiến hành tối ưu. <br>
    Mỗi lần tối ưu nhiều nhất 50 file ảnh. <br>
    Sau khi duyệt tin đăng (Đối với những tin đăng ở phiên bản cũ) phải tiến hành di chuyển hình ảnh sang phiên bản mới.
</div>
<div class="d-flex justify-content-center ">
    
    <div class="card w-50">
        <div class="card-header bg-success">
            Featured
        </div>
        <div class="card-body">
            {{-- @if (Session::has('compressImage')) --}}
            @if (isset($result))
            <strong class="text-success">Bạn đã tối ưu {{$result['total_compress']}} /
                {{$result['total_image']}}</strong>
            <div class="d-flex justify-content-between">
                <strong class="text-success">Tổng dung lượng ảnh trước khi tối ưu</strong>
                {{-- <strong class="text-success">{{$result['image_before'] > 1048576 ? $result['image_before'] /
                    1048576 : $result['image_before']}}</strong> --}}
                <strong class="text-success">{{formatSizeUnits($result['image_before'])}}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <strong class="text-success">Tổng dung lượng ảnh sau khi tối ưu</strong>
                <strong class="text-success">{{formatSizeUnits($result['image_after'])}}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <strong class="text-success">Tiết kiệm </strong>
                <strong class="text-success">{{formatSizeUnits($result['image_saved_byte'])}}
                    ({{round($result['image_saved_percent'] *100,1 )}})%</strong>
            </div>



            <div class="d-flex justify-content-between">
                <strong class="text-success">Tổng dung lượng thumbnail trước khi tối ưu</strong>
                <strong class="text-success">{{ formatSizeUnits($result['thumb_before'])}}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <strong class="text-success">Tổng dung lượng thumbnail sau khi tối ưu</strong>
                <strong class="text-success">{{formatSizeUnits($result['thumb_after'])}}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <strong class="text-success">Tiết kiệm </strong>
                <strong class="text-success">{{formatSizeUnits($result['thumb_saved_byte'])}}
                    ({{round($result['thumb_saved_percent'] *100,1 )}})%</strong>
            </div>
            @else
            <strong class="text-success">Bạn đã tối ưu {{$total_compress}} /
                {{$total_image}}</strong>
                <div class="d-flex justify-content-around mt-3">
                    <a role="button" class="btn btn-primary" href="{{url('admin/di-chuyen-hinh-anh')}}">Chuyển hình ảnh sang phiên bản mới</a>
                    <a role="button" class="btn btn-primary" href="{{url('admin/toi-uu-avatar')}}">Tối ưu avatar người dùng</a>
                    @if ($total_image != $total_compress)
                        <a href="{{url('admin/xu-ly-hinh-anh')}}" role="button" class="btn btn-info text-white">Tối ưu hình ảnh bài viết</a>
                    @endif
                </div>
                
            @endif
            


        </div>


    </div>
</div>
@endsection