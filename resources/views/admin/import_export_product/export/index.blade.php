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
                                <h5 class="card-title">Danh sách hàng xuất</h5>
                                <div>
                                    <a class="btn btn-success" href="{{route('admin.import-export-product.create-export')}}">Xuất hàng</a>
                                </div>
                            </div>
                            <div class="mb-2 mt-3 d-flex justify-content-end">
                                <form action="{{route('admin.import-export-product.export')}}" method="get" class="w-100 d-flex justify-content-end">
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <p class="m-0" style="width: 100px;font-weight: 600">Từ ngày</p>
                                            <input type="date" class="form-control" name="date_form" value="{{request()->get('date_form')}}" style="max-width: 240px">
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex align-items-center">
                                            <p class="m-0" style="width: 160px;padding: 0 20px;font-weight: 600">Đến ngày</p>
                                            <input type="date" class="form-control" name="date_to" value="{{request()->get('date_to')}}" style="max-width: 240px">
                                        </div>
                                    </div>
                                    <button class="btn btn-info" name="excel" value="1" style="margin-left: 15px">Lọc</button>
                                    <button type="submit" class="btn btn-success" name="excel" value="2" style="margin: 0 15px">Xuất Excel</button>
                                    <a href="{{route('admin.import-export-product.export')}}" class=" btn btn-danger btn_exit">Hủy</a>
                                </form>
                            </div>
                            <div class="card-body p-3">
                                <div class="overflow-auto">
                                    <div>
                                        <div class="d-flex w-100 align-items-center text-center text-white font-size-16" style="background: #4154f1;padding: 5px 0">
                                            <div style="width: 10%">Hình ảnh</div>
                                            <div style="width: 25%">Tên sản phẩm </div>
                                            <div style="width: 10%">Loại sản phẩm </div>
                                            <div style="width: 20%">Giá nhập</div>
                                            <div style="width: 10%">Số lượng nhập</div>
                                            <div style="width: 15%">Ngày nhập</div>
                                            <div style="width: 10%">Thao tác </div>
                                        </div>
                                        <div class="w-100 bg-white mt-10">
                                            @foreach($listData as $item)
                                                <div class="w-100 d-flex pt-2 pb-2 content__product align-items-center">
                                                    <div style="width: 10%" class="d-flex justify-content-center">
                                                        <img src="{{$item->product_img}}" alt="" class="w-25 mr-3" style="border-radius: 4px">
                                                    </div>
                                                    <div style="width: 25%" class="d-flex justify-content-center">
                                                        <p class="mb-0">{{$item->product_name}}</p>
                                                    </div>
                                                    <div style="width: 10%" class="d-flex justify-content-center">
                                                        <p class="mb-0">{{$item->attribute_name}}</p>
                                                    </div>
                                                    <div style="width: 20%" class="d-flex justify-content-center">
                                                        <p class="mb-0">{{$item->price}}</p>
                                                    </div>
                                                    <div style="width: 10%" class="d-flex justify-content-center">
                                                        <p class="mb-0">{{$item->quantity}}</p>
                                                    </div>
                                                    <div style="width: 15%" class="d-flex justify-content-center">
                                                        <p class="mb-0">{{date('d/m/Y', strtotime($item->created_at))}}</p>
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
