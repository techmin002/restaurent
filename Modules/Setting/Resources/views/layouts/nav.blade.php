{{-- <audio id="orderAlertSound" src="{{ asset('sounds/order_received_audio.mp3') }}" preload="auto" loop></audio> --}}

<!-- Modal -->
{{-- <div class="modal fade" id="orderAlertModal" tabindex="-1" role="dialog" aria-labelledby="orderAlertModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="orderAlertModalLabel">New Order Received</h5>
            </div>
            <div class="modal-body">
                <h6 id="orderFromHeading" class="text-primary mb-3"></h6>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Variation</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="orderItemsTableBody">
                        <!-- Order items will be appended here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="rejectOrderBtn" class="btn btn-danger">Reject</button>
                <button id="acceptOrderBtn" class="btn btn-success">Accept</button>
            </div>
        </div>
    </div>
</div> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> --}}

 {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    <!-- Your app.js or bootstrap.js script -->
    {{-- <script src="{{ asset('/build/assets/app-Dvg8hMT9.js') }}"></script>
    <audio id="notificationAudio" preload="auto">
        <source src="{{ asset('sounds/order_received_audio.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio> --}}

    <!-- Include jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
      <!-- Include Toastr JS -->

    <!-- Your app.js or bootstrap.js script -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
        {{-- <li class="nav-item">    <button onclick="document.getElementById('notificationAudio').play()">Test Sound</button> --}}
</li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-link">
            <form class="form-inline my-2 my-lg-0" action="https://classicro.com.np/customer/search" method="get">
                @csrf
                <input class="form-control mr-sm-2" name="username" placeholder="Username">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @if (!auth()->user()->image)
                        <i class="fa fa-user"></i>
                    @else
                        <img src="{{ asset('upload/images/users/' . auth()->user()->image) }}"
                            class="img-circle elevation-2" alt="User Image" height="100%">
                    @endif
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i>
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-arrow-right"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>


<!-- Bootstrap + jQuery (Ensure they are loaded before this script) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
