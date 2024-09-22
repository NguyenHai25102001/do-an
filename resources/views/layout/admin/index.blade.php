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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')
</head>
<body class="bg-neutral">
<!-- Header -->
@include('layout.admin.top-menu')
@include('layout.admin.main-menu')
<!-- End header -->
@yield('main')
<!-- Footer -->
@include('layout.admin.footer')
<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.min.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=ZDwUpEfF"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<!--end::Global Theme Bundle-->
@yield('script')
<div class="loading"></div>
<div id="overlay"></div>

<!-- END: Content-->
<div class="sidenav-overlay" style=""></div>
<div class="drag-target"></div>
<!-- BEGIN: Footer-->

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".image-preview", function () {
            $('#overlay')
                .css({backgroundImage: `url(${this.src})`})
                .addClass('open')
                .one('click', function() { $(this).removeClass('open'); });
        });

        $(document).on("click", ".btn-confirm", function () {
            let url = $(this).attr('data-url');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    showLoading();
                },
                success: function (data) {
                    alert(data.msg);
                    window.location.reload();
                },
                error: function () {
                    console.log('error')
                },
                complete: function () {
                    hideLoading();
                }
            });
        });

        $(document).on("click", ".btn-reject", function () {
            let url = $(this).attr('data-url');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    showLoading();
                },
                success: function (data) {
                    alert(data.msg);
                    window.location.reload();
                },
                error: function () {
                    console.log('error')
                },
                complete: function () {
                    hideLoading();
                }
            });
        })
    });
</script>

<script type="text/javascript">
    function changeImg(input){
        //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
        if(input.files && input.files[0]){
            var reader = new FileReader();
            //Sự kiện file đã được load vào website
            reader.onload = function(e){
                //Thay đổi đường dẫn ảnh
                $('#avatar').attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function() {
        $('#avatar').click(function(){
            $('#img').click();
        });
    });
</script>
<script>
    Pusher.logToConsole = true;

    let pusher = new Pusher('ed69eed56dde9c503dde', {
        cluster: 'ap1'
    });

    let channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
        const cartSuccess = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 7000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        cartSuccess.fire({
            icon: 'success',
            title: data.message
        });
        playNotificationSound(data.message);
    });

    function playNotificationSound(text) {
        var audio = new Audio('assets/notification/notification.mp3');
        audio.play().catch(function(error) {
            console.error('Lỗi phát âm thanh:', error);
        });
        audio.onended = function() {
            responsiveVoice.speak(text, 'Vietnamese Female', {
                onend: function () {
                    console.log('Giọng nói đã kết thúc.');
                },
            });
        };
    }
    function handleUserInteraction() {}

    $(document).on('click keydown', handleUserInteraction);
</script>
</body>
</html>
