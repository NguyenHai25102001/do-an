@extends('web.layout.master')
@section('title','Hebi Store')

@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/pay/pay.css">
@stop

@section('content')
    <div class="container">
        <div class="container-cart">
            <div class="nav-cart">
                <a href="{{url('/')}}" class="buy-more">
                    <i class="fa fa-angle-left"></i>
                    Mua thêm sản phẩm khác </a>
            </div>
            <div class="content-cart">
                <div class="list-products">
                </div>
                <div class="payment">
                    <form action="{{route('create-order')}}" method="post" class="formPayment" id="formPayment">
                        @csrf
                        <input type="hidden" name="user_token" class="user_token" >
                        <h3 class="h3_title mt-0">Thông tin mua hàng</h3>
                        <div class="mb-2">
                            <label for="gender1">
                                <input type="radio" name="vocative" id="gender1" value="Anh" checked>
                                <span>Anh</span>
                            </label>
                            <label for="gender0">
                                <input type="radio" name="vocative" id="gender0" value="Chị">
                                <span>Chị</span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <input class="form-control" type="text" name="name" id="name" placeholder="Họ tên" required>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <input class="form-control" type="text" name="phone" id="phone"
                                       placeholder="Số điện thoại" required>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <input class="form-control" type="text" name="email" id="email"
                                       placeholder="Email (Vui lòng điền email để nhận hóa đơn VAT)">
                            </div>
                        </div>
                        <h3 class="h3_title">Chọn cách thức nhận hàng</h3>
                        <input class="input-header" type="radio" name="delivery_address" value="Giao tận nơi" id="one" checked="checked"/>
                        <label for="one">Giao tận nơi</label>

                        <input class="input-header" type="radio" value="Nhận tại cửa hàng" name="delivery_address" id="two"/>
                        <label for="two">Nhận tại cửa hàng</label>
                        <article class="content one tabReceive">
                            <div class="" id="tab0">
                                <p class="tab-title">
                                    Chọn địa chỉ để biết thời gian và phí vận chuyển (nếu có) </p>
                                <div class="row row_1">
                                    <div class="col-md-6 col-xs-6 pd1">
                                        <select class="form-select" name="province_id" id="city">
                                            <option value="" selected hidden
                                                    disabled>Tỉnh/ Thành phố
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-6 pd1">
                                        <select class="form-select" name="district_id" id="district" onchange="changeAddress()">
                                            <option value="" selected hidden disabled>Quận/ Huyện</option>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-xs-12 pd1">
                                        <select class="form-select" name="ward_id" id="ward" onchange="changeAddress()">
                                            <option value="" selected hidden disabled>Phường/ Xã</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-12 pd1">
                                        <input class="form-control" type="text" name="address_detail" id="address" onkeyup="changeAddress()"
                                               placeholder="Số nhà, tên đường">
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="content two tabReceive">
                            <div class="" id="tab1">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <input class="form-control bg-white" type="text" name="store" id="store"
                                               value="Hà Nội" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </article>

                        <div class="request_orther" style="padding-top: 30px">
                            <input class="form-control" type="text" name="note" id="note"
                                   placeholder="Yêu cầu khác (không bắt buộc)">
                        </div>

                        <label for="company" class="company" data-bs-toggle="collapse"
                               data-bs-target="#collapseExampleCTY" aria-expanded="false"
                               aria-controls="collapseExample">
                            <input type="checkbox" name="issue_invoice" id="company" value="1">
                            <span>Xuất hóa đơn công ty</span>
                        </label>
                        <div class="collapse" id="collapseExampleCTY">
                            <div class="row bill_company">
                                <div class="col-md-12 col-xs-12">
                                    <input class="form-control" type="text" name="com_name" id="com_name"
                                           placeholder="Tên công ty">
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <input class="form-control" type="text" name="com_add" id="com_add"
                                           placeholder="Địa chỉ">
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <input class="form-control" type="text" name="com_tax" id="com_tax"
                                           placeholder="Mã số thuế">
                                </div>
                            </div>
                        </div>
                        <div class="pt-3 d-flex flex-column">
                            <label for="payment0" style="padding-bottom: 6px">
                                <input type="radio" name="type_payment" id="payment0" value="1" checked>
                                <span>Thanh toán khi nhận hàng</span>
                            </label>
                            <label for="payment1">
                                <input type="radio" name="type_payment" id="payment1" value="2">
                                <span>Thanh toán bằng VNPAY</span>
                            </label>
                        </div>
                        <p class="total_end pb-0">Phí vận chuyển:
                            <span id="total_money" class="total_free_ship" style="color: black!important;">0đ</span>
                        </p>
                        <input type="hidden" class="total_product" >
                        <input type="hidden" class="fee_ship" name="fee_ship" value="0">
                        <p class="total_end pb-0 pt-2">Tổng tiền sản phẩm:
                            <span id="total_money" class="total_money_product" style="color: black!important;">0đ</span>
                        </p>
                        <p class="total_end pt-2">Tổng thanh toán:
                            <span id="total_money" class="total_money_all">0đ</span>
                        </p>
                        <div class="btn-area">
                            <button type="submit" id="cod-btn" class="payment-btn">Đặt hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3G5DUAOaV9CFr3Pft_X-949-64zXaBg&libraries=geometry"></script>
@section('script_page')
    <script src="{{asset('dist/pay/pay.js')}}"></script>
@stop
