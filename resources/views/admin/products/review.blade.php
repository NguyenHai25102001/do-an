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
                    @if (session('error'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            {{session('error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body d-flex justify-content-evenly align-items-center flex-wrap" style="padding-top: 20px">
                            <a href="{{url('admin/products/review/1')}}" type="button"
                               class="btn btn-outline-info @if($type == 1) active @endif">Điện thoại </a>
                            <a href="{{url('admin/products/review/2')}}" type="button"
                               class="btn btn-outline-primary @if($type == 2) active @endif">Máy tính bảng</a>
                            <a href="{{url('admin/products/review/3')}}" type="button"
                               class="btn btn-outline-success @if($type == 3) active @endif">Laptop</a>
                            <a href="{{url('admin/products/review/4')}}" type="button"
                               class="btn btn-outline-warning @if($type == 4) active @endif">Đồng hồ thông minh</a>
                            <a href="{{url('admin/products/review/5')}}" type="button"
                               class="btn btn-outline-dark @if($type == 5) active @endif">Nhà thông minh</a>
                            <a href="{{url('admin/products/review/6')}}" type="button"
                               class="btn btn-outline-danger @if($type == 6) active @endif">Phụ kiện</a>
                            <a href="{{url('admin/products/review/7')}}" type="button"
                               class="btn btn-outline-secondary @if($type == 6) active @endif">Âm thanh</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{$titlePage}}</h5>
                            </div>
                            @if(count($listData) > 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 15px;">STT</th>
                                        <th scope="col" style="width: 20%;">Tên sản phẩm</th>
                                        <th scope="col" style="width: 20%;">Thông tin người đánh giá</th>
                                        <th scope="col" style="width: 6%;">Số sao</th>
                                        <th scope="col">Nội dung</th>
                                        <th scope="col" style="width: 14%;">...</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listData as $k => $value)
                                        <tr>
                                            <th id="{{$value->id}}" scope="row">{{$k+1}}</th>
                                            <td>{{$value->name_product}}</td>
                                            <td>
                                                {{$value->name}}<br>
                                                {{$value->phone}}<br>
                                                {{$value->email}}
                                            </td>
                                            <td>{{$value->star}}</td>
                                            <td>
                                                {{$value->content}}
                                            </td>
                                            <td style="border-top: 1px solid #cccccc">
                                                @if($value->status == 0)
                                                    <a href="{{url('admin/products/browser-review/'.$value->id)}}">
                                                        <button type="submit" class="btn btn-primary">Duyệt
                                                        </button>
                                                    </a>
                                                @else
                                                    <button type="submit" class="btn btn-success mb-2">Đã duyệt
                                                    </button>
                                                @endif
                                                <a href="{{url('admin/products/delete-review/'.$value->id)}}">
                                                    <button type="submit" class="btn btn-danger">Xóa
                                                    </button>
                                                </a>
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
