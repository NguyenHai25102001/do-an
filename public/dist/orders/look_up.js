$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".btn-look-up").click(function () {
    let data = {};
    data['order_code'] = $('input[name="order_code"]').val();
    $.ajax({
        url: window.location.origin + '/chi-tiet-don-hang',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $(".content_order").html(data.html);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: data.msg,
                })
            }
        }
    });
});
