/*** Slick Sliders */


$('.multi-items-slider').slick({
    rows: 2,
    dots: true,
    arrows: false,
    infinite: true,
    // speed: 300,
    slidesToShow: 5,
    // autoplay: false,
    autoplay: true,
    slidesToScroll: 3,
    responsive: [{
        breakpoint: 991,
        settings: {
            rows: 2,
            slidesToShow: 3,
            slidesToScroll: 1,
        }
    }, {
        breakpoint: 425,

        settings: {
            rows: 2,
            slidesToShow: 2,
            slidesToScroll: 1,
        }

    }]
});

$('.branches-slider').slick({
    dots: false,
    arrows: true,
    infinite: true,
    // speed: 300,
    slidesToShow: 4,   
    autoplay: false,
    slidesToScroll: 1,
    nextArrow: '<div class="arrow-right arrows"><i class="fas fa-chevron-right"></i></i></div>',
    prevArrow: '<div class="arrow-left arrows"><i class="fas fa-chevron-left"></i></div>',
    responsive: [{
        breakpoint: 1080,
        settings: {            
            slidesToShow: 3,
            slidesToScroll: 1,
        }
    }, {
        breakpoint: 425,

        settings: {            
            slidesToShow: 1,
            slidesToScroll: 1,
        }

    }]
});