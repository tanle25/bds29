@extends('admin.main_layout')
@section('title')
    Trang chủ
@endsection

@section('content')

@include('admin.partials.content_header', ['title' => 'Quản lý File'])

<iframe src="/admin/laravel-filemanager" style="width: 100%; height: 800px; overflow: hidden; border: none;"></iframe>

@endsection
