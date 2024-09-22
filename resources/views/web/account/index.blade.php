@extends('web.layout.master')
@section('title','Hebi Mobile')
{{--meta--}}
@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/account/account.css">
@stop
{{--content of page--}}
@section('content')
    <div class="headerCategory">
        <div class="container">
            <div class="breadcrumb">
                <a href="">
                    <span class="name">Trang chủ</span>
                </a>
                <div class="breadcrumbs_sepa"></div>
                <a href="">
                    <span class="name">Tài khoản của tôi</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-between flex-wrap">
        <div class="menu-left">
            <div class="menu-item">
                <i class="fa-solid fa-user"></i>
                <span>Tài khoản của bạn</span>
            </div>
            <div class="menu-item">
                <i class="fa-solid fa-receipt"></i>
                <span>Lịch sử mua hàng</span>
            </div>
            <div class="menu-item">
                <i class="fa-solid fa-headset"></i>
                <span>Hỗ trợ</span>
            </div>
            <div class="menu-item">
                <i class="fa-regular fa-pen-to-square"></i>
                <span>Góp ý phản hồi</span>
            </div>
            <div class="menu-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Thoát tài khoản</span>
            </div>
        </div>
        <div class="content">
            <div class="content-right">
                <form action="" class="card-edit">
                        <img src="https://cellphones.com.vn/smember/_nuxt/img/Shipper_CPS3.0251fdd.png" alt="" class="avatar-account">
                        <p class="title-account">Nguyễn Đạt</p>
                    <input type="text" name="" class="form-control item-form" placeholder="Họ và tên">
                    <input type="text" name="" class="form-control item-form" placeholder="Giới tính">
                    <input type="text" name="" class="form-control item-form" placeholder="Số điện thoại">
                    <input type="text" name="" class="form-control item-form" placeholder="Địa chỉ">
                    <button class="btn-form-submit">Cập nhật thông tin</button>
                </form>
            </div>
            <div class="card_support">
                <div class="card_support_item">
                    <img src="https://cellphones.com.vn/smember/_nuxt/img/headphones%201.c7d474f.png" alt="">
                    <div style="padding: 15px 5px">
                        <p class="title-support">Tư vấn mua hàng (8h00 - 22h00)</p>
                        <p class="phone-hotline">1800.2097</p>
                    </div>
                </div>
                <div class="card_support_item">
                    <img src="	https://cellphones.com.vn/smember/_nuxt/img/waranty%201.a9ef39d.png" alt="">
                    <div style="padding: 15px 5px">
                        <p class="title-support">Bảo hành (8h00 - 21h00)</p>
                        <p class="phone-hotline">1800.2064</p>
                    </div>
                </div>
                <div class="card_support_item">
                    <img src="	https://cellphones.com.vn/smember/_nuxt/img/bad-review.ac59f16.png" alt="">
                    <div style="padding: 15px 5px">
                        <p class="title-support">Khiếu nại (8h00 - 21h30)</p>
                        <p class="phone-hotline">1800.2063</p>
                    </div>
                </div>
                <div class="card_support_item">
                    <img src="	https://cellphones.com.vn/smember/_nuxt/img/message%201.259c9d3.png" alt="">
                    <div style="padding: 15px 5px">
                        <p class="title-support">Email</p>
                        <p class="phone-hotline">cskh@hebiphone.vn</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeZq-nqQzUe14TqFetxIFVoQcpvSafhs7t33UunTvfUys6Qow/viewform?embedded=true" width="640" height="600" frameborder="0" marginheight="0" marginwidth="0">Đang tải…</iframe>
            </div>
        </div>

    </div>
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@section('script_page')

@stop
