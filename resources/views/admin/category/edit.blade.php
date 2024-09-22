@extends('layout.admin.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cập nhật danh mục sản phẩm</h5>
                            <!-- General Form Elements -->
                            @if (session('error'))
                                <div
                                    class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                    role="alert">
                                    {{session('error')}}
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{session('success')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{url('admin/category/update/'.$category->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Tên danh mục</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" value="{{$category->name}}" required
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Danh mục menu</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="type"
                                                aria-label="Default select example">
                                            <option class="bg-info" @if($category->type == 1) selected @endif value="1">Điện thoại</option>
                                            <option class="bg-info" @if($category->type == 2) selected @endif value="2">Máy tính bảng</option>
                                            <option class="bg-info" @if($category->type == 3) selected @endif value="3">Laptop</option>
                                            <option class="bg-info" @if($category->type == 4) selected @endif value="4">Đồng hồ thông minh</option>
                                            <option class="bg-info" @if($category->type == 5) selected @endif value="5">Nhà thông minh</option>
                                            <option class="bg-info" @if($category->type == 6) selected @endif value="6">Phụ kiện</option>
                                            <option class="bg-info" @if($category->type == 7) selected @endif value="7">Âm thanh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Danh mục con</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="parent_id"
                                                aria-label="Default select example">
                                            <option value="0" selected>Làm danh mục cha</option>
                                            @foreach($category_all as $value)
                                                <option @if($value->id == $category->parent_id) selected
                                                        @endif value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Vị trí, thứ tự</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="location" value="{{$category->location}}" required
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">Hình ảnh :</div>
                                    <div class="col-4">
                                        <div class="form-control position-relative div-parent" style="padding-top: 50%">
                                            <div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">
                                                <button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%"><i class="bi bi-x-lg text-white"></i></button>
                                                <img src="{{$category->image}}" class="w-100 h-100" style="object-fit: cover">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-3 pt-0">Trạng thái</legend>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="display" id="gridRadios1"
                                                   value="1" @if($category->display == 1) checked @endif>
                                            <label class="form-check-label" for="gridRadios1">
                                                Hiện
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="display" id="gridRadios2"
                                                   value="0" @if($category->display == 0) checked @endif>
                                            <label class="form-check-label" for="gridRadios2">
                                                Ẩn
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary">Cập nhập</button>
                                        <a href="{{route('admin.category.index')}}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>
                                <input type="file" name="file" accept="image/x-png,image/gif,image/jpeg" hidden>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        let parent;
        $(document).on("click", ".select-image", function () {
            $('input[name="file"]').click();
            parent = $(this).parent();
        });
        $('input[type="file"]').change(function(e){
            imgPreview(this);
        });
        function imgPreview(input) {
            let file = input.files[0];
            let mixedfile = file['type'].split("/");
            let filetype = mixedfile[0]; // (image, video)
            if(filetype == "image"){
                let reader = new FileReader();
                reader.onload = function(e){
                    $("#preview-img").show().attr("src", );
                    let html = '<div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">' +
                        '<button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%"><i class="bi bi-x-lg text-white"></i></button>'+
                        '<img src="'+e.target.result+'" class="w-100 h-100" style="object-fit: cover">' +
                        '</div>';
                    parent.html(html);
                }
                reader.readAsDataURL(input.files[0]);
            }else if(filetype == "video" || filetype == "mp4"){
                let html = '<div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">' +
                    '<button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%;z-index: 14"><i class="bi bi-x-lg text-white"></i></button>'+
                    '<video class="w-100 h-100" style="object-fit: cover" controls>\n' +
                    '<source src="'+URL.createObjectURL(input.files[0])+'"></video>'+
                    '</div>';
                parent.html(html);
            }else{
                alert("Invalid file type");
            }
        }
        $(document).on("click", "button.clear", function () {
            parent = $(this).closest(".div-parent");
            $(".div-file").remove();
            let html = '<button type="button" class="position-absolute border-0 bg-transparent select-image" style="top: 50%;left: 50%;transform: translate(-50%,-50%)">\n' +
                '                                    <i style="font-size: 30px" class="bi bi-download"></i>\n' +
                '                                </button>';
            parent.html(html);
            $('input[type="file"]').val("");
        });
    </script>
@endsection
