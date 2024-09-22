setUserNameCookie();
getCart();
function ProductSale() {
    $('.product_sale').slick({
        infinite: false,
        autoplay: false,
        dots: false,
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 2,
        prevArrow: '<div class="prev-arrow"><div class="btn btn-prev"></div></div>',
        nextArrow: '<div class="next-arrow"><div class="btn btn-next"></div></div>',
        centerMode: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 999,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1.5,
                    slidesToScroll: 1,
                    initialSlide: 0,
                },
            },
        ]
    })
}

function ScrollToTop() {
    let btn = $('#button');
    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function () {
        window.scrollTo({top: 0, left: 0, behavior: 'smooth'});
    });
}

let date = $('#time_end').attr('data-end');
let countDownDate = new Date(date).getTime();
let x = setInterval(function () {
    let now = new Date().getTime();
    let distance = countDownDate - now;
    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    const dayElements = document.querySelectorAll(".day");
    const hourElements = document.querySelectorAll(".hours");
    const minuteElements = document.querySelectorAll(".minutes");
    const secondElements = document.querySelectorAll(".seconds");
    for (let i = 0; i < dayElements.length; i++) {
        dayElements[i].innerHTML = days + "D";
        hourElements[i].innerHTML = hours + " :";
        minuteElements[i].innerHTML = minutes + " :";
        secondElements[i].innerHTML = seconds;
    }
}, 1000);

$(function () {
    ProductSale();
    ScrollToTop();
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        prevArrow: '<div class="d-none"></div>',
        nextArrow: '<div class="d-none"></div>',
    });
    $('.product-tech').slick({
        infinite: false,
        autoplay: false,
        dots: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 2,
        prevArrow: '',
        nextArrow: '',
        centerMode: false,
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2.6,
                    slidesToScroll: 1,
                },
            }
        ]
    })
});
for (let i = 1; i <= 3; i++) {
    $('.title-menu' + i).on('click', function () {
        $(".title-menu" + i).toggleClass("active");
        $(".nav-bottom" + i).toggleClass("bottom-nav2");
    });
}

$('.tab-click').on('click', function () {
    $(".menu-click").toggleClass("menu-click-active");
    $(".moby-overlay").toggleClass('overlay-active');
});
$('.moby-overlay').on('click', function () {
    $(".menu-click").toggleClass("menu-click-active");
    $(".moby-overlay").toggleClass('overlay-active');
});
$('#procat').on('click', function () {
    $(".danhmuc ").toggleClass("active");
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function getCart() {
    let data = {};
    data['token'] = localStorage.getItem('user_token');
    $.ajax({
        url: window.location.origin + '/api/cart/get_cart',
        data: data,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                let count_cart = data.data.length;
                $(".number_cart").text(count_cart);
                let html = '';
                let total_money = 0;
                if (count_cart > 0){
                    for (let i=0;i<count_cart;i++){
                        html += `
                            <div class="d-flex line_cart_small">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="${data.data[i].product_infor.image}" alt=""
                                         class="img-cart-small">
                                    <div style="cursor: pointer" onclick="deleteProduct(${data.data[i].id})">
                                        <i class="fa-solid fa-circle-xmark mt-2" style="color: red;font-size: 15px;"></i>
                                        <span style="color: red">Xóa</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="title_sp_cart_small">${data.data[i].product.name}</p>
                                    <p class="type_cart_sp_small">Màu: ${data.data[i].product_attribute.name}</p>
                                    <p class="price_sp_cart_small price_sp_${i}">${formatPrice(data.data[i].total_money)}₫</p>
                                    <input type="hidden" class="cart_id_${i}" name="cart_id" value="${data.data[i].id}">
                                    <span class="number-input">
                                    <button type="button"
                                            onclick="change_quantity(${i},2)"
                                            class="down down_quantity"><i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="number"
                                           name="quantity_${i}"
                                           id="quantity_${i}"
                                           class="numbersOnly"
                                           maxlength="5"
                                           disabled
                                           value="${data.data[i].quantity}"/>
                                    <button type="button"
                                            onclick="change_quantity(${i},1)"
                                            class="plus"><i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                             </div>
                        </div>
                    `;
                        total_money += data.data[i].total_money;
                    }
                    $('.list_carts').append(html);
                    let htmlMoney = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="title_end_small">Tổng tiền</span>
                        <span class="total_end_small">${formatPrice(total_money)}₫</span>
                    </div>
                    <a href="${window.location.origin +'/thanh-toan'}"><button type="submit" class="payment-btn-small">Thanh toán</button></a>
                    `;
                    $('.list_carts').append(htmlMoney);
                }else {
                    html = `<p class="text_empty"><i class="fa-solid fa-face-frown face_frown"></i> </br>Không có sản phẩm nào trong giỏ hàng </br>Vui lòng thêm sản phẩm.</p>`;
                    $('.list_carts').html(html);
                }
            }
        }
    });
};

function change_quantity(index,type) {
    let data = {};
    data['type'] = type;
    data['cart_id'] = $('.cart_id_'+index).val();
    data['token'] = localStorage.getItem('user_token');
    $.ajax({
        url: window.location.origin + '/api/cart/change-quantity',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                $('#quantity_'+index).val(data.quantity);
                $('.price_sp_'+index).text(formatPrice(data.total_money)+'đ');
                $('.total_end_small').text(formatPrice(data.sum_price)+'đ')
            } else {
                $("#modalCheckout").modal("show");
                $("#offcanvasRight").offcanvas("hide");
            }
        }
    });
}

function deleteProduct(id) {
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
                $('.list_carts').html('');
                getCart();
            } else {

            }
        }
    });
}

function formatPrice(number) {
    return new Intl.NumberFormat("en-US", { minimumFractionDigits: 0 }).format(number);
}

function generateRandomName() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomName = '';
    for (let i = 0; i < 50; i++) {
        randomName += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return randomName;
}

function setUserNameCookie() {
    let userName = getCookie("user_token");
    if (!userName) {
        userName = generateRandomName();
        setCookie("user_token", userName, 365);
    }
    localStorage.setItem('user_token',userName);
}

function getCookie(cookieName) {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}

function setCookie(cookieName, cookieValue, expirationDays) {
    const d = new Date();
    d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}

document.addEventListener("DOMContentLoaded", function() {
    var lazyloadImages;

    if ("IntersectionObserver" in window) {
        lazyloadImages = document.querySelectorAll(".lazy");
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.remove("lazy");
                    imageObserver.unobserve(image);
                }
            });
        });

        lazyloadImages.forEach(function(image) {
            imageObserver.observe(image);
        });
    } else {
        var lazyloadThrottleTimeout;
        lazyloadImages = document.querySelectorAll(".lazy");

        function lazyload () {
            if(lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }

            lazyloadThrottleTimeout = setTimeout(function() {
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function(img) {
                    if(img.offsetTop < (window.innerHeight + scrollTop)) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if(lazyloadImages.length == 0) {
                    document.removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }

        document.addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
    }
});
