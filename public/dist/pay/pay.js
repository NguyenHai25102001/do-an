$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
getPay();
$('.user_token').val(localStorage.getItem('user_token'));
function getPay() {
    let data = {};
    data['user_token'] = localStorage.getItem('user_token');
    $.ajax({
        url: window.location.origin + '/api/get-pay',
        data: data,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                let count_cart = data.data.length;
                let html = '';
                let province = '';
                let total_money = 0;
                for (let i = 0; i < count_cart; i++) {
                    html += `
                                 <div class="product-cart1">
                                    <div class="product-cart">
                                        <input type="hidden" class="cart_id_${i}" value="${data.data[i].id}">
                                        <div class="product-image text-center p-0">
                                            <a href="${window.location.origin + 'san-pham/' + `${data.data[i].product.slug}`}">
                                                <img src="${data.data[i].product_infor.image}" class="img-responsive"/>
                                            </a>
                                            <a class="del-pro-link" onclick="deleteCart(${data.data[i].id})" style="color: red">
                                                <i class="fa-solid fa-circle-xmark"
                                                   style="font-size: 16px;margin-right: 3px"></i>Xóa</a>
                                        </div>
                                        <div class="product-detail">
                                            <div class="top_detail">
                                                <a class="product-name-cart"
                                                   href="${window.location.origin + 'san-pham/' + `${data.data[i].product.slug}`}">${data.data[i].product.name}</a>
                                                <div class="fee visibleCart-xs">
                                                    <p class="price-item price_item_{{$index}}">${formatPrice(data.data[i].product_attribute.promotional_price*data.data[i].quantity)}
                                                        đ</p>
                                                    <del
                                                        class="old-price old_price_{{$index}}">${formatPrice(data.data[i].product_attribute.price*data.data[i].quantity)}
                                                        đ
                                                    </del>
                                                </div>
                                            </div>
                                            <div class="price_detail">
                                                <div class="box_color">
                                                    <span
                                                        class="select_color">Màu: ${data.data[i].product_attribute.name}</span>
                                                </div>
                                                <div class="quan visibleCart-xs">
                                                    <span class="number-input">
                                                        <button type="button"
                                                                onclick="change_quantity_pay(${i},2)"
                                                                class="down">
                                                        </button>
                                                        <input type="number"
                                                               name="quantity"
                                                               class="numbersOnly1 number_${i}"
                                                               maxlength="5"
                                                               value="${data.data[i].quantity}"
                                                               disabled/>
                                                        <button type="button"
                                                                onclick="change_quantity_pay(${i},1)"
                                                                class="plus">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-price-cart hiddenCart-xs">
                                            <div class="fee">
                                                <p class="price-item price_item_${i}">${formatPrice(data.data[i].product_attribute.promotional_price*data.data[i].quantity)}đ</p>
                                                <del
                                                    class="old-price old_price_${i}">${formatPrice(data.data[i].product_attribute.price*data.data[i].quantity)}đ
                                                </del>
                                            </div>
                                            <div class="quan">
                                                <span class="number-input">
                                                    <button type="button"
                                                            onclick="change_quantity_pay(${i},2)"
                                                            class="down"></button>
                                                    <input type="number"
                                                           name="quantity"
                                                           class="numbersOnly1 number_${i}"
                                                           maxlength="5"
                                                           value="${data.data[i].quantity}"
                                                           disabled/>
                                                    <button type="button"
                                                            onclick="change_quantity_pay(${i},1)"
                                                            class="plus"></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `;
                    total_money += data.data[i].total_money;
                }
                for (let j = 0; j < data.data_province.length; j++) {
                    province += `
                                    <option value="${data.data_province[j].ProvinceID}">${data.data_province[j].ProvinceName}</option>
                        `;
                }
                $('.list-products').append(html);
                $('#city').append(province);
                $('.total_money_product').text(formatPrice(data.sum_price) + 'đ');
                $('.total_product').val(data.sum_price);
                let total_all = parseInt($('.fee_ship').val()) + parseInt(data.sum_price);
                $('.total_money_all').text(formatPrice(total_all)+'đ');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: data.msg,
                }).then((result) => {
                    location.replace('/')
                })
            }
        }
    });
};

