<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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

<!-- New Orders Modal -->
<div class="modal fade" id="newOrderModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-bell me-2"></i>New Orders Alert
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="newOrdersTable">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Table Type</th>
                                <th>Total Amount</th>
                                <th>Items</th>
                                <th>Table ID</th>
                                <th>Customer Name</th>
                                <th>Costumer Contact</th>
                                <th>Office Name</th>
                                <th>Contact No.</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="newOrdersBody">
                            <!-- Orders Will Load Here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<style>
    #newOrdersTable th,
    #newOrdersTable td {
        font-size: 14px;
        padding: 10px;
    }

    .btn-accept {
        background: #198754;
        color: white;
        border-radius: 6px;
        padding: 5px 12px;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        border-radius: 6px;
        padding: 5px 12px;
    }

    .item-badge {
        display: inline-block;
        background: #f1f1f1;
        padding: 3px 8px;
        margin: 2px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>

<audio id="newOrderSound" src="{{ asset('sounds/order_received_audio.mp3') }}" preload="auto"></audio>

