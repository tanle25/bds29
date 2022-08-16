{{--tham số đầu vào
    action store
    action delete
    @param input_name
--}}

<div  id="{{$input_name}}" action="/image/store" class="dropzone" >
    <div class="fallback">
      <input name="file" type="file" multiple />
    </div>
    <input
    @isset($mock_file)
        @php
            $file_list = [];
            foreach ($mock_file as $item) {
                if ($item) {
                    $file_list[] = $item['path'];
                }
            }
            $file_list_string = implode(',', $file_list);
        @endphp
        value="{{$file_list_string}}"
    @endisset
    type="hidden" name="{{$input_name}}" >
</div>
<div class="d-flex justify-content-end">
    <a data-toggle="collapse" href="#{{$input_name}}-alt" role="button">Add alt</a>
</div>
<div class="collapse" id="{{$input_name}}-alt">
    <div class="row">
        <div class="col-6">
            <span>alt</span>
        </div>
        <div class="col-6">
            <span>title</span>
        </div>
    </div>
</div>

@section('script')

@parent
<script>
    $(document).ready(function () {
        let {{Str::camel($input_name)}} = new Dropzone("div#{{$input_name}}", {
            dictDefaultMessage: "Click hoặc kéo ảnh vào đây",
            url: "/image/store",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            addRemoveLinks: true,
            init: function () {
                @isset($mock_file)
                    var mock_file = @json($mock_file);
                    mock_file.forEach(element => {
                        if(element){
                            // this.displayExistingFile(element, element.path);

                            this.emit("addedfile", element);
                            this.emit("thumbnail", element, element.path);
                            this.emit("success", element);
                            this.emit("complete", element);
                            element['link'] = element.path;
                            $(element.previewTemplate).append(
                                `<a class="dz-remove-link" href="javascript:undefined;" data-remove-link="${element.storage_path}"></a>`
                            );
                            this.files.push(element);
                            $('#{{$input_name}}-alt').append(
                                `<div id="${baseName(element.path)}" class="row py-2">
                                    <div class="col-6">
                                        <input type="text" name="{{$input_name}}_alt[]" class="form-control" placeholder="alt" value="${element.alt}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="{{$input_name}}_title[]" class="form-control" placeholder="title" value="${element.title}">
                                    </div>
                                </div>`
                            );
                        }
                    });
                @endisset

                let getStorageLinks = () => {
                    var file_list = this.files.map(function (item) {
                        return item.link;
                    });
                    file_list = file_list.join(',');
                    return file_list;
                }

                this.on("addedfile", function (file) {
                    if (this.files.length) {
                        var _i, _len;
                        for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
                        {
                            if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                                alert('File đã tồn tại!');
                                this.removeFile(file);
                            }
                        }
                    }
                    if(this.files.length > 10){
                        alert('Bạn chỉ được upload tối đa 10 ảnh mỗi bài!');
                        this.removeFile(file);
                    }
                    maxSize = 2;
                    if(file.size > maxSize * 1024 * 1024){
                        console.log(file.size);
                        alert('Kích thước ảnh quá lớn, tối đa '+ maxSize +'Mb!');
                        this.removeFile(file);
                    }
                });

                this.on("success", function (file, response) {
                    var imageStoragePath = response.storage_path;
                    $(file.previewTemplate).append(
                        `<a class="dz-remove-link" href="javascript:undefined;" data-remove-link="${imageStoragePath}"></a>`
                    );
                    file['link'] = response.path;
                    // console.log(baseName(response.path));
                    let file_list = getStorageLinks();
                    $('input[name="{{$input_name}}"]').val(file_list);
                    $('#{{$input_name}}-alt').append(
                        `<div id="${baseName(response.path)}" class="row py-2">
                            <div class="col-6">
                                <input type="text" class="form-control" name="{{$input_name}}_alt[]" placeholder="alt">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="{{$input_name}}_title[]" placeholder="title">
                            </div>
                        </div>`
                    );
                });
                

                this.on("thumbnail", function(file, dataUrl) {
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%', objectFit: "contain"});
                });

                this.on("removedfile", function (file) {
                    var filePath = $(file.previewTemplate).children('.dz-remove-link').data('remove-link');
                    $.ajax({
                        type: 'POST',
                        url: "{{route('image.destroy')}}",
                        data: {
                            storage_path: filePath,
                        }
                    });
                    let file_list = getStorageLinks();
                    $('input[name="{{$input_name}}"]').val(file_list);
                    $('#'+baseName(filePath)).remove();
                });
            }
        });
    });
    function baseName(str)
        {
        var base = new String(str).substring(str.lastIndexOf('/') + 1); 
            if(base.lastIndexOf(".") != -1)       
                base = base.substring(0, base.lastIndexOf("."));
        return base;
        }
</script>
@endsection
