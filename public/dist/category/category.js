$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let rangeMin = 100;
    const range = $(".range-selected");
    const rangeInput = $(".range-input input");
    const rangePrice = $(".range-price .number_price");
    rangeInput.on("input", function (e) {
        let minRange = parseInt(rangeInput.eq(0).val());
        let maxRange = parseInt(rangeInput.eq(1).val());

        if (maxRange - minRange < rangeMin) {
            if ($(e.target).hasClass("min")) {
                rangeInput.eq(0).val(maxRange - rangeMin);
            } else {
                rangeInput.eq(1).val(minRange + rangeMin);
            }
        } else {
            rangePrice.eq(0).text(formatPrice(minRange) + 'đ');
            rangePrice.eq(1).text(formatPrice(maxRange) + 'đ');
            range.css("left", (minRange / rangeInput.eq(0).attr("max")) * 100 + "%");
            range.css("right", 100 - (maxRange / rangeInput.eq(1).attr("max")) * 100 + "%");
        }
        $('.btn-filter-group').css('display', 'flex');
    });

    rangePrice.on("input", function (e) {
        let minPrice = rangePrice.eq(0).text();
        let maxPrice = rangePrice.eq(1).text();

        if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput.eq(1).attr("max")) {
            if ($(e.target).hasClass("min")) {
                rangeInput.eq(0).val(minPrice);
                range.css("left", (minPrice / rangeInput.eq(0).attr("max")) * 100 + "%");
            } else {
                rangeInput.eq(1).val(maxPrice);
                range.css("right", 100 - (maxPrice / rangeInput.eq(1).attr("max")) * 100 + "%");
            }
        }
    });

    $('input[name="check-one"]').click(function () {
        $('.btn-filter-group1').css('display', 'flex')
        $('label.btn').removeClass('active_filter');
        $(this).siblings('label.btn').addClass('active_filter');
    });
    $('input[name="check-two"]').click(function () {
        $('.btn-filter-group2').css('display', 'flex')
        $('label.btn').removeClass('active_filter');
        $(this).siblings('label.btn').addClass('active_filter');
    });
    $('input[name="check-three"]').click(function () {
        $('.btn-filter-group3').css('display', 'flex')
        $('label.btn').removeClass('active_filter');
        $(this).siblings('label.btn').addClass('active_filter');
    });
    $('input[name="check-four"]').click(function () {
        $('.btn-filter-group4').css('display', 'flex')
        $('label.btn').removeClass('active_filter');
        $(this).siblings('label.btn').addClass('active_filter');
    });
    $('input[name="check-five"]').click(function () {
        $('.btn-filter-group5').css('display', 'flex')
        $('label.btn').removeClass('active_filter');
        $(this).siblings('label.btn').addClass('active_filter');
    });

    let data = {};
    let url = window.location.origin + '/bo-loc';
    $('.sort_price').click(function () {
        $(".sort_price").removeClass("active_filter");
        $(this).addClass("active_filter");
        $(".checkTwo").each(function () {
            let input = $(this).find('input[name="check-one"]');
            if (input.is(":checked")) {
                data['parameter_one'] = input.val();
            }
        });
        $(".checkThree").each(function () {
            let input = $(this).find('input[name="check-two"]');
            if (input.is(":checked")) {
                data['parameter_five'] = input.val();
            }
        });
        $(".checkFour").each(function () {
            let input = $(this).find('input[name="check-three"]');
            if (input.is(":checked")) {
                data['parameter_two'] = input.val();
            }
        });
        $(".checkFive").each(function () {
            let input = $(this).find('input[name="check-four"]');
            if (input.is(":checked")) {
                data['parameter_three'] = input.val();
            }
        });
        $(".checkSix").each(function () {
            let input = $(this).find('input[name="check-five"]');
            if (input.is(":checked")) {
                data['parameter_four'] = input.val();
            }
        });
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['sort'] = $(this).attr('data-value');
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    });

    $('.resultOne').click(function () {
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        $(".btnOne").addClass("active_filter");
        $(".close_one").css('display', 'flex');
        filterProduct();
    });

    $('.resultTwo').click(function () {
        $(".checkTwo").each(function () {
            let input = $(this).find('input[name="check-one"]');
            if (input.is(":checked")) {
                data['parameter_one'] = input.val();
                $(".btnTwo").addClass("active_filter");
                $(".close_two").css('display', 'flex');
            }
        });
        filterProduct();
    });

    $('.resultThree').click(function () {
        $(".checkThree").each(function () {
            let input = $(this).find('input[name="check-two"]');
            if (input.is(":checked")) {
                data['parameter_five'] = input.val();
                $(".btnThree").addClass("active_filter");
                $(".close_three").css('display', 'flex');
            }
        });
        filterProduct();
    });

    $('.resultFour').click(function () {
        $(".checkFour").each(function () {
            let input = $(this).find('input[name="check-three"]');
            if (input.is(":checked")) {
                data['parameter_two'] = input.val();
                $(".btnFour").addClass("active_filter");
                $(".close_four").css('display', 'flex');
            }
        });
        filterProduct();
    });

    $('.resultFive').click(function () {
        $(".checkFive").each(function () {
            let input = $(this).find('input[name="check-four"]');
            if (input.is(":checked")) {
                data['parameter_three'] = input.val();
                $(".btnFive").addClass("active_filter");
                $(".close_five").css('display', 'flex');
            }
        });
        filterProduct();
    });

    $('.resultSix').click(function () {
        $(".checkSix").each(function () {
            let input = $(this).find('input[name="check-five"]');
            if (input.is(":checked")) {
                data['parameter_four'] = input.val();
                $(".btnSix").addClass("active_filter");
                $(".close_six").css('display', 'flex');
            }
        });
        filterProduct();
    });

    $('.close_one').click(deleteOne);
    $('.cancelOne').click(function () {
        deleteOne();
        $(".btnOne").click();
    });

    $('.close_two').click(deleteTwo);
    $('.cancelTwo').click(function () {
        deleteTwo();
        $(".btnTwo").click();
    });

    $('.close_three').click(deleteThree);
    $('.cancelThree').click(function () {
        deleteThree();
        $(".btnThree").click();
    });

    $('.close_four').click(deleteFour);
    $('.cancelFour').click(function () {
        deleteFour();
        $(".btnFour").click();
    });

    $('.close_five').click(deleteFive);
    $('.cancelFive').click(function () {
        deleteFive();
        $(".btnFive").click();
    });

    $('.close_six').click(deleteSix);
    $('.cancelSix').click(function () {
        deleteSix();
        $(".btnSix").click();
    });

    function filterProduct() {
        data['sort'] = $('.active_filter').attr('data-value');
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
        $(".btnSix").click();
    }

    function deleteOne() {
        $(".number_min").text(0+'đ');
        $(".number_max").text(200000000+'đ');
        $(".min").val(0);
        $(".max").val(200000000);
        $(".btnOne").removeClass("active_filter");
        $(".close_one").css('display', 'none');
        $('.btn-filter-group1').css('display', 'none');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = $('input[name="check-one"]:checked').val();
        data['parameter_five'] = $('input[name="check-two"]:checked').val();
        data['parameter_two'] = $('input[name="check-three"]:checked').val();
        data['parameter_three'] = $('input[name="check-four"]:checked').val();
        data['parameter_four'] = $('input[name="check-five"]:checked').val();
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function deleteTwo() {
        $(".checkTwo").each(function () {
            $('input[name="check-one"]').prop("checked", false);
        });
        $(".btnTwo").removeClass("active_filter");
        $(".close_two").css('display', 'none');
        $('.btn-filter-group1').css('display', 'none');
        $('label.btn').removeClass('active_filter');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = null;
        data['parameter_five'] = $('input[name="check-two"]:checked').val();
        data['parameter_two'] = $('input[name="check-three"]:checked').val();
        data['parameter_three'] = $('input[name="check-four"]:checked').val();
        data['parameter_four'] = $('input[name="check-five"]:checked').val();
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function deleteThree() {
        $(".checkThree").each(function () {
            $('input[name="check-two"]').prop("checked", false);
        });
        $(".btnThree").removeClass("active_filter");
        $(".close_three").css('display', 'none');
        $('.btn-filter-group2').css('display', 'none');
        $('label.btn').removeClass('active_filter');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = $('input[name="check-one"]:checked').val();
        data['parameter_five'] = null;
        data['parameter_two'] = $('input[name="check-three"]:checked').val();
        data['parameter_three'] = $('input[name="check-four"]:checked').val();
        data['parameter_four'] = $('input[name="check-five"]:checked').val();
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function deleteFour() {
        $(".checkFour").each(function () {
            $('input[name="check-three"]').prop("checked", false);
        });
        $(".btnFour").removeClass("active_filter");
        $(".close_four").css('display', 'none');
        $('.btn-filter-group3').css('display', 'none');
        $('label.btn').removeClass('active_filter');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = $('input[name="check-one"]:checked').val();
        data['parameter_five'] = $('input[name="check-two"]:checked').val();
        data['parameter_two'] = null;
        data['parameter_three'] = $('input[name="check-four"]:checked').val();
        data['parameter_four'] = $('input[name="check-five"]:checked').val();
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function deleteFive() {
        $(".checkFive").each(function () {
            $('input[name="check-four"]').prop("checked", false);
        });
        $(".btnFive").removeClass("active_filter");
        $(".close_five").css('display', 'none');
        $('.btn-filter-group4').css('display', 'none');
        $('label.btn').removeClass('active_filter');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = $('input[name="check-one"]:checked').val();
        data['parameter_five'] = $('input[name="check-two"]:checked').val();
        data['parameter_two'] = $('input[name="check-three"]:checked').val();
        data['parameter_three'] = null;
        data['parameter_four'] = $('input[name="check-five"]:checked').val();
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function deleteSix() {
        $(".checkSix").each(function () {
            $('input[name="check-five"]').prop("checked", false);
        });
        $(".btnSix").removeClass("active_filter");
        $(".close_six").css('display', 'none');
        $('.btn-filter-group5').css('display', 'none');
        $('label.btn').removeClass('active_filter');
        data['sort'] = $('.active_filter').attr('data-value');
        data['parameter_one'] = $('input[name="check-one"]:checked').val();
        data['parameter_five'] = $('input[name="check-two"]:checked').val();
        data['parameter_two'] = $('input[name="check-three"]:checked').val();
        data['parameter_three'] = $('input[name="check-four"]:checked').val();
        data['parameter_four'] = null;
        data['min_price'] = $(".min").val();
        data['max_price'] = $(".max").val();
        data['type_product'] = $('input[name="type_product"]').val();
        data['name_cate'] = $('input[name="name_cate"]').val();
        data['slug_cate'] = $('input[name="slug_cate"]').val();
        data['page'] = null;
        filter(data, url);
    }

    function filter(data, url) {
        $.ajax({
            url: url,
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(".list-items").html(data.prop);
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
                }
            }
        })
    }

    $(document).on('click', '.content-paginate .btn-link-paginate', function (ev) {
        ev.preventDefault();
        let link = $(this).attr('href');
        let route = window.location.origin;
        let a = link.replace(route, route);
        let paginate = a.replace(route + '/bo-loc?page=', '');
        $('.loading-view').show();
        data['page'] = parseInt(paginate);
        $.ajax({
            url: url,
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(".list-items").html(data.prop);
                    $('.loading-view').hide();
                }
            }
        });
    });
});
