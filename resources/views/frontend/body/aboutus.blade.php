      @extends('frontend.layouts.master')
      @section('content')
     <section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                Home <span class="font-monospace">></span> About Us
            </p>
        </div>
    </section>

    

    <section class="about-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-6 align-self-center">
                    <div>
                        <h6>
                            <span class="custom-clr-primary">About us</span>
                        </h6>
                        <h2 class="mb-3">Simplifying Billing, Empowering <span class="highlight-title">Business</span></h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum ived not only five centuries
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="w-90 position-relative ms-auto">
                        <img src="frontend/images/1753252412-660.svg" alt="image" class="about-img">
                    </div>
                </div>
            </div>
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
            </p>
            <ul>
                                    <li>Qhen an unknown printer took a galley of type.</li>
                                    <li>It was popularised in the 1960s with the release.</li>
                                    <li>Aldus PageMaker including versions.</li>
                            </ul>
        </div>
    </section>

    
   <section class="service-section">
        <div class="container content-wrapper">
            <div data-aos="fade-up" class="section-title text-center">
                <h2>Our Amazing <span class="highlight-title">Features</span></h2>
            </div>
            <div class="row">
                @foreach ($features as $feature)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="text-center service-card" style="background: #ECEFFF">
                            <div class="image">
                                <img src="{{ asset('upload/images/features/' . $feature->image) }}"
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

    
   <section class="pricing-plan-section plans-list">
    <div class="container">
        <div class="section-title text-center">
            <h2 data-aos="fade-up" data-aos-delay="100">Our <span class="highlight-title">Pricing</span> Plans</h2>
            <p data-aos="fade-up" data-aos-delay="300" class="section-description">
                We Offer flexible pricing plans to suit the diverse needs of our clients
            </p>
        </div>

        <div class="w-100 d-flex flex-column align-items-center">
            <div class="tab-content w-100">
                <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel" aria-labelledby="nav-monthly-tab">
                    <div class="plans-card">
                        @foreach ($plans as $value)
                        <div class="mt-3">
                            <div class="card">
                                <div class="card-header pricing-top-card border-0 font-size-update">
                                    <img src="{{ asset('upload/images/plans/' . $value->image) }}" 
                                         class="img-fluid mb-2" 
                                         style="height: 64px; width: 64px; object-fit: contain;" 
                                         alt="Plan Image">
                                    <div class="">
    <p>{{ $value->title }}</p>
    <h4>
        @if($value->bigtitle == 'Free')
            Free
        @else
            ₹{{ number_format((float)$value->bigtitle, 2) }}
        @endif
        <span class="price-span">/{{ $value->days }} days</span>
    </h4>
</div>
                                </div>

                                <div class="card-body px-4 text-start">
                                    <ul class="list-unstyled">
                                        @php
                                            $features = [
                                                $value->data1,
                                                $value->data2,
                                                $value->data3,
                                                $value->data4,
                                                $value->data5,
                                                $value->data6
                                            ];
                                        @endphp

                                        @foreach($features as $feature)
                                        <li class="d-flex align-items-center gap-2">
                                            <div class="pb-2">
                                                @if(strpos($feature, 'Free Lifetime Update') !== false || 
                                                    strpos($feature, 'Premium Customer Support') !== false ||
                                                    strpos($feature, 'Android & iOS App Support') !== false ||
                                                    strpos($feature, 'Custom Invoice Branding') !== false ||
                                                    strpos($feature, 'Easily Manage your Business') !== false ||
                                                    strpos($feature, 'Unlimited Usage') !== false ||
                                                    strpos($feature, 'Free Data Backup') !== false)
                                                    <!-- Checkmark for positive features -->
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4482 1.227C10.2008 0.979662 9.79982 0.979679 9.55249 1.227L7.24041 3.53909H4.17291C3.82313 3.53909 3.53958 3.82264 3.53958 4.17242V7.23992L1.22749 9.552C0.980151 9.79934 0.980167 10.2003 1.22749 10.4477L3.53958 12.7598V15.8273C3.53958 16.177 3.82311 16.4606 4.17291 16.4606H7.2404L9.55249 18.7727C9.79982 19.02 10.2008 19.02 10.4482 18.7727L12.7602 16.4606H15.8277C16.1775 16.4606 16.4611 16.177 16.4611 15.8273V12.7598L18.7732 10.4477C19.0205 10.2003 19.0205 9.79934 18.7732 9.552L16.4611 7.23992V4.17242C16.4611 3.82262 16.1775 3.53909 15.8277 3.53909H12.7602L10.4482 1.227ZM12.8219 8.45217L13.3578 8.13062L12.7147 7.05875L12.1788 7.38032C11.0235 8.0735 10.0876 9.20159 9.45566 10.1119C9.22266 10.4476 9.02574 10.7615 8.86924 11.0253C8.69724 10.8637 8.53241 10.7248 8.38808 10.6105C8.23432 10.489 7.94308 10.2902 7.83492 10.2163L7.82473 10.2094L7.29048 9.885L6.64177 10.9535L7.17503 11.2773C7.2533 11.3308 7.47988 11.486 7.61268 11.591C7.88058 11.8028 8.21757 12.1049 8.51233 12.4733L9.13033 13.2458L9.56274 12.3557C9.60258 12.2791 9.71966 12.0547 9.79858 11.9148C9.95666 11.6348 10.1886 11.2482 10.4826 10.8248C11.0798 9.96425 11.8939 9.009 12.8219 8.45217Z" fill="#00932C"></path>
                                                    </svg>
                                                @else
                                                    <!-- X mark for negative/not included features -->
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18.3337 9.99935C18.3337 5.39697 14.6027 1.66602 10.0003 1.66602C5.39795 1.66602 1.66699 5.39697 1.66699 9.99935C1.66699 14.6017 5.39795 18.3327 10.0003 18.3327C14.6027 18.3327 18.3337 14.6017 18.3337 9.99935Z" fill="#FF3B30"></path>
                                                        <path d="M12.4995 12.5L7.5 7.5M7.50053 12.5L12.5 7.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            {{ $feature }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    <a class="btn subscribe-plan d-block mt-4 mb-2" data-bs-toggle="modal" data-bs-target="#registration-modal">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <input type="hidden" name="_token" value="GkWWpFvbss3FbIjlbQDXLdR3zSGh9j0tYhFWocNT" autocomplete="off">                        <div class="row">
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
                    <input type="hidden" name="_token" value="GkWWpFvbss3FbIjlbQDXLdR3zSGh9j0tYhFWocNT" autocomplete="off">                    <div class="code-input pin-container">
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

    @endsection