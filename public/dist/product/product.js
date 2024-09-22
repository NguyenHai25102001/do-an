$(function () {
    $('.slider-all').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-one'
    });
    $('.slider-one').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        asNavFor: '.slider-all',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        prevArrow: '<div class="d-none"></div>',
        nextArrow: '<div class="d-none"></div>',
    });
    $('._price').text($('.products_type_click.active').attr('data_promotional_price') + 'đ');
    $('.price_old').text($('.products_type_click.active').attr('data_price') + 'đ');
    $(document).on('click', '.products_type_click', clickColor);
});

let number = $('.products_type_click.active').attr('data_quantity');
if (number<=0){
    $("#text_contact").css('display','flex');
    $("#button-cart").css('display','none')
}else {
    $("#button-cart").css('display','flex');
    $("#text_contact").css('display','none')
}

$(".clickmore").click(function () {
    $("#boxdesc").toggleClass("show-more");
    if ($("#boxdesc").hasClass("show-more")) {
        $(".clickmore").text("Xem thêm");
    } else {
        $(".clickmore").text("Thu gọn");
    }
});

function clickColor() {
    $('.products_type_click.active').removeClass('active');
    $(this).addClass('active');
    $('._price').text($(this).attr('data_promotional_price') + 'đ');
    $('.price_old').text($(this).attr('data_price') + 'đ');
    let quantity = $(this).attr('data_quantity');
    if (quantity<=0){
        $("#text_contact").css('display','flex');
        $("#button-cart").css('display','none')
    }else {
        $("#button-cart").css('display','flex');
        $("#text_contact").css('display','none')
    }
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.rating-item input[type="radio"]').on('change', function () {
        const selectedRating = $(this).val();
        $('.start').removeClass('ratingAll')
        if (selectedRating == 2) {
            $("#rating1").addClass('ratingAll');
        }
        if (selectedRating == 3) {
            $("#rating1").addClass('ratingAll');
            $("#rating2").addClass('ratingAll');
        }
        if (selectedRating == 4) {
            $("#rating1").addClass('ratingAll');
            $("#rating2").addClass('ratingAll');
            $("#rating3").addClass('ratingAll');
        }
        if (selectedRating == 5) {
            $("#rating1").addClass('ratingAll');
            $("#rating2").addClass('ratingAll');
            $("#rating3").addClass('ratingAll');
            $("#rating4").addClass('ratingAll');
        }
    });

    $('.btn_send').click(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        let formData = {};
        formData['product_id'] = $('#product_id').val();
        formData['type'] = $('#type').val();
        formData['star'] = $('input[name="rating"]:checked').val();
        formData['content'] = $('#full_rate').val();
        formData['name'] = $('input[name="name"]').val();
        formData['phone'] = $('input[name="phone"]').val();
        formData['email'] = $('input[name="email"]').val();

        $.ajax({
            url: window.location.origin + '/danh-gia',
            type: 'post',
            dataType: 'json',
            data: formData,
            success: function (data) {
                if (data.status) {
                    localStorage.setItem('success', 'true');
                    location.reload();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.msg,
                    });
                }
            }
        });
    });

    let success = localStorage.getItem('success');
    if (success == 'true') {
        const ToastSuccess = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        ToastSuccess.fire({
            icon: 'success',
            title: 'Cảm ơn bạn đã gửi đánh giá.'
        });
        localStorage.setItem('success', 'false');
    }

    $(".btn-add-cart").click(function () {
        let data = {};
        data['product_attributes_id'] = $('.products_type_click.active').attr('data_product_id');
        data['token'] = localStorage.getItem('user_token');
        $.ajax({
            url: window.location.origin + '/api/cart/add-product',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(".number_cart").text(data.count_cart);
                    const cartSuccess = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    cartSuccess.fire({
                        icon: 'success',
                        title: data.msg
                    });
                    $('.list_carts').html('');
                    getCart();
                } else {
                    $("#modalCheckout").modal("show");
                }
            }
        });
    });

    $(".btn-buy").click(function () {
        let data = {};
        data['product_attributes_id'] = $('.products_type_click.active').attr('data_product_id');
        data['token'] = localStorage.getItem('user_token');
        $.ajax({
            url: window.location.origin + '/api/cart/add-product',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(".number_cart").text(data.count_cart);
                    location.replace('/thanh-toan')
                } else {
                    $("#modalCheckout").modal("show");
                }
            }
        });
    });

    let page = 2;
    $('#loadMore').click(function () {
        let data = {};
        data['product_id'] = $('#product_id').val();
        data['page'] = page;
        $.ajax({
            url: window.location.origin + '/api/get_review_product',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    let html = '';
                    data.forEach(function (post) {
                        let createdAtDate = new Date(post.created_at);
                        let day = createdAtDate.getDate();
                        let month = createdAtDate.getMonth() + 1;
                        let year = createdAtDate.getFullYear();
                        let formattedDate = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
                        html += `
                                <div class="mb-4 post">
                                    <div class="d-flex justify-content-between align-items-center"
                                         style="font-weight: 600">
                                        <p>${post.name}</p>
                                        <p>${formattedDate}</p>
                                    </div>
                                    <div class="boxReview-comment-item-review p-2 py-2">
                                        <div class="d-flex align-items-center">
                                            <span>Đánh giá: </span>
                                            <span class="px-2">
                                        <div class="star-rating" style="--rating:${post.star}"></div>
                                    </span>
                                        </div>
                                        <div>
                                            <span>Nhận xét: </span>
                                            <span>${post.content}</span>
                                        </div>
                                    </div>
                                </div>
                        `;
                    });
                    $('#postContainer').append(html);
                    page++;
                    if (data.length < 5) {
                        $('#loadMore').css('display', 'none');
                    }
                }
            }
        });
    });

});
