<!-- Navbar -->
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Live Clock -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <span class="mr-2 d-lg-inline text-gray-600 small">Live Clock :   
                        <strong id="live_clock"></strong>
                    </span>
                </div>
            </div>
            <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User Dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            @foreach($personnel as $per)
                                @if($per->id == Auth::user()->personnel_id)
                                    @if($per->profile_path=="")
                                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt class="w-px-40 h-auto rounded-circle"/>
                                    @else
                                        <?php
                                            $str = $per->profile_path;
                                            $str = ltrim($str, 'public/');
                                        ?>
                                        <img src="{{ asset('../storage/'.$str) }}" alt class="w-px-40 h-auto rounded-circle"/>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            @foreach($personnel as $per)
                                                @if($per->id == Auth::user()->personnel_id)
                                                    @if($per->profile_path=="")
                                                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt class="w-px-40 h-auto rounded-circle"/>
                                                    @else
                                                        <?php
                                                            $str = $per->profile_path;
                                                            $str = ltrim($str, 'public/');
                                                        ?>
                                                        <img src="{{ asset('../storage/'.$str) }}" alt class="w-px-40 h-auto rounded-circle"/>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                                        <small class="text-muted camelcase">
                                            @if(Auth::user()->user_type == 1)ADMIN
                                            @elseif(Auth::user()->user_type == 2)CONDUCTOR
                                            @elseif(Auth::user()->user_type == 3)DISPATCHER
                                            @elseif(Auth::user()->user_type == 4)OPERATOR
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./dispatcher-profile">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <button class="dropdown-item mb-1" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
<!-- / Navbar -->

<!-- Logout Modal -->
    <div class="modal fade" role="dialog" aria-labelledby="logoutModalLabel" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalTitle">Ready to Leave?</h5>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
<!-- / Logout Modal -->

<!-- Scripts -->
    <script>
        // Live Clock Function
        var live_clock = document.getElementById('live_clock');
        function time() {
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var d = new Date();
            var date = d.toLocaleDateString("en-US", options);
            var s = d.getSeconds();
            var m = d.getMinutes();
            var h = d.getHours();
            live_clock.textContent = date + " / " +("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
        }
        setInterval(time, 1000);
    </script>   
<!-- / Scripts -->