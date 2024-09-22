$(function (){
    $('.slide-banner-news').slick({
        infinite: true,
        autoplay: true,
        dots: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<div class="prev-arrow d-none"><div class="btn btn-prev"></div></div>',
        nextArrow: '<div class="next-arrow d-none"><div class="btn btn-next"></div></div>',
        centerMode: false,
    })
})
