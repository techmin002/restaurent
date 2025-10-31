        @include('setting::layouts.header')
        @include('setting::layouts.nav')
        @include('setting::layouts.sidebar')

        <style>
            body {
                font-family: "Trirong", serif;
            }
        </style>

        <body class="hold-transition sidebar-mini layout-fixed">
            <div class="wrapper">
                @include('setting::layouts.alert')
                <!-- Preloader -->
                {{-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
              </div> --}}
                @yield('content')
                {{-- </body> --}}
                @include('setting::layouts.footer')
