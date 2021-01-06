@extends('admin.main_layout')
@section('title')
    Trang chủ
@endsection
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <script src="{{asset('plugins/datatable/Select-1.3.1/css/select.bootstrap.min.css')}}"></script>
@endsection

@section('content')
@include('admin.partials.content_header', ['title' => 'Hóa đơn nạp tiền'])
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Danh sách</h3>
              {{-- <a href="{{route('admin.post_bill.create')}}" class="btn btn-info p-1 float-right">Thêm mới</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="bill-table" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn</th>
                        <th>Số tiền</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($bills as $bill)
                    <tr>
                      <td>{{$bill->id}}</td>
                      <td>{{$bill->bill_code}}</td>
                      <td>
                          {{$bill->amount_of_money}}
                      </td>
                      <td>{{Carbon\Carbon::parse($bill->created_at)->format('H:i d/m/Y')}}</td>
                      <td>
                      @switch($bill->status)
                          @case(1)
                            <span class="right badge badge-primary">Chưa duyệt</span>
                            @break
                          @case(2)
                            <span class="right badge badge-danger">Đã duyệt</span>
                            @break
                          @default
                          <span class="right badge badge-danger">Chưa duyệt</span>
                      @endswitch</td>
                      <td>
                        <a data-toggle-for="tooltip" title="Duyệt hóa đơn" href="{{route('admin.bill.edit', $bill->id)}}"class="btn text-info bill-edit"><i class="fas fa-edit"></i></a>
                        <a data-toggle-for="tooltip" title="Xóa" href="{{route('admin.bill.destroy', $bill->id)}}"class="btn text-danger bill-destroy"><i class="fas fa-trash" ></i></a>
                      </td>

                    </tr>
                    @endforeach

                  </tbody>
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
    <script src="{{asset('plugins/datatable/Select-1.3.1/js/dataTables.select.min.js')}}"></script>
    <script>
      $(function () {
        var table = $("#bill-table").DataTable({
            processing: true,
            scrollX: true,
            autoWidth:false,
            select: {
                style: 'multi'
            }
        });
        console.log(table);
        $('#bill-table').on( 'click', 'tbody tr', function () {
            if ( table.row( this, { selected: true } ).any() ) {
                table.row( this ).deselect();
            }
            else {
                table.row( this ).select();
            }
            console.log(table.row(this));
        });

      });
      $(document).on('click', '.bill-destroy', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Xóa đơn này?',
                text: "Bạn không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vẫn xóa!',
            })
            .then((result) => {
                if (result.value) {
                   window.location = url;
                }
            });
        })

    </script>
@endsection
