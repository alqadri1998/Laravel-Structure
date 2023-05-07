$(document).ready(function () {
  $('.see-info-share').hide();
  $('.bars').click(function () {
    $('.see-info-share').toggle();
  })
  
  $('.latest-p-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,

    nextArrow: $('.next-latest-btn'),
    prevArrow: $('.prev-latest-btn'),
    arrows: true,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          dots: false,
          arrows: false
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          dots: false

        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false
        },

      }

    ]
  });



  $('.category').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: false,
    // centerMode: true,
    // variableWidth: true,
    autoplaySpeed: 2000,
    nextArrow: $('.next-c'),
    prevArrow: $('.prev-c'),
    dots: false,
    infinite: true,
    arrows: true,
    responsive: [
    //   breakpoint: 1600,
    //   settings: {
    //     slidesToShow: 6,
    //     slidesToScroll: 1,
    //     arrows:true
    //   }
    // },
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }

    ]

  });

  $('.slides').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    nextArrow: $('.next-partner'),
    prevArrow: $('.prev-partner'),
    // variableWidth: true,
    rows: 0,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          dots: false,
          arrows: false
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false
        }
      }

    ]

  });


  $('.top-rated').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    nextArrow: $('.prev-btn'),
    prevArrow: $('.next-btn'),
    // variableWidth: true,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          dots: false,
          arrows: false,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          dots: false,
          responsive: true
        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
        },

      }

    ]

  });

  $('.gallery-slider').slick({
    slidesToShow: 8,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    nextArrow: $('.next'),
    prevArrow: $('.prev'),
    // variableWidth: true,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 2,
          dots: false,
          arrows: false,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
        }
      }

    ]

  });
  $.ajax({
    url: 'https://api.instagram.com/v1/users/self/media/recent/?access_token=7388845306.1677ed0.7f0843aa1b3d47c4b4628bc5b075f384&count=8',
    success: function (result) {
      $.each(result.data, function (key, value) {
        $div_pt = $("<div class='pt-2'>" +
          "<a target='_blank' href='" + value['link'] + "'><div class='overlay-container'>" +
          "<div class='d-flex align-items-center'>" +
          "<img alt='image' class='d-block m-auto img-fluid' src=" + value['images']['standard_resolution']['url'] + ">" +
          "<div class='actual-overlay'><span><i class='fa fa-instagram middle-align text-white'></i></span></div>" +
          "</div>" +
          "</div></a>" +
          "</div>")
        $("#insta_images").append($div_pt);

      })
    }


  })



  $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    variableWidth: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: '.slider-for',
    dots: false,
    nextArrow: $('.next'),
    prevArrow: $('.prev'),
    centerMode: true,
    centerPadding: '10px',
    vertical: true,
    focusOnSelect: true,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          vertical: false,
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 3,
          vertical: false,
          slidesToScroll: 2
        }
      }
    ]
  });
  $(document).on("click", '#favorite', function () {
    let user = window.Laravel.user_id;
    let id = $(this).attr('data-id');
    if (user) {
      $.ajax({
        url: window.Laravel.baseUrl + 'favorites/' + id,
        success: function (data) {
          let fav = $("<i class='fa fa-heart secondary-color' id='un_favorite' data-id='" + id + "' ></i>")
          $("#favorite_product").empty();
          $("#favorite_product").append(fav);
          toastr.success('Product Added To Favorites');
            location.reload();


        },
        error: function (data) {
          window.location = window.Laravel.baseUrl + 'login'
        }
      });
    } else {
      window.location = window.Laravel.baseUrl + 'login'
    }


  });
  $(document).on('click', '#un_favorite', function () {
    let id = $(this).attr('data-id');
    $.ajax({
      url: window.Laravel.baseUrl +'un-favorites/' + id,
      success: function (data) {
        let fav = $("<i class='fa fa-heart-o' id='favorite' data-id='" + id + "' ></i>")
        $("#favorite_product").empty();
        $("#favorite_product").append(fav);
        toastr.success('Product Removed From Favorites');
        location.reload();
      },
      error: function (data) {
        toastr.error('something went wrong');

      }

    })

  });


});

