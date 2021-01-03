@extends('admin.main_layout')
@section('title')
    Danh sách lớp học
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Quản lý lớp học'])
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Danh sách lớp học</h3>
              <a href="{{route('admin.project.create')}}" class="btn btn-info p-1 float-right">Thêm mới</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="project-table" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên dự án</th>
                        <th>Loại dự án</th>
                        <th>Chủ dự án</th>
                        <th>Địa chỉ</th>
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
            $("#project-table").dataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth:false,
                ajax: "{{route('admin.project.list')}}",
                columns: [
                    { "data": "id","name": 'id', 'width': '10px'},
                    { "data": "thumb",  'width':'40px' },
                    { "data": "name", 'name' : 'name', 'width': '150px'},
                    { "data": "project_type", 'name' : 'project_type', 'width': '150px'},
                    { "data": "investor", 'name' : 'investor', 'width': '150px'},
                    { "data": "full_address", 'name': 'full_address' },
                    { "data": "action", 'width': '90px',  },
                ],
            })
        });

         function destroyProject(url){
            $.ajax({
                url: url,
                type: 'post',
                success: function(data){
                    if(data.msg){
                        swalToast(data.msg);
                    };
                    if(data.error){
                        swalToast(data.error, 'error');
                    }
                },
                error: function(){
                    swalToast('Lỗi không xác định trong quá trình xóa!', 'error');
                }
            })
        }

        $(document).on('click', '.project-destroy', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            swalConfirm('Xóa dự án này!').then((result) => {
                if (result.value) {
                    destroyProject(url);
					setTimeout(() => {
						$('#project-table').DataTable().ajax.reload();
					}, 1000);
                }
            });
        })
    </script>
@endsection
