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
                                <h5 class="card-title">Danh sách sản phẩm flash sale</h5>
                                <div>
                                    <a class="btn btn-success" href="{{route('admin.flash-sale.create')}}">Thêm sản phẩm flash sale</a>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="overflow-auto">
                                    <div>
                                        <div class="d-flex w-100 align-items-center text-center text-white font-size-16" style="background: #4154f1;padding: 5px 0">
                                            <div style="width: 35%">Têm sản phẩm</div>
                                            <div style="width: 15%">Giá sản phẩm</div>
                                            <div style="width: 20%">Thời gian bắt đầu</div>
                                            <div style="width: 20%">Thời gian kết thúc</div>
                                            <div style="width: 10%">Thao tác </div>
                                        </div>
                                        <div class="w-100 bg-white mt-10">
                                            @foreach($listData as $item)
                                                <div class="w-100 d-flex mb-5 pt-2 pb-2 content__product align-items-center">
                                                    <div style="width: 35%" class="d-flex justify-content-center">
                                                        <p>{{$item->product->name}}</p>
                                                    </div>
                                                    <div style="width: 15%" class="d-flex justify-content-center">
                                                        <p>{{number_format($item->price_sale)}} đ</p>
                                                    </div>
                                                    <div style="width: 20%" class="d-flex justify-content-center">
                                                        <p>{{$item->time_start}}</p>
                                                    </div>
                                                    <div style="width: 20%" class="d-flex justify-content-center">
                                                        <p>{{$item->time_end}}</p>
                                                    </div>
                                                    <div style="width: 10%" class="d-flex justify-content-center">
                                                        <div class="btn-group">
                                                            <a href="{{url('admin/product-flash-sale/edit/'.$item->id)}}" class="btn btn-icon btn-light btn-hover-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Cập nhật">
                                                                <i class="bi bi-pencil-square "></i>
                                                            </a>
                                                            <a href="{{url('admin/product-flash-sale/delete/'.$item->id)}}" class="btn btn-delete btn-icon btn-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Xóa">
                                                                <i class="bi bi-trash "></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
