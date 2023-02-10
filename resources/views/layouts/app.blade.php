<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">
  
    <head>
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <meta name="description" content="" />

        <!-- Page Title -->
        <title>@yield('title')  |  RTBTS</title>

        <!-- Page Icon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/app.png') }}" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}" type="text/css" >

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

        <!-- Helpers -->
        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('assets/js/config.js') }}"></script>

    </head>

    <body>
    @guest
        <!-- Login Route -->
        @if (Route::has('login'))
            <!-- Page CSS -->
            <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
            @yield('login_content')
        @endif
        @else
            <!-- Admin User -->
            @if( Auth::user()->user_type == 1)
                @yield('modal')
                <div class="layout-wrapper layout-content-navbar">
                    <div class="layout-container">
                        @include('admin.sidebar')
                        <div class="layout-page">
                        @include('admin.navbar')
                            <div class="content-wrapper">
                                @yield('admin_content')
                                @include('admin.footer')
                                <div class="content-backdrop fade"></div>
                            </div>
                        </div>
                    </div>
                    <div class="layout-overlay layout-menu-toggle"></div>
                </div>

            <!-- Conductor User -->
            @elseif( Auth::user()->user_type == 2)
                @yield('modal')
                <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    @include('conductor.sidebar')
                    <div class="layout-page">
                    @include('conductor.navbar')
                    <div class="content-wrapper">
                        @yield('conductor_content')
                        @include('conductor.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    </div>
                </div>
                    <div class="layout-overlay layout-menu-toggle"></div>
                </div>

            <!-- Dispatcher User -->
            @elseif( Auth::user()->user_type == 3)
                @yield('modal')
                <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    @include('dispatcher.sidebar')
                    <div class="layout-page">
                    @include('dispatcher.navbar')
                    <div class="content-wrapper">
                        @yield('dispatcher_content')
                        @include('dispatcher.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    </div>
                </div>
                    <div class="layout-overlay layout-menu-toggle"></div>
                </div>

            <!-- Operator User -->
            @elseif( Auth::user()->user_type == 4)
                <!-- @yield('modal') -->
                <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    @include('operator.sidebar')
                    <div class="layout-page">
                    @include('operator.navbar')
                    <div class="content-wrapper">
                        @yield('operator_content')
                        @include('operator.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    </div>
                </div>
                    <div class="layout-overlay layout-menu-toggle"></div>
                </div>
        @endif
    @endguest
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/ui-modals.js') }}"></script> -->
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script> -->
    <!-- Bootbox scripts -->
    <script src="{{ asset('assets/js/bootbox.min.js')}}"></script>
    <!-- POST & GET Request scripts -->
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <!-- Download HTML to PDF scripts -->
    <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}" type="text/javascript"></script>
    <!-- Data Table scripts -->
    <script src="{{ asset('assets/js/datatables.js') }}" type="text/javascript" charset="utf8"></script>  
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js" type="text/javascript" ></script>
    

    <script>
        function not_available(){
            bootbox.alert({
                message: "Feature still not available.",
                centerVertical: true,
                closeButton: false,
                size: 'medium',
            }); 
        }
    </script>
    @yield('scripts')
  </body>
  
</html>

