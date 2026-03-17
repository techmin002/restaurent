      @extends('frontend.layouts.master')
      @section('content')



        <section class="home-banner-section">
        <div class="container">

            <div class="row align-items-center pb-5 py-lg-5">
                <div class="col-lg-6 order-2 order-lg-1 mt-lg-0 hero-content">
                    <div data-aos="fade-right" class="banner-content">
                        <h1 data-aos="fade-up" data-aos-delay="100">
                           <span> {{$profile->company_name}}</span>
                        </h1>

                        <p data-aos="fade-up" data-aos-delay="500">
{{ $profile->introduction }}                        </p>

                        <div class="demo-btn-group mb-3" data-aos="fade-up" data-aos-delay="700">
                            <a href="demo.html" class="try-demo-button custom-primary-btn">
                                Try Demo
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 9.99996C12.5 10.4602 12.1269 10.8333 11.6667 10.8333H3.33333C2.87308 10.8333 2.5 10.4602 2.5 9.99996C2.5 9.53971 2.87308 9.16663 3.33333 9.16663H11.6667C12.1269 9.16663 12.5 9.53971 12.5 9.99996Z" fill="#fff"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2734 5.93173C11.0024 6.07674 10.8333 6.35913 10.8333 6.66647V13.3332C10.8333 13.6404 11.0024 13.9228 11.2733 14.0678C11.5443 14.2128 11.8731 14.197 12.1288 14.0265L17.1288 10.6935C17.3607 10.539 17.4999 10.2787 17.4999 10.0002C17.5 9.7215 17.3607 9.46133 17.1289 9.30675L12.1289 5.97311C11.8732 5.80262 11.5444 5.78672 11.2734 5.93173Z" fill="#fff"></path>
                                </svg>
                            </a>


                            <a class="d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#watch-video-modal" href="#">
                                <div class="video-button">
                                <span class="pulse-ring"></span>
                                <span class="pulse-ring"></span>
                                <span class="pulse-ring"></span>

                                <span class="play-icon">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.58203 4.58167C4.58203 3.7905 5.45728 3.31266 6.12279 3.74049L16.1069 10.1588C16.7192 10.5525 16.7192 11.4475 16.1069 11.8412L6.12279 18.2595C5.45728 18.6873 4.58203 18.2095 4.58203 17.4183V4.58167Z" fill="white"></path>
                                    </svg>
                                </span>

                                </div>
                                <p class="hero-watch m-0">watch video</p>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 order-1 order-lg-2 p-0">
                    <div class="banner-img text-center  move-image">
                        <div data-aos="fade-up" data-aos-delay="100" class="position-relative">
                            <img src="frontend/images/hero-bg-shape.svg" alt="banner-img" class="hero-bg-shape"> php ar
                            <img src="frontend/images/1761790782-172.png" alt="banner-img" class="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal modal-custom-design" id="watch-video-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="400px" src="https://www.youtube.com/embed/EEryt_-M-6Q?si=8iBjlbj8ip6BrqPm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>



  <section class="service-section">
    <div class="container">
        <div data-aos="fade-up" class="section-title text-center">
            <h2>Our Amazing <span class="highlight-title">Features</span></h2>
        </div>

        <div class="row">
            @foreach($features as $feature)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="text-center service-card"
                         style="background: #ECEFFF">
                        <div class="image">
                            <img src="{{ asset('upload/images/features/'.$feature->image) }}"
                                 alt="{{ $feature->title }}" class="img-fluid">
                        </div>
                        <div class="service-content mt-2">
                            <h6>{{ $feature->title }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>



    <section>
        <div class="container">
            <div class="section-title text-center">
                <h2 data-aos="fade-up" data-aos-delay="100">Beautiful Interface Of Our <span class="highlight-title">Bg Restro Restaurant</span> </h2>
                <p data-aos="fade-up" data-aos-delay="300" class="max-w-600 mx-auto section-description">
                    The world's largest creative network for showcasing and discovering creative work. Our best search experience is on our mobile app.
                </p>
            </div>
                <div class="swiper mySwiper app-slider-section">
                    <div class="swiper-wrapper">
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306220-873.svg" alt="phone">
                            </div>
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306232-449.svg" alt="phone">
                            </div>
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306243-80.svg" alt="phone">
                            </div>
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306264-725.svg" alt="phone">
                            </div>
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306253-985.svg" alt="phone">
                            </div>
                                                    <div class="swiper-slide d-flex align-items-center justify-content-center p-2">
                                <img src="frontend/images/1754306278-254.svg" alt="phone">
                            </div>
                                            </div>

                    <div class="swiper-button-prev custom-nav">
                      <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.4979 7.74975C19.4979 8.16375 19.1619 8.49975 18.7479 8.49975H2.559L8.2789 14.2198C8.5719 14.5128 8.5719 14.9877 8.2789 15.2807C8.1329 15.4267 7.9409 15.5008 7.7489 15.5008C7.5569 15.5008 7.3649 15.4277 7.2189 15.2807L0.2189 8.28075C0.1499 8.21175 0.095 8.12885 0.057 8.03685C-0.019 7.85385 -0.019 7.64685 0.057 7.46385C0.095 7.37185 0.1499 7.28875 0.2189 7.21975L7.2189 0.21975C7.5119 -0.07325 7.9869 -0.07325 8.2799 0.21975C8.5729 0.51275 8.5729 0.987751 8.2799 1.28075L2.5599 7.00075H18.7479C19.1619 6.99975 19.4979 7.33575 19.4979 7.74975Z" fill="#979797"></path>
                        </svg>
                    </div>

                    <div class="swiper-button-next custom-nav">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.25013 7.99978C0.25013 8.41378 0.58613 8.74978 1.00013 8.74978H17.1891L11.4691 14.4698C11.1761 14.7628 11.1761 15.2378 11.4691 15.5308C11.6151 15.6768 11.8072 15.7508 11.9992 15.7508C12.1912 15.7508 12.3832 15.6778 12.5292 15.5308L19.5292 8.53079C19.5982 8.46179 19.653 8.37889 19.691 8.28689C19.767 8.10389 19.767 7.89689 19.691 7.71389C19.653 7.62189 19.5982 7.53875 19.5292 7.46975L12.5292 0.46975C12.2362 0.17675 11.7611 0.17675 11.4681 0.46975C11.1751 0.76275 11.1751 1.23779 11.4681 1.53079L17.1881 7.25076H1.00013C0.58613 7.24976 0.25013 7.58578 0.25013 7.99978Z" fill="#979797"></path>
                        </svg>
                    </div>
                </div>
        </div>
    </section>


    <div class="get-app-container">
        <div class="section-title m-0 container">
            <h2 data-aos="fade-up" data-aos-delay="100"> Get The <span class="highlight-title">Bg Restro</span> Restaurant Mobile App </h2>
            <p data-aos="fade-up" data-aos-delay="300"> This platform you can access your account anywhere, anytime for manage your business with <span>BgRestro</span> restaurnat app </p>
        <div data-aos="fade-up" data-aos-delay="500" class="google-app-store">
            <a href="https://www.apple.com/app-store/">
                <img class="" src="frontend/images/1751271174-498.png" alt="" srcset="">
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.acnoo.fastfood&hl=en">
                <img class="" src="frontend/images/1751271174-238.png" alt="" srcset="">
            </a>
        </div>
        </div>
    </div>


    <section class="watch-demo-section watch-demo-two bg-FFFFFF">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-5 m-0">
                    <div data-aos="fade-right" data-aos-delay="100" class="video-wrapper ">
                        <img src="frontend/images/1753261498-201.svg" alt="watch">
                        <a href="#" class="play-btn" data-bs-toggle="modal" data-bs-target="#play-video-modal">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                       <a type="button" data-bs-toggle="modal" data-bs-target="#play-video-modal" class="video-button position-absolute top-50 start-50 translate-middle">
                                <span class="pulse-ring-2"></span>
                                <span class="pulse-ring-2"></span>
                                <span class="pulse-ring-2"></span>
                                <span class="play-icon-2">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.58203 4.58167C4.58203 3.7905 5.45728 3.31266 6.12279 3.74049L16.1069 10.1588C16.7192 10.5525 16.7192 11.4475 16.1069 11.8412L6.12279 18.2595C5.45728 18.6873 4.58203 18.2095 4.58203 17.4183V4.58167Z" fill="white"></path>
                                    </svg>
                                </span>
                        </a>
                    </div>
                </div>
                <div class="section-title m-0 text-start col-lg-7 watch-video-content">
                    <h2 data-aos="fade-up" data-aos-delay="100">
                        How to Use
                        <span class="highlight-title">Bg Restro Restaurant</span>
                        With Flutter app, Admin Panel.
                    </h2>
                    <p data-aos="fade-up" data-aos-delay="300" class="section-description mt-2">
                        Can help viewers understand the functionality and features of your app. Here’s a general script outline that you can see video
                    </p>
                    <a data-aos="fade-up" data-aos-delay="500" href="https://www.youtube.com/embed/EEryt_-M-6Q?si=8iBjlbj8ip6BrqPm" class="custom-btn custom-primary-btn mt-4" data-bs-toggle="modal" data-bs-target="#play-video-modal">
                        Watch Video
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="white"></path>
                            <path d="M7.125 8.39985V9.60015C7.125 10.7396 7.125 11.3093 7.46682 11.5397C7.80862 11.7699 8.2761 11.5151 9.21112 11.0056L10.3123 10.4054C11.4374 9.79215 12 9.48555 12 9C12 8.51445 11.4374 8.20785 10.3123 7.59465L9.21112 6.99446C8.2761 6.48488 7.80862 6.23009 7.46682 6.46037C7.125 6.69065 7.125 7.26038 7.125 8.39985Z" fill="white"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal modal-custom-design" id="play-video-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="400px" src="https://www.youtube.com/embed/EEryt_-M-6Q?si=8iBjlbj8ip6BrqPm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen="">
                </iframe>
            </div>
        </div>
    </div>
</div>


    <section class="pricing-plan-section plans-list">
    <div class="container">
        <div class="section-title text-center">
            <h2 data-aos="fade-up" data-aos-delay="100">Our <span class="highlight-title">Pricing</span> Plans</h2>
            <p data-aos="fade-up" data-aos-delay="300" class="section-description">
                We Offer flexible pricing plans to suit the diverse needs of our clients
            </p>
            <div class="d-flex align-items-center justify-content-center gap-4">
                <div class="w-100 d-flex flex-column align-items-center">

                    <div class="tab-content w-100">
                        <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel" aria-labelledby="nav-monthly-tab">
                            <div class="plans-card">
                                                                    <div class=" mt-3">
                                        <div class="card">
                                            <div class="card-header pricing-top-card border-0 font-size-update">
                                                 <img src="frontend/images/1754302744-167.svg" alt="">
                                                <div class="">
                                                    <p>Free</p>
                                                    <h4>
                                                                                                                                                                                    Free
                                                                                                                                                                            <span class="price-span">/5 Days</span>
                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="card-body px-4 text-start">
                                                <ul>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M18.3337 9.99935C18.3337 5.39697 14.6027 1.66602 10.0003 1.66602C5.39795 1.66602 1.66699 5.39697 1.66699 9.99935C1.66699 14.6017 5.39795 18.3327 10.0003 18.3327C14.6027 18.3327 18.3337 14.6017 18.3337 9.99935Z" fill="#FF3B30"></path>
                                                                <path d="M12.4995 12.5L7.5 7.5M7.50053 12.5L12.5 7.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg>
                                                                </div>
                                                            Free Lifetime Update
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Premium Customer Support
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Android & iOS App Support
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M18.3337 9.99935C18.3337 5.39697 14.6027 1.66602 10.0003 1.66602C5.39795 1.66602 1.66699 5.39697 1.66699 9.99935C1.66699 14.6017 5.39795 18.3327 10.0003 18.3327C14.6027 18.3327 18.3337 14.6017 18.3337 9.99935Z" fill="#FF3B30"></path>
                                                                <path d="M12.4995 12.5L7.5 7.5M7.50053 12.5L12.5 7.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg>
                                                                </div>
                                                            Custom Invoice Branding
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Easily Manage your Business
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M18.3337 9.99935C18.3337 5.39697 14.6027 1.66602 10.0003 1.66602C5.39795 1.66602 1.66699 5.39697 1.66699 9.99935C1.66699 14.6017 5.39795 18.3327 10.0003 18.3327C14.6027 18.3327 18.3337 14.6017 18.3337 9.99935Z" fill="#FF3B30"></path>
                                                                <path d="M12.4995 12.5L7.5 7.5M7.50053 12.5L12.5 7.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg>
                                                                </div>
                                                            Unlimited Usage
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M18.3337 9.99935C18.3337 5.39697 14.6027 1.66602 10.0003 1.66602C5.39795 1.66602 1.66699 5.39697 1.66699 9.99935C1.66699 14.6017 5.39795 18.3327 10.0003 18.3327C14.6027 18.3327 18.3337 14.6017 18.3337 9.99935Z" fill="#FF3B30"></path>
                                                                <path d="M12.4995 12.5L7.5 7.5M7.50053 12.5L12.5 7.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg>
                                                                </div>
                                                            Free Data Backup
                                                        </li>
                                                                                                    </ul>
                                                <a class="btn subscribe-plan d-block mt-4 mb-2" data-bs-toggle="modal" data-bs-target="#registration-modal">
                                                    Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                                                    <div class=" mt-3">
                                        <div class="card">
                                            <div class="card-header pricing-top-card border-0 font-size-update">
                                                 <img src="frontend/images/1754302783-482.svg" alt="">
                                                <div class="">
                                                    <p>Premium</p>
                                                    <h4>
                                                                                                                                                                                    ₹2,999.00
                                                                                                                                                                            <span class="price-span">/365 Days</span>
                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="card-body px-4 text-start">
                                                <ul>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Free Lifetime Update
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Premium Customer Support
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Android & iOS App Support
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Custom Invoice Branding
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Easily Manage your Business
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Unlimited Usage
                                                        </li>
                                                                                                            <li class="d-flex align-items-center gap-2">
                                                            <div class="pb-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                                </svg></div>
                                                            Free Data Backup
                                                        </li>
                                                                                                    </ul>
                                                <a class="btn subscribe-plan d-block mt-4 mb-2" data-bs-toggle="modal" data-bs-target="#registration-modal">
                                                    Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <div class="faq-main-container">
        <div class="container">
            <div class="section-title ">
                <h2 data-aos="fade-up" data-aos-delay="100"> Frequently asked questions </h2>
                <p data-aos="fade-up" data-aos-delay="300" class="mt-2">Everything you need to know about the product and billing.</p>
            </div>
            <div class="faq-section-container">
                <div class="">
                    <div class="faq-get-in-content">
                        <h4>Still have questions?</h4>
                        <p>Can’t find the answer you’re looking for? Please chat to our friendly team.</p>
                        <a href="https://restaurantapp.acnoo.com/contact-us" class="get-in-touch-btn">
                            Get in Touch
                        </a>
                    </div>
                </div>
                <div class="">
                    <div class="custom-accordion">
                                                    <div class="custom-accordion-item active">
                                <div class="custom-accordion-header">
                                    Is there a free trial available?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free, personalized 30-minute onboarding call to get you up and running as soon as possible.
                                </div>
                            </div>
                                                    <div class="custom-accordion-item ">
                                <div class="custom-accordion-header">
                                    Can I change my plan later?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    Yes, you can upgrade or downgrade anytime from your account settings.
                                </div>
                            </div>
                                                    <div class="custom-accordion-item ">
                                <div class="custom-accordion-header">
                                    What is your cancellation policy?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    You can cancel anytime. Your subscription will remain active until the end of the billing period.
                                </div>
                            </div>
                                                    <div class="custom-accordion-item ">
                                <div class="custom-accordion-header">
                                    Can other info be added to an invoice?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    Yes, you can add custom billing details like your company name, address, and VAT number.
                                </div>
                            </div>
                                                    <div class="custom-accordion-item ">
                                <div class="custom-accordion-header">
                                    How does billing work?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    Billing is done on a monthly or yearly basis depending on your subscription plan.
                                </div>
                            </div>
                                                    <div class="custom-accordion-item ">
                                <div class="custom-accordion-header">
                                    How do I change my account email?
                                    <span class="custom-accordion-icon"></span>
                                </div>
                                <div class="custom-accordion-content">
                                    You can change your email address from your profile settings at any time.
                                </div>
                            </div>
                                            </div>
                </div>
            </div>
        </div>
    </div>



    <section class="customer-section">
        <div class="container mb-4">
            <div class="section-title text-center">
                <h2 data-aos="fade-up" data-aos-delay="100">What Our <span class="highlight-title">Customer Say</span> </h2>
            </div>

            <div class="customer-slider-section">
              <div class="swiper testimonialSwiper">
                    <div class="swiper-wrapper">
                                                    <div class="swiper-slide" data-aos="zoom-in" data-aos-delay="0">
                                <div class="customer-card">
                                    <div class="w-100 pt-3 d-flex flex-column">
                                        <ul class="d-flex align-items-center gap-2">
                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                    </ul>
                                    </div>
                                    <p>Great work! Delivered everything on time and exactly as expected.</p>

                                    <div>
                                        <img class="serperate" src="frontend/images/seperate.svg" alt="">
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <img class="profile-img" src="frontend/images/1750825205-820.jpeg" alt="">
                                        <div>
                                            <h5 class="m-0">Carol Cash</h5>
                                            <small>Bg Restro</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                    <div class="swiper-slide" data-aos="zoom-in" data-aos-delay="100">
                                <div class="customer-card">
                                    <div class="w-100 pt-3 d-flex flex-column">
                                        <ul class="d-flex align-items-center gap-2">
                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="far fa-star text-muted"></i>
                                                                                                                                    </ul>
                                    </div>
                                    <p>Very professional and communicates clearly. Highly recommended!</p>

                                    <div>
                                        <img class="serperate" src="frontend/images/seperate.svg" alt="">
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <img class="profile-img" src="frontend/images/1750825268-323.jpeg" alt="">
                                        <div>
                                            <h5 class="m-0">Stacey Duran</h5>
                                            <small>Fiverr</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                    <div class="swiper-slide" data-aos="zoom-in" data-aos-delay="200">
                                <div class="customer-card">
                                    <div class="w-100 pt-3 d-flex flex-column">
                                        <ul class="d-flex align-items-center gap-2">
                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="far fa-star text-muted"></i>
                                                                                                                                                                                                <i class="far fa-star text-muted"></i>
                                                                                                                                    </ul>
                                    </div>
                                    <p>Top-notch developer with strong problem-solving skills.</p>

                                    <div>
                                        <img class="serperate" src="frontend/images/seperate.svg" alt="">
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <img class="profile-img" src="frontend/images/1750825278-278.jpeg" alt="">
                                        <div>
                                            <h5 class="m-0">Daniel Martin</h5>
                                            <small>Toptal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                    <div class="swiper-slide" data-aos="zoom-in" data-aos-delay="300">
                                <div class="customer-card">
                                    <div class="w-100 pt-3 d-flex flex-column">
                                        <ul class="d-flex align-items-center gap-2">
                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                                                                    </ul>
                                    </div>
                                    <p>The project was completed faster than expected. Loved the outcome!</p>

                                    <div>
                                        <img class="serperate" src="frontend/images/seperate.svg" alt="">
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <img class="profile-img" src="frontend/images/1750825291-653.jpeg" alt="">
                                        <div>
                                            <h5 class="m-0">Emily Davis</h5>
                                            <small>Youtube</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                            </div>
                </div>
            </div>
        </div>
    </section>



    <section class="blogs-section ">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between flex-wrap">
                <h2 data-aos="fade-up" data-aos-delay="100">Our Latest <span class="highlight-title">Blog Posts</span> </h2>
                <a data-aos="fade-up" data-aos-delay="300" href="{{route("frontend.blogss")}}" class="custom-btn custom-primary-btn">
                    View All
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 9.99996C12.5 10.4602 12.1269 10.8333 11.6667 10.8333H3.33333C2.87308 10.8333 2.5 10.4602 2.5 9.99996C2.5 9.53971 2.87308 9.16663 3.33333 9.16663H11.6667C12.1269 9.16663 12.5 9.53971 12.5 9.99996Z" fill="white"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2734 5.93173C11.0024 6.07674 10.8333 6.35913 10.8333 6.66647V13.3332C10.8333 13.6404 11.0024 13.9228 11.2733 14.0678C11.5443 14.2128 11.8731 14.197 12.1288 14.0265L17.1288 10.6935C17.3607 10.539 17.4999 10.2787 17.4999 10.0002C17.5 9.7215 17.3607 9.46133 17.1289 9.30675L12.1289 5.97311C11.8732 5.80262 11.5444 5.78672 11.2734 5.93173Z" fill="white"></path>
                    </svg>
                </a>
            </div>
        </div>
        <section class="blog-section p-0">
    <div class="container ">
        <div class="row">
            <div class="col-xl-8">
          <div class="row" id="blogs-container">
                            <div class="col-lg-6 pb-4" data-aos="zoom-in" data-aos-delay="0">
                    <div class="blog-shadow rounded-16">
                        <div class="text-center blog-image mb-3">
                            <img src="frontend/images/1750759276-316.png" alt="product-image" class="landing-blog-img">
                        </div>
                        <div class="p-3 pt-0">
                            <div class="d-flex align-items-center mb-2">
                                <img src="assets/web/frontend/images/icons/clock.svg" alt="">
                                <p class="ms-1 mb-0">27 Nov, 2025</p>
                            </div>
                            <h6 class="h6-line-clamp">How to Streamline Billing in Your Restaurant</h6>
                            <p>
                                For restaurant owners, efficient billing is paramount to success. This topic explores practical strategies to optimize t...
                                                            </p>
                            <a href="https://restaurantapp.acnoo.com/blogs/how-to-streamline-billing-in-your-restaurant" class="custom-clr-primary">
                                Read More
                                <span class="font-monospace">></span>
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="col-lg-6 pb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="blog-shadow rounded-16">
                        <div class="text-center blog-image mb-3">
                            <img src="frontend/images/1750759354-527.png" alt="product-image" class="landing-blog-img">
                        </div>
                        <div class="p-3 pt-0">
                            <div class="d-flex align-items-center mb-2">
                                <img src="assets/web/frontend/images/icons/clock.svg" alt="">
                                <p class="ms-1 mb-0">24 Jun, 2025</p>
                            </div>
                            <h6 class="h6-line-clamp">How We Craft the Perfect Burger (Behind the Scenes)</h6>
                            <p>
                                Promises an exclusive look into the meticulous process of creating an exceptional burger. It suggests that readers will...
                                                            </p>
                            <a href="https://restaurantapp.acnoo.com/blogs/dfgdghow-we-craft-the-perfect-burger-behind-the-scenes" class="custom-clr-primary">
                                Read More
                                <span class="font-monospace">></span>
                            </a>
                        </div>
                    </div>
                </div>
                    </div>

            </div>
                <div class="col-xl-4">
                                    <div class="blog-shadow rounded-16 mb-4" data-aos="zoom-in" data-aos-delay="0">
                        <div class="blog-sm-main-container">
                            <div class="blog-sm-container">
                                <img src="frontend/images/1750759276-316.png" class="blog-sm-img" alt="...">
                            </div>
                            <div class="mx-3">
                                <div class="d-flex align-items-center">
                                    <img src="assets/web/frontend/images/icons/clock.svg" alt="">
                                    <p class="ms-1 mb-0">27 Nov, 2025</p>
                                </div>
                                <div class="my-2">
                                    <p class="p-2nd-line-clamp mb-1">
                                        <strong>How to Streamline Billing in Your Restaurant</strong>
                                    </p>
                                </div>
                                <a href="https://restaurantapp.acnoo.com/blogs/how-to-streamline-billing-in-your-restaurant" class="custom-clr-primary">
                                    Read More
                                    <span class="font-monospace">></span>
                                </a>
                            </div>
                        </div>
                    </div>
                                    <div class="blog-shadow rounded-16 mb-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="blog-sm-main-container">
                            <div class="blog-sm-container">
                                <img src="frontend/images/1750759354-527.png" class="blog-sm-img" alt="...">
                            </div>
                            <div class="mx-3">
                                <div class="d-flex align-items-center">
                                    <img src="assets/web/frontend/images/icons/clock.svg" alt="">
                                    <p class="ms-1 mb-0">24 Jun, 2025</p>
                                </div>
                                <div class="my-2">
                                    <p class="p-2nd-line-clamp mb-1">
                                        <strong>How We Craft the Perfect Burger (Behind the Scenes)</strong>
                                    </p>
                                </div>
                                <a href="https://restaurantapp.acnoo.com/blogs/dfgdghow-we-craft-the-perfect-burger-behind-the-scenes" class="custom-clr-primary">
                                    Read More
                                    <span class="font-monospace">></span>
                                </a>
                            </div>
                        </div>
                    </div>
                                    <div class="blog-shadow rounded-16 mb-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="blog-sm-main-container">
                            <div class="blog-sm-container">
                                <img src="frontend/images/1750759390-584.png" class="blog-sm-img" alt="...">
                            </div>
                            <div class="mx-3">
                                <div class="d-flex align-items-center">
                                    <img src="assets/web/frontend/images/icons/clock.svg" alt="">
                                    <p class="ms-1 mb-0">24 Jun, 2025</p>
                                </div>
                                <div class="my-2">
                                    <p class="p-2nd-line-clamp mb-1">
                                        <strong>Top 5 Most Loved Items on Our Menu</strong>
                                    </p>
                                </div>
                                <a href="https://restaurantapp.acnoo.com/blogs/top-5-most-loved-items-on-our-menu" class="custom-clr-primary">
                                    Read More
                                    <span class="font-monospace">></span>
                                </a>
                            </div>
                        </div>
                    </div>
                            </div>

        </div>
    </div>
</section>
    </section>

    <div class="modal fade" id="registration-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Create A <span id="subscription_name"> Free</span>
                    Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form id="registration-form" action="https://restaurantapp.acnoo.com/register" method="post" enctype="multipart/form-data" class="add-brand-form pt-0 sign_up_form">
                        <input type="hidden" name="_token" value="tFVTvgPjOOo4WKIQzEZ964vPvdgjmlCyrrBAT1kj" autocomplete="off">                        <div class="row">
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Company/Business Name</label>
                                <input type="text" name="companyName" placeholder="Enter business/store Name" class="form-control" required="">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Business Category</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="business_category_id" class="form-control form-selected business_category" required="">
                                                                                    <option value="9">Moiz Samo</option>
                                                                                    <option value="8">Second Class</option>
                                                                                    <option value="7">First Class Restaurant</option>
                                                                                    <option value="2">Desert Item</option>
                                                                                    <option value="3">Burger</option>
                                                                                    <option value="4">Pizza</option>
                                                                                    <option value="5">Fast Food</option>
                                                                                    <option value="6">Five Star</option>
                                                                            </select>
                                    <span></span>
                                </div>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Phone</label>
                                <input type="number" name="phoneNumber" placeholder="Enter Phone Number" class="form-control" required="">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Email Address</label>
                                <input type="email" name="email" placeholder="Enter Email Address" class="form-control" required="">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Password</label>
                                <input type="password" name="password" placeholder="Enter Password" class="form-control" required="">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">Company Address</label>
                                <input type="text" name="address" placeholder="Enter Company Address" class="form-control">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="custom-top-label">Opening Balance</label>
                                <input type="number" name="shopOpeningBalance" placeholder="Enter Opening Balance" class="form-control">
                            </div>
                        </div>

                        <div class="offcanvas-footer mt-3 d-flex justify-content-center gap-2">
                            <button type="button" data-bs-dismiss="modal" class="cancel-btn " aria-label="Close">
                                Close
                            </button>
                            <button class="submit-btn" type="submit">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Verify Modal Start -->
<div class="modal fade" id="verifymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verify-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body verify-modal-body  text-center">

                <h4 class="mb-0 verification-title">Email Verification</h4>
                <p class="des p-8-0 pb-3">we sent an OTP in your email address <br>
                    <span id="dynamicEmail"></span>
                </p>
                <form action="https://restaurantapp.acnoo.com/otp-submit" method="post" class="verify_form">
                    <input type="hidden" name="_token" value="tFVTvgPjOOo4WKIQzEZ964vPvdgjmlCyrrBAT1kj" autocomplete="off">                    <div class="code-input pin-container">
                        <input class="pin-input otp-input" id="pin-1" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-2" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-3" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-4" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-5" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-6" type="number" name="otp[]" maxlength="1">
                    </div>

                    <p class="des p-24-0 pt-2">
                        Code send in <span id="countdown" class="countdown"></span>
                        <span class="reset text-primary cursor-pointer" id="otp-resend" data-route="https://restaurantapp.acnoo.com/otp-resend">Resend code</span>
                    </p>
                    <button class="verify-btn btn submit-btn ps-custom-btn mt-2">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Verify Modal end -->

<!-- success Modal Start -->
<div class="modal fade" id="successmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content success-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body success-modal-body text-center">
                <div>
                    <img src="frontend/images/success-icon.svg" alt="success">
                    <h4>Successfully!</h4>
                    <p class="mb-3">Congratulations, Your account has been <br> successfully created</p>
                    <a href="Restaurant App" target="_blank" class="download-btn mb-2">Download Apk </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--success Modal end -->

@endsection
