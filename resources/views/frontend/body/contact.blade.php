    @extends('frontend.layouts.master')
      @section('content')

    <section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                Home <span class="font-monospace">></span> Contact Us
            </p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Let's <span class="highlight-title">connect</span> with us</h2>
                <p>
                    We will help a client's problmes to develop the products they have with high quality change the appearance.
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3 align-self-center">
                    <div class="contact-image">
                        <img src="https://media.istockphoto.com/id/1557118048/photo/a-concept-that-expresses-the-hyper-connected-society-of-modern-society-by-connecting-people.jpg?s=612x612&w=0&k=20&c=7X-Keif1gNr5CsjR9OgHNpTx9sio9pc4UfSNCwGnLbk=" alt="image" class="w-100 object-fit-cover rounded-2">
                    </div>
                </div>
                <div class="col-lg-6 mb-3 align-self-center">
                   <form action="{{ route('contact.store') }}" method="post" class="ajaxform_instant_reload">
    @csrf
    <div class="row contact">
        <div class="col-md-12 mb-2">
            <label for="full-name" class="col-form-label fw-medium">Full Name <span class="text-orange">*</span></label>
            <input type="text" name="full_name" class="form-control" required id="full-name" 
                   placeholder="Enter full name" value="{{ old('full_name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-2">
            <label for="phone-number" class="col-form-label fw-medium">Phone Number <span class="text-orange">*</span></label>
            <input type="tel" name="phone_number" class="form-control" required id="phone-number" 
                   placeholder="Enter phone number" value="{{ old('phone_number') }}">
            @error('phone_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-12 mb-2">
            <label for="email" class="col-form-label fw-medium">Email <span class="text-orange">*</span></label>
            <input type="email" name="email" class="form-control" required id="email" 
                   placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-12 mb-2">
            <label for="company-name" class="col-form-label fw-medium">Company
                <small class="text-body-secondary">(Optional)</small></label>
            <input type="text" name="company_name" class="form-control" 
                   placeholder="Enter company name" value="{{ old('company_name') }}">
            @error('company_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-12 mb-2">
            <label for="message" class="col-form-label fw-medium">Message <span class="text-orange">*</span></label>
            <textarea name="message" class="form-control" required rows="4" 
                      placeholder="Enter your message">{{ old('message') }}</textarea>
            @error('message')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="col-md-12 mb-2">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        <div class="py-1 mt-3">
            <button type="submit" class="custom-btn custom-message-btn submit-btn">
                Send Message
            </button>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </section>
    @endsection