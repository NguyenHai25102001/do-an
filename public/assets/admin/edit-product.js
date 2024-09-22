$(document).ready(function () {
    $('button.delete__image').confirm({
        title: 'Xác nhận!',
        content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
        buttons: {
            ok: {
                text: 'Xóa',
                btnClass: 'btn-danger',
                action: function(){
                    let data = {};
                    data['id'] = this.$target.attr("value");
                    $.ajax({
                        url: window.location.origin + '/admin/products/delete-img',
                        data: data,
                        dataType: 'json',
                        type: 'post',
                        success: function (data) {
                            if (data.status){
                                location.reload();
                            }
                        }
                    });
                }
            },
            close: {
                text: 'Hủy',
                action: function () {}
            }
        }
    });
    $('a.btn-delete-name').confirm({
        title: 'Xác nhận!',
        content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
        buttons: {
            ok: {
                text: 'Xóa',
                btnClass: 'btn-danger',
                action: function(){
                    location.href = this.$target.attr('href');
                }
            },
            close: {
                text: 'Hủy',
                action: function () {}
            }
        }
    });
    $('a.btn-delete-color').confirm({
        title: 'Xác nhận!',
        content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
        buttons: {
            ok: {
                text: 'Xóa',
                btnClass: 'btn-danger',
                action: function(){
                    location.href = this.$target.attr('href');
                }
            },
            close: {
                text: 'Hủy',
                action: function () {}
            }
        }
    });

    let value = $('input[name="category"]').val();
    if (value == 1){
        $(".parameter_1").text('Ram :');
        $(".parameter_2").text('Kích thước màn hình :');
        $(".parameter_3").text('Nhu cầu sử dụng :');
        $(".parameter_4").text('Chíp xử lí :');
    }else if(value == 2){
        $(".parameter_1").text('Ram :');
        $(".parameter_2").text('Kích thước màn hình :');
        $(".parameter_3").text('Nhu cầu sử dụng :');
        $(".parameter_4").text('Chíp xử lí :');
    }else if(value == 3){
        $(".parameter_1").text('Ram :');
        $(".parameter_2").text('Kích thước màn hình :');
        $(".parameter_3").text('CPU :');
        $(".parameter_4").text('Card đồ họa :');
    }else if(value == 4){
        $(".parameter_1").text('Chất liệu viền :');
        $(".parameter_2").text('Kích cỡ mặt đồng hồ :');
        $(".parameter_3").text('Thời lượng pin');
        $(".parameter_4").text('Thiết kế :');
    }else if(value == 5){
        $(".parameter_1").text('Thông số 1 :');
        $(".parameter_2").text('Thông số 2 :');
        $(".parameter_3").text('Thông số 3');
        $(".parameter_4").text('Thông số 4');
    }else if(value == 6){
        $(".parameter_1").text('Thông số 1 :');
        $(".parameter_2").text('Thông số 2 :');
        $(".parameter_3").text('Thông số 3');
        $(".parameter_4").text('Thông số 4');
    }else {
        $(".parameter_1").text('Thông số 1 :');
        $(".parameter_2").text('Thông số 2 :');
        $(".parameter_3").text('Thông số 3');
        $(".parameter_4").text('Thông số 4');
    }
});
