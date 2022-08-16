@extends('customer.layouts.main')

@section('content')
<div class="d-flex justify-content-center ">
    <div class="card w-50">
        <div class="card-header bg-success">
            Featured
        </div>
        <div class="card-body">
            {{-- @if (Session::has('compressImage')) --}}


            @if (Session::has('compressImage'))
            @php

            $result = Session::get('compressImage')
            @endphp
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
            @endif


        </div>


    </div>
</div>
@endsection