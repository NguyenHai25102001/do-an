@extends('web.layout.master')
@section('title','Kiểm tra đơn hàng của bạn')

@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/orders/look_up.css">
@stop

@section('content')
    <div class="headerCategory">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{url('/')}}"><span class="name">Trang chủ</span></a>
                <div class="breadcrumbs_sepa"></div>
                <a href="{{url('tra-cuu-don-hang')}}"><span class="name">Tra cứu đơn hàng</span></a>
            </div>
        </div>
    </div>
    <div class="container" style="min-height: 50vh">
        <div class="content-check">
            <p class="title_check">Kiểm tra đơn hàng của bạn</p>
            <div class="form_check">
                <input type="text" name="order_code" class="input_check">
                <button class="btn-look-up">TRA CỨU</button>
            </div>
        </div>
        <div class="content_order"></div>
    </div>
@stop

@section('script_page')
        <script src="{{asset('dist/orders/look_up.js')}}"></script>
@stop
