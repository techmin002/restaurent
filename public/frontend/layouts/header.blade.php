<html lang="en" dir="auto">
    <head>
    <script>

 document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".testimonialSwiper", {
            slidesPerView: 3,
            centeredSlides: true,
            spaceBetween: 2,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 2,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 2,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 2,
                }
            }
        });
    });


    var interfaceSwiperElement = document.querySelector('.mySwiper');
    if (interfaceSwiperElement) {
        console.log('Initializing Beautiful Interface Swiper...');
        
        var interfaceSwiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: { 
                    slidesPerView: 1,
                    spaceBetween: 10 
                },
                768: { 
                    slidesPerView: 2,
                    spaceBetween: 15 
                },
                1024: { 
                    slidesPerView: 3,
                    spaceBetween: 20 
                }
            }
        });
        
        console.log('Beautiful Interface Swiper initialized:', interfaceSwiper);
    } else {
        console.error('Beautiful Interface Swiper element (.mySwiper) not found!');
    }
});


</script>




    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="tFVTvgPjOOo4WKIQzEZ964vPvdgjmlCyrrBAT1kj">
    <title>
                        Home
 |
Bg Restro
    </title>
    <!-- <link rel="shortcut icon" type="image/x-icon" href="images/1763778565-460.png"> -->
<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/swiper-bundle.min.css')}}">
<script src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('frontend/css/all.min.css')}}">
<!-- Slick Slider -->
<link rel="stylesheet" href="{{asset('frontend/css/slick.css')}}">

<link rel="stylesheet" href="{{asset('frontend/css/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/slick-theme.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/payments.css')}}">

<!-- Toaster -->
<link rel="stylesheet" href="{{asset('frontend/css/toastr.min.css')}}">


<link rel="stylesheet" href="{{asset('frontend/css/aos.css')}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">



