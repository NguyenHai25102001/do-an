@extends('layout.admin.index')
<style>
    .content__product:nth-child(2n) {
        background: #E0E0E0;
    }
</style>
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
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                            {{session('error')}}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Danh sách sản phẩm</h5>
                                <div>
                                    <a class="btn btn-success" href="{{route('admin.products.create')}}">Thêm sản phẩm</a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <form class="d-flex align-items-center w-50" method="get"
                                      action="{{route('admin.products.index')}}">
                                    <input name="key_search" type="text" value="{{request()->get('key_search')}}"
                                           placeholder="Tìm kiếm tên sản phẩm" class="form-control" style="margin-right: 16px">
                                    <button class="btn btn-info" style="padding-top: 10px;padding-bottom: 10px"><i class="bi bi-search"></i></button>
                                    <a href="{{route('admin.products.index')}}" class="btn btn-danger" style="margin-left: 15px">Hủy </a>
                                </form>
                            </div>
                            <div class="card-body p-3">
                                <div class="overflow-auto">
                                    @if(count($listData) > 0)
                                    <div>
                                        <div class="d-flex w-100 align-items-center text-center text-white font-size-16" style="background: #4154f1;padding: 5px 0">
                                            <div style="width: 15%">Hình ảnh</div>
                                            <div style="width: 20%">Danh mục </div>
                                            <div style="width: 25%">Tên sản phẩm </div>
                                            <div style="width: 15%">Giá gốc</div>
                                            <div style="width: 15%">Giá bán ra </div>
                                            <div style="width: 10%">Thao tác </div>
                                        </div>
                                        <div class="w-100 bg-white mt-10">
                                            @foreach($listData as $item)
                                                <div class="w-100 d-flex mb-5 pt-2 pb-2 content__product align-items-center">
                                                    <div style="width: 15%" class="d-flex justify-content-center">
                                                        <img src="{{$item->image}}" alt="" class="w-75 mr-3" style="border-radius: 4px">
                                                    </div>
                                                    <div style="width: 20%" class="d-flex justify-content-center">
                                                        <p>{{$item->name_category}}</p>
                                                    </div>
                                                    <div style="width: 55%">
                                                        @foreach($item->product as $value)
                                                            <div class="w-100 d-flex">
                                                                <div style="width: 47%">
                                                                    <p class="text-center text-capitalize font-size-12">{{$value->name}}</p>
                                                                </div>
                                                                <div style="width: 27%">
                                                                    <p class="text-center font-size-12">{{number_format($value->price)}} vnđ</p>
                                                                </div>
                                                                <div style="width: 27%">
                                                                    <p class="text-center font-size-12">{{number_format($value->promotional_price)}} vnđ</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div style="width: 10%" class="d-flex justify-content-center">
                                                        <div class="btn-group">
                                                            <a href="{{url('admin/products/edit/'.$item->id)}}" class="btn btn-icon btn-light btn-hover-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Cập nhật">
                                                                <i class="bi bi-pencil-square "></i>
                                                            </a>
                                                            <a href="{{url('admin/products/delete/'.$item->id)}}" class="btn btn-delete btn-icon btn-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Xóa">
                                                                <i class="bi bi-trash "></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
                    action: function(){
                        location.href = this.$target.attr('href');
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {}
                }
            }
        });
    </script>
@endsection
