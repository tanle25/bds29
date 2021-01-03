@extends('admin.main_layout')
@section('title')
    Bài viết
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Quản lý bài giảng'])
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Danh sách bài viết</h3>
              <a href="{{route('admin.post.create')}}" class="btn btn-info p-1 float-right">Thêm mới</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="post-table" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh đại diện</th>
                        <th>Danh mục</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                  </thead>

                </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection

    @section('script')
    <script src="{{asset('template/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $(function () {
            $("#post-table").dataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth:false,
                ajax: "{{route('admin.post.list')}}",
                columns: [
                    { "data": "id","name": 'id', 'width': '10px'},
                    { "data": "name",  },
                    { "data": "avatar", 'width': '80px' },
                    { "data": "created_at",  'width': '150px'},
                    { "data": "created_by", 'name': 'author.username', 'width': '120' },
                    { "data": "created_at", 'width': '120px' },
                    { "data": "status", 'width': '90px' },
                    { "data": "action", 'width': '80px' },
                ],
            })
        });
    </script>
@endsection
