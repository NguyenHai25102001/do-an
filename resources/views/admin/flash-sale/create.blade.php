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
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                             role="alert">
                            {{session('error')}}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.flash-sale.store')}}" enctype="multipart/form-data"
                          class="card p-3">
                        @csrf
                        <h5>Thêm sản phẩm flash sale</h5>
                        <div class="w-100 d-flex justify-content-between align-items-center mt-3">
                            <lable>Thời gian bắt đầu: </lable>
                            <input type="datetime-local" name="time_start" class="form-control" style="width: 35%">
                            <lable>Thời gian kết thúc: </lable>
                            <input type="datetime-local" name="time_end" class="form-control" style="width: 35%;">
                        </div>
                        <div class="card mt-3">
                            <div class="card-content">
                                <div class="table-responsive table-responsive-lg">
                                    <table class="table data-list-view table-sm">
                                        <thead>
                                        <tr class="text-center">
                                            <td scope="col">Hình ảnh</td>
                                            <td scope="col">Tên sản phẩm</td>
                                            <td scope="col">Giá sale</td>
                                            <td> Thao tác</td>
                                        </tr>
                                        </thead>
                                        <tbody class="item_product">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Tạo mới</button>
                            <button type="reset" class="btn btn-dark">Hủy</button>
                        </div>
                    </form>
                    <div class="p-3"
                         style="border-radius: 5px;box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);background-color: white">
                        <div class="d-flex justify-content-between align-items-center mb-3 ">
                            <h4>Danh sách sản phẩm</h4>
                            <div class="col-sm-6">
                                <div class="search">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-label-group position-relative has-icon-left mb-0"
                                                 style="background: #FFFFFF">
                                                <input type="text" id="search" class="form-control" name="search"
                                                       placeholder="Nhập tên sản phẩm"
                                                       style="color: black">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="table-responsive table-responsive-lg">
                                    <table class="table data-list-view table-sm">
                                        <thead>
                                        <tr class="text-center">
                                            <td scope="col">Hình ảnh</td>
                                            <td scope="col">Tên sản phẩm</td>
                                            <td scope="col">Đơn giá</td>
                                            <td> Thao tác </td>
                                        </tr>
                                        </thead>
                                        <tbody class="table_product">
                                        </tbody>
                                    </table>
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
    <script src="{{url('assets/js/input_file.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/format_currency.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/create-product.js')}}"></script>
    <script>
        let arr = [];
        function idSP(id) {
            arr.push(id);
            $.ajax({
                url: '{{url('admin/product-flash-sale/item_product')}}',
                method: 'GET',
                data: {data: arr},
                dataType: 'json',
                success: function (data) {
                    $('.item_product').html(data.table_data);
                }
            });
        }

        function deleteSP(id) {
            for (let i = 0; i < arr.length; i++) {
                if (arr[i] === id) {
                    arr.splice(i, 1);
                }
            }
            $.ajax({
                url: '{{url('admin/product-flash-sale/item_product/delete')}}',
                method: 'GET',
                data: {data: arr},
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        $('.item_product').html(data.table_data);
                    } else {
                        location.reload();
                    }
                }
            });

        }
    </script>
@endsection
