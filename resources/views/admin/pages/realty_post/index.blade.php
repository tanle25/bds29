@extends('admin.main_layout')
@section('title')
    Danh sách bài đăng khách hàng
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Quản lý bài đăng khách hàng'])
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Danh sách bài đăng khách hàng</h3>
              {{-- <a href="{{route('admin.realty_post.create')}}" class="btn btn-info p-1 float-right">Thêm mới</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="realty-post-table" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Loại giao dịch</th>
                        <th>Địa chỉ</th>
                        <th>Ngày gửi</th>
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
    <img src="" alt="">
</section>
@endsection

    @section('script')
    <script src="{{asset('template/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('template/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $(function () {
            $("#realty-post-table").dataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth:false,
                ajax: "{{route('admin.realty_post.list')}}",
                columns: [
                    { "data": "id","name": 'id' , 'width': '10px'},
                    { "data": "thumb",  'width':'40px' },
                    { "data": "title", 'name': 'title'  },
                    { "data": "type", 'name' : 'type', 'width': '150px'},
                    { "data": "realty.full_address", 'name': 'realty.full_address',  },
                    { "data": "created_at", 'width': '120px' },
                    { "data": "status", 'width': '90px' },
                    { "data": "action", 'width': '90px',  },
                ],
            })
        });

         function destroyRealtyPost(url){
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

        $(document).on('click', '.realty-post-destroy', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            swalConfirm('Xóa bài rao này!').then((result) => {
                if (result.value) {
                    destroyRealtyPost(url);
					setTimeout(() => {
						$('#realty-post-table').DataTable().ajax.reload();
					}, 1000);
                }
            });
        })
    </script>
@endsection
