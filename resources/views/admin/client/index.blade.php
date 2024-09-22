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
                                <h5 class="card-title">Danh sách khách hàng</h5>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                @if($status == 1)
                                    <form class="d-flex align-items-center w-50" method="get"
                                          action="{{route('admin.customer')}}">
                                        <input name="key_search" type="text" value="{{request()->get('key_search')}}"
                                               placeholder="Tìm kiếm theo tên và số điện thoại" class="form-control"
                                               style="margin-right: 16px">
                                        <button class="btn btn-info"><i class="bi bi-search"></i></button>
                                        <a href="{{route('admin.customer')}}" class="btn btn-danger"
                                           style="margin-left: 15px">Hủy </a>
                                    </form>
                                @else
                                    <form class="d-flex align-items-center w-50" method="get"
                                          action="{{route('admin.customer-buy-max')}}">
                                        <input name="key_search" type="text" value="{{request()->get('key_search')}}"
                                               placeholder="Tìm kiếm theo tên và số điện thoại" class="form-control"
                                               style="margin-right: 16px">
                                        <button class="btn btn-info"><i class="bi bi-search"></i></button>
                                        <a href="{{route('admin.customer-buy-max')}}" class="btn btn-danger"
                                           style="margin-left: 15px">Hủy </a>
                                    </form>
                                @endif
                            </div>
                            @if(count($listData) > 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Số điện thoại</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Số đơn đã mua</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listData as $index => $value)
                                        <tr>
                                            <th scope="row">{{$index+1}}</th>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->phone}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>{{$value->full_address}}</td>
                                            <td class="text-center">{{$value->order_count}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $listData->render('admin.pagination_custom.index') }}
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

