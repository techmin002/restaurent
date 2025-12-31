
    <footer class="footer-section py-3">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 col-lg-5">
                <a href="#">
                    <img src="{{ asset('upload/images/settings/' . $profile->footer_logo) }}" 
     alt="Footer Logo" 
     class="footer-logo">
                </a>
                <p class="mt-3 footer-details">
                 Email: {{$profile->company_email}} <br>
                 Phone: {{$profile->company_phone}}
                </p>
                <ul class="social-link">
                                            <li>
                            <a href="{{$profile->twitter}}" target="_blank">
                                <img src="frontend/images/1753250604_68807b2cc7de4.svg" alt="icon">
                            </a>
                        </li>
                                            <li>
                            <a href="{{$profile->instagram}}" target="_blank">
                                <img src="frontend/images/1753250604_68807b2cc8036.svg" alt="icon">
                            </a>
                        </li>
                                            <li>
                            <a href="{{$profile->facebook}}" target="_blank">
                                <img src="frontend/images/1753250604_68807b2cc81fc.svg" alt="icon">
                            </a>
                        </li>
                                            <li>
                            <a href="{{$profile->youtube}}" target="_blank">
                                <img src="frontend/images/1753250604_68807b2cc83a6.svg" alt="icon">
                            </a>
                        </li>
                                    </ul>

            </div>
            <div class="col-md-6 col-lg-4">
                <h6 class="mb-4 mt-4 mt-md-0 text-white footer-title">Our App Features</h6>
                <ul class="d-flex gap-60">
                    <div class="first-list d-flex flex-column gap-3">
                        <li>
                            <a href="#" target="_blank">Sales</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Parties</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Purchase</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Products</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Due List</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Income</a>
                        </li>
                    </div>

                    <div class="second-list d-flex flex-column gap-3">
                        <li>
                            <a href="#" target="_blank">Expense</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Stock</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Loss/Profit</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Report</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">47+ Languages</a>
                        </li>
                        <li>
                            <a href="#" target="_blank">Dashboard</a>
                        </li>

                    </div>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h6 class="mb-4 text-white footer-title">Quick Links</h6>
                <ul class="d-flex flex-column gap-3">
                    <li>
                        <a href="{{route('frontend.about')}}" target="_self">About us</a>
                    </li>
                    <li>
                        <a href="{{route('frontend.contact')}}" target="_self">Contact Us</a>
                    </li>
                    <li>
                        <a href="{{route('frontend.terms')}}" target="_blank">Terms And Conditions</a>
                    </li>
                    <li>
                        <a href="{{route('frontend.privacy')}}" target="_blank">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{route('frontend.plan')}}" target="_blank">Pricing</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="custom-clr-white">
        <div class="text-center">
            <p class="text-white mb-0">{{ $profile->footer_text }}</p>
        </div>
    </div>
</footer>

    <input type="hidden" id="payment_success" value="">
<script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('frontend/js/lity.js')}}"></script>
<script src="{{asset('frontend/js/slick.min.js')}}"></script>
<script src="{{asset('frontend/js/type.js')}}"></script>
<script src="{{asset('frontend/js/aos.js')}}"></script>
<script src="{{asset('frontend/js/notification.js')}}"></script>
<script src="{{asset('frontend/js/validation-setup.js')}}"></script>
<script src="{{asset('frontend/js/toastr.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-confirm.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('frontend/js/form.js')}}"></script>
<script src="{{asset('frontend/js/custom-ajax.js')}}"></script>
<script src="{{asset('frontend/js/custom.js')}}"></script>
<script src="{{asset('frontend/js/auth.js')}}"></script>

//
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    window.addEventListener("scroll", function () {
        const header = document.querySelector(".header-section");
        
        if (window.scrollY > 50) {
            header.classList.remove("home-header");
        } else {
            header.classList.add("home-header");
        }
    });
</script>





    <script>
        AOS.init({
            once: false,
            duration: 800,
        });
    </script>
<script>
    var swiper = new Swiper(".interfaceSwiper", {
        slidesPerView: 3, // Show 3 slides at once
        spaceBetween: 20,
        centeredSlides: true, // Center the active slide
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            320: { 
                slidesPerView: 1,
                centeredSlides: false 
            },
            640: { 
                slidesPerView: 2,
                centeredSlides: false 
            },
            768: { 
                slidesPerView: 3,
                centeredSlides: true 
            },
            1024: { 
                slidesPerView: 3,
                centeredSlides: true 
            }
        }
    });
</script>


</body></html>