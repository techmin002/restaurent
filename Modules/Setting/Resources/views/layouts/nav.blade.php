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


<div class="popup" id="notifyPopup">
    <div class="popup-icon">🔔</div>
    <div class="popup-content">
        <h4>New Notification</h4>

        <p>Tables: <span id="tableList"></span> need attention!</p>

        <button id="popupOkBtn" class="popup-btn">OK</button>
    </div>
    <span class="popup-close" id="popupClose">&times;</span>
</div>

<audio id="notifySound">
    <source src="{{ asset('sounds/order_completed_audio.mp3') }}" type="audio/mpeg">
</audio>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        // let lastTables = [];

        const popup = document.getElementById('notifyPopup');
        const closeBtn = document.getElementById('popupClose');

        closeBtn.addEventListener('click', () => {
            popup.classList.remove('show');
        });

        function checkNotification() {
            fetch('/check-notification')
                .then(res => res.json())
                .then(data => {

                    if (data.notify == 1) {

                        document.getElementById('tableList').textContent = data.tables.join(', ');
                        popup.classList.add('show');

                        // Play sound ONLY if new tables arrived
                        if (JSON.stringify(data.tables) !== JSON.stringify(lastTables)) {
                            document.getElementById('notifySound').play();
                        }

                        lastTables = data.tables; // update previous list

                    } else {
                        popup.classList.remove('show');
                        lastTables = [];
                    }

                })
                .catch(err => console.error(err));
        }

        setInterval(checkNotification, 3000);
        checkNotification();

    });

    document.addEventListener('DOMContentLoaded', function() {

        const popup = document.getElementById('notifyPopup');
        const closeBtn = document.getElementById('popupClose');
        const okBtn = document.getElementById('popupOkBtn');

        // Close with X
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('show');
        });

        // OK BUTTON → Go to controller to reset notification
        okBtn.addEventListener('click', () => {
            fetch('/reset-notification', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    popup.classList.remove('show'); // hide popup
                });
        });

        function checkNotification() {
            fetch('/check-notification')
                .then(res => res.json())
                .then(data => {

                    if (data.notify == 1) {
                        document.getElementById('tableNum').textContent = data.table_number;
                        popup.classList.add('show');
                    } else {
                        popup.classList.remove('show');
                    }

                })
                .catch(err => console.error(err));
        }

        setInterval(checkNotification, 3000);
        checkNotification();

    });
</script>


<style>
    .popup {
        position: fixed;
        top: 20px;
        right: -350px;
        /* hidden outside screen */
        width: 300px;
        background: #ff4b4b;
        color: white;
        padding: 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 99999;
        transition: right 0.4s ease;
        font-family: Arial, sans-serif;
    }

    .popup.show {
        right: 20px;
        /* slide into screen */
    }

    .popup-icon {
        font-size: 30px;
    }

    .popup-content h4 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .popup-content p {
        margin: 0;
        font-size: 14px;
    }

    .popup-close {
        margin-left: auto;
        font-size: 22px;
        cursor: pointer;
        font-weight: bold;
    }

    .popup-close:hover {
        color: #000;
    }

    .popup-btn {
        background: white;
        color: #ff4b4b;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        margin-top: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    .popup-btn:hover {
        background: #ffe1e1;
    }
</style>
