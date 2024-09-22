<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="{{asset('')}}">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{$titlePage}}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{asset('assets/images/logo.png')}}" rel="icon">
    <link href="{{asset('assets/images/logo.png')}}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-neutral">
<style>
    .content__product:nth-child(2n) {
        background: #E0E0E0;
    }
    #main{
        margin-left: 0px;
        margin-top: 0px;
    }
</style>
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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <a href="{{route('admin.import-export-product.import')}}" style="margin-right: 10px;font-size: 25px"><i class="fa-solid fa-arrow-left"></i></a>
                            <h5 class="card-title">Danh sách xuất nhập tồn sản phẩm</h5>
                            {{--                                <div>--}}
                            {{--                                    <a class="btn btn-success" href="{{route('admin.import-export-product.create-export')}}">Xuất hàng</a>--}}
                            {{--                                </div>--}}
                        </div>
                        <div class="mb-2 mt-3 d-flex justify-content-end">
                            <form action="{{route('admin.import-export-product.index')}}" method="get"
                                  class="w-100 d-flex justify-content-end">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <p class="m-0" style="width: 100px;font-weight: 600">Từ ngày</p>
                                        <input type="date" class="form-control" name="date_form"
                                               value="{{request()->get('date_form')}}" style="max-width: 240px">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="d-flex align-items-center">
                                        <p class="m-0" style="width: 160px;padding: 0 20px;font-weight: 600">Đến
                                            ngày</p>
                                        <input type="date" class="form-control" name="date_to"
                                               value="{{request()->get('date_to')}}" style="max-width: 240px">
                                    </div>
                                </div>
                                <button class="btn btn-info" style="margin-left: 15px">Lọc</button>
                                <button type="submit" class="btn btn-success" name="excel" value="2" style="margin: 0 15px">Xuất Excel</button>
                                <a href="{{route('admin.import-export-product.index')}}" class=" btn btn-danger btn_exit">Hủy</a>
                            </form>
                        </div>
                        <div class="card-body pt-3 pb-3 px-0 ">
                            <div class="overflow-auto">
                                <div>
                                    <div class="d-flex w-100 align-items-center text-center text-white font-size-16"
                                         style="background: #4154f1;padding: 5px 0">
                                        <div style="width: 20%">Tên sản phẩm</div>
                                        <div style="width: 8%">Loại sản phẩm</div>
                                        <div style="width: 10%">Tồn đầu SL</div>
                                        <div style="width: 12%">Tồn đầu TT</div>
                                        <div style="width: 6%">Nhập SL</div>
                                        <div style="width: 10%">Nhập TT</div>
                                        <div style="width: 6%">Xuất SL</div>
                                        <div style="width: 10%">Xuất TT</div>
                                        <div style="width: 10%">Tồn cuối SL</div>
                                        <div style="width: 12%">Tồn cuối TT</div>
                                    </div>
                                    <div class="w-100 bg-white mt-10">
                                        @foreach($listData as $item)
                                            <div class="w-100 d-flex p-2 content__product align-items-center">
                                                <div style="width: 20%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{$item->product_name}}</p>
                                                </div>
                                                <div style="width: 8%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{$item->attribute_name}}</p>
                                                </div>
                                                <div style="width: 10%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->survive_sl)}}</p>
                                                </div>
                                                <div style="width: 12%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->survive_tt)}}</p>
                                                </div>
                                                <div style="width: 6%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->import_sl)}}</p>
                                                </div>
                                                <div style="width: 10%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->import_tt)}}</p>
                                                </div>
                                                <div style="width: 6%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->export_sl)}}</p>
                                                </div>
                                                <div style="width: 10%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->export_tt)}}</p>
                                                </div>
                                                <div style="width: 10%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->ending_sl)}}</p>
                                                </div>
                                                <div style="width: 12%" class="d-flex justify-content-center">
                                                    <p class="mb-0">{{number_format($item->ending_tt)}}</p>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
