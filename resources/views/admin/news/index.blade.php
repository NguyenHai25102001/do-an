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
                                   href="{{route('admin.news.create')}}">Thêm bài viết</a>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <form class="d-flex align-items-center w-50" method="get"
                                      action="{{route('admin.news.index')}}">
                                    <input name="key_search" type="text" value="{{request()->get('key_search')}}"
                                           placeholder="Tìm kiếm tên bài viết" class="form-control" style="margin-right: 16px">
                                    <button class="btn btn-info"><i class="bi bi-search"></i></button>
                                    <a href="{{route('admin.news.index')}}" class="btn btn-danger" style="margin-left: 15px">Hủy </a>
                                </form>
                            </div>
                            @if(count($listData) > 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" style="width: 300px">Tên bài viết</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col" class="text-center">Thể loại</th>
                                        <th scope="col" class="text-center">Link bài viết</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                        <th scope="col">...</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listData as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>{{$value->title}}</td>
                                            <td>
                                                <img src="{{$value->image}}" width="200px"
                                                     style="object-fit: contain">
                                            </td>
                                            <td class="text-center">@if($value->type == 1) Tin
                                                mới @elseif($value->type == 2) Khuyến mãi @elseif($value->type == 3) Mẹo
                                                hay @elseif($value->type == 4) Tin tuyển dụng @endif</td>
                                            <td class="text-center">
                                                <?= URL::to('chi-tiet-tin-tuc/'.$value->slug) ?>
                                            </td>
                                            <td class="text-center">@if($value->display == 1)Bật @else Tắt @endif</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{url('admin/news/edit/'.$value->id)}}"
                                                       class="btn btn-icon btn-light btn-hover-success btn-sm"
                                                       data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                       data-bs-original-title="Cập nhật">
                                                        <i class="bi bi-pencil-square "></i>
                                                    </a>
                                                    <a href="{{url('admin/news/delete/'.$value->id)}}"
                                                       class="btn btn-delete btn-icon btn-light btn-sm"
                                                       data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                       data-bs-original-title="Xóa">
                                                        <i class="bi bi-trash "></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $listData->appends(request()->all())->links('admin.pagination_custom.index') }}
                                </div>
                            @else
                                <h5 class="card-title">Không có dữ liệu</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
