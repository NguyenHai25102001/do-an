<!doctype html>
<html lang="vi">
<head>
    <base href="{{asset('')}}">
    <meta name="google-site-verification" content="googleeacc2166ce777ac3.html"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Hebi Store</title>
    <link href="{{asset('assets/images/logo.png')}}" rel="icon">
    <link href="{{asset('assets/images/logo.png')}}" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/home/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/home/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/home/style.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/partials/style.css">
    <link rel="stylesheet" href="{{asset('assets/web/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('dist/style.css')}}">
    @yield('plugins_css')
    @yield('style_page')
</head>
<body>
{{--Header--}}
@include('web.partials.header')
{{--Content Page--}}
<main class="main">
    @yield('content')
</main>
<!-- Modal -->
<div class="modal fade" id="modalCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px!important;">
        <div class="modal-content">
            <div class="modal-header text-center" style="background: #0a58ca">
                <p class="modal-title mb-0 title_error" id="exampleModalLongTitle">THÔNG BÁO</p>
                <i class="fa-solid fa-xmark p-2" style="font-size: 22px;cursor: pointer;color: white" data-bs-dismiss="modal" aria-label="Close"></i>
            </div>
            <div class="modal-body">
                <p>Quý khách có nhu cầu mua số lượng nhiều vui lòng liên hệ phòng bán hàng doanh nghiệp B2B:</p>
                <p>Ms.Linh: <a href="tel:0788888162" style="color: #0a58ca">0788.888.162</a></p>
                <p>Email: <a href="mailto:ecom@cellphones.com.vn" style="color: #0a58ca">ecom@cellphones.com.vn</a></p>
            </div>
        </div>
    </div>
</div>
{{--Footer--}}
<button class="btn" id="button"><i class="fas fa-arrow-up text-white"></i></button>
@include('web.partials.footer')
<div class="moby-overlay"></div>
<script src="assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/home/vendor/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/web/slick/slick.min.js')}}"></script>
@yield('script_page')
<script src="{{asset('dist/home/home.js')}}"></script>
<script>
    @if(session('error'))
    Swal.fire({
        icon: "error",
        title: "{{session('error')}}",
    });
    @endif
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '{{session('success')}}',
    });
    @endif
</script>
</body>
</html>
