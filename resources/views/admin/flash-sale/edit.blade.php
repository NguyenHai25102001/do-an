@extends('layout.admin.index')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <form method="post" action="{{url('admin/product-flash-sale/update/'.$flash_sale->id)}}" enctype="multipart/form-data" class="card p-3">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Ảnh sản phẩm :</p>
                            </div>
                            <div class="col-9">
                                <div class="d-flex align-items-center position-relative selector__image justify-content-center" style="width: 200px; height: 250px; background: #f0f0f0;cursor: pointer">
                                    <img src="{{$flash_sale->infor->image}}" class="position-absolute w-100 h-100" style="top: 0;left: 0; object-fit: cover">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Tên sản phẩm :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" value="{{$flash_sale->product->name}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Giá sale :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control format-currency" name="price_sale" value="{{number_format($flash_sale->price_sale)}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Ngày bắt đầu :</p>
                            </div>
                            <div class="col-9">
                                <input type="datetime-local" class="form-control" name="time_start" value="{{$flash_sale->time_start}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Ngày kết thúc :</p>
                            </div>
                            <div class="col-9">
                                <input type="datetime-local" class="form-control" name="time_end" value="{{$flash_sale->time_end}}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Cập nhật</button>
                            <a href="{{route('admin.flash-sale.index')}}" type="reset" class="btn btn-dark">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="{{url('assets/js/input_file.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/format_currency.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/create-product.js')}}"></script>
    <script src="{{url('assets/admin/edit-product.js')}}"></script>
@endsection
