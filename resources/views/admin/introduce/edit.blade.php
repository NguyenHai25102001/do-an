@extends('layout.admin.index')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tạo banner</h1>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="bg-white p-4">
                @if (session('error'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        {{session('error')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{url("admin/introduce/update",$introduce->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-3">Title :</div>
                        <div class="col-8">
                            <input class="form-control" name="title" value="{{$introduce->title}}" type="text" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-3 col-form-label">Loại bài viết</label>
                        <div class="col-8">
                            <select class="form-select" name="type" aria-label="Default select example">
                                <option class="bg-info" @if($introduce->type == 0) selected @endif value="0">Thông tin liên hệ</option>
                                <option class="bg-info" @if($introduce->type == 1) selected @endif value="1">Chính sách</option>
                                <option class="bg-info" @if($introduce->type == 2) selected @endif value="2">Thông tin khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <div class="card-header bg-info text-white">
                            Nội dung
                        </div>
                        <div class="card-body mt-2">
                            <textarea name="content" style="height: 1000px" class="ckeditor">{!! $introduce->content !!}</textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">Bật/tắt :</div>
                        <div class="col-8">
                            <label class="switch">
                                <input type="checkbox" @if($introduce->display == 1) checked @endif name="display">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-3"></div>
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{route('admin.introduce.index')}}" class="btn btn-danger">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section('script')
    <script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
