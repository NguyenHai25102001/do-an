@extends('layout.admin.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            {{session('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{$titlePage}}</h5>
                                <a class="btn btn-success"
                                   href="{{route('admin.banner.create')}}">Thêm banner</a>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <form class="d-flex align-items-center w-50" method="get"
                                      action="{{route('admin.banner.index')}}">
                                    <input name="key_search" type="text" value="{{request()->get('key_search')}}"
                                           placeholder="Tìm kiếm title banner" class="form-control" style="margin-right: 16px">
                                    <button class="btn btn-info"><i class="bi bi-search"></i></button>
                                    <a href="{{route('admin.banner.index')}}" class="btn btn-danger" style="margin-left: 15px">Hủy </a>
                                </form>
                            </div>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Vị trí</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">...</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($listData))
                                    @foreach($listData as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>
                                                <div class="w-100 position-relative"
                                                     style="padding-top: 50%;min-width: 150px">
                                                    <img src="{{$value->image}}" class="position-absolute w-100 h-100"
                                                         style="top: 0;left: 0;object-fit: cover">
                                                </div>
                                            </td>
                                            <td>
                                                {{$value->title}}
                                            </td>
                                            <td>
                                                @if($value->location == 1)
                                                    Vị trí đầu
                                                @elseif($value->location == 2)
                                                    Vị trí đầu bên phải
                                                @elseif($value->location == 3)
                                                    Vị trí thứ 2
                                                @else
                                                    Vị trí hot sale
                                                @endif
                                            </td>
                                            <td>
                                                @if($value->display == 1)Bật @else Tắt @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{url('admin/banner/edit/'.$value->id)}}"
                                                       class="btn btn-icon btn-light btn-hover-success btn-sm"
                                                       data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                       data-bs-original-title="Cập nhật">
                                                        <i class="bi bi-pencil-square "></i>
                                                    </a>
                                                    <a href="{{url('admin/banner/delete/'.$value->id)}}"
                                                       class="btn btn-delete btn-icon btn-light btn-sm"
                                                       data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                       data-bs-original-title="Xóa">
                                                        <i class="bi bi-trash "></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                @else
                                    <tr>Không có dữ liệu</tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $listData->appends(request()->all())->links('admin.pagination_custom.index') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        $('a.btn-delete').confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
            buttons: {
                ok: {
                    text: 'Xóa',
                    btnClass: 'btn-danger',
                    action: function () {
                        location.href = this.$target.attr('href');
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {
                    }
                }
            }
        });
    </script>
@endsection