//Danh sách Quận/ Huyện
$('select[name="province_id"]').change(function () {
    let province_id = $(this).val();
    $.ajax({
        url: window.location.origin + '/get_district/' + province_id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $('select[name="district_id"]').html(data.html);
                let district_id = $('select[name="district_id"]').val();
                $.ajax({
                    url: window.location.origin + '/get_ward/' + district_id,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('select[name="ward_id"]').html(data.html);
                            changeAddress();
                        }
                    }
                });
            }
        }
    });
});

//Danh sách phường xã
$('select[name="district_id"]').change(function () {
    let district_id = $(this).val();
    $.ajax({
        url: window.location.origin + '/get_ward/' + district_id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $('select[name="ward_id"]').html(data.html);
                changeAddress();
            }
        }
    });
});

function change_quantity_pay(index, type) {
    let data = {};
    data['type'] = type;
    data['cart_id'] = $('.cart_id_' + index).val();
    data['token'] = localStorage.getItem('user_token');
    $.ajax({
        url: window.location.origin + '/api/cart/change-quantity',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $('.number_' + index).val(data.quantity);
                $('.price_item_' + index).text(formatPrice(data.total_money) + 'đ');
                $('.old_price_' + index).text(formatPrice(data.money_base) + 'đ');
                $('.total_money_product').text(formatPrice(data.sum_price) + 'đ');
                $('.total_product').val(data.sum_price);
                changeAddress();
                let total_all = parseInt($('.fee_ship').val()) + parseInt(data.sum_price);
                $('.total_money_all').text(formatPrice(total_all)+'đ');
            } else {
                $("#modalCheckout").modal("show");
            }
        }
    });
}

function deleteCart(id) {
    let data = {};
    data['cart_id'] = id;
    data['token'] = localStorage.getItem('user_token');
    $.ajax({
        url: window.location.origin + '/api/cart/delete',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                if (data.sum_price > 0){
                    $('.list-products').html('');
                    getPay();
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Vui lòng thêm sản phẩm vào giỏ hàng để tiếp tục.',
                    }).then((result) => {
                        location.replace('/')
                    })
                }
            }
        }
    });
}

function changeAddress() {
    if($('select[name="province_id"]').val() && $('select[name="district_id"]').val() && $('select[name="ward_id"]').val() && $('#address').val()){
        let data = {};
        data['province_id'] = $('select[name="province_id"]').val();
        data['district_id'] = $('select[name="district_id"]').val();
        data['ward_id'] = $('select[name="ward_id"]').val();
        data['address_detail'] = $('#address').val();
        data['total_all'] = $('.total_product').val();
        $.ajax({
            url: window.location.origin + '/api/fee_ship_order',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    calculateDistance("Nhà số 1, Ngõ 37, Xã tả thanh oai, Thanh trì, Hà Nội", data.address)
                        .then(distance => {
                            let total_all_ship = 0;
                            if (distance > 10){
                                if (data.total_product > 5000000){
                                    $('.total_free_ship').text(0 + 'đ');
                                    $('.fee_ship').val(0);
                                    total_all_ship = parseInt($('.total_product').val());
                                }else {
                                    $('.total_free_ship').text(formatPrice(data.ship) + 'đ');
                                    $('.fee_ship').val(data.ship);
                                    total_all_ship = parseInt($('.total_product').val())+parseInt(data.ship);
                                }
                            }else {
                                $('.total_free_ship').text(0 + 'đ');
                                $('.fee_ship').val(0);
                                total_all_ship = parseInt($('.total_product').val());
                            }
                            $('.total_money_all').text(formatPrice(total_all_ship)+'đ');
                        })
                        .catch(error => {
                            alert(error)
                        });
                } else {
                    swal({
                        title: data.msg,
                        icon: "error",
                        button: "Xác nhận!",
                    });
                }
            }
        });
    }

}

function calculateDistance(address1, address2) {
    return new Promise((resolve, reject) => {
        let service = new google.maps.DistanceMatrixService();

        service.getDistanceMatrix(
            {
                origins: [address1],
                destinations: [address2],
                travelMode: 'DRIVING',
            },
            function (response, status) {
                if (status === 'OK') {
                    let distanceInMeters = response.rows[0].elements[0].distance.value;
                    let distanceInKm = distanceInMeters / 1000;
                    resolve(distanceInKm.toFixed(0));
                } else {
                    reject("Không thể tính toán khoảng cách.");
                }
            }
        );
    });
}
