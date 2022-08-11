<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nội dung quảng cáo</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="form-group">
                <label for="bank_name">Tên quảng cáo (<span class="text-red">*</span>)</label>
                <input
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                placeholder="Nhập tên quảng cáo"
                value="{{$advertisment->name ?? old('name')}}"
                >
                @error('name')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group ">
                <label class="control-label">Nội dung quảng cáo</label>
                @include('admin.components.ckeditor', ['id' => 'content',
                'name' => 'content',
                'current_input' => $advertisment->content ?? old('content') ?? ''
                ])
                @error('content')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thao tác</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="btn-set">
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="fa fa-save"></i> Lưu
                </button>
                &nbsp;
                <button type="submit" name="submit" value="apply" class="btn btn-success">
                    <i class="fa fa-check-circle"></i> Lưu &amp; Thoát
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Trạng thái </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label>Loại hiển thị</label>
                <select class="form-control select2 select2-info" value="" name="type" data-dropdown-css-class="select2-info"
                    style="width: 100%;">
                    @foreach (config('constant.advertisment.type') as $index => $item)
                    <option @if(isset($advertisment->type) && $advertisment->type == $index) selected @endif value="{{$index}}">{{$item['name'] ?? ''}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select class="form-control select2 select2-info" value="" name="status" data-dropdown-css-class="select2-info"
                    style="width: 100%;">
                    @foreach (config('constant.advertisment.status') as $index => $item)
                    <option @if(isset($advertisment->status) && $advertisment->status == $index) selected @endif value="{{$index}}">{{$item['name'] ?? ''}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

</div>

@section('script')
    @parent
    <script src="{{asset('/template/ckeditor/ckeditor.js')}}"></script>
@endsection
