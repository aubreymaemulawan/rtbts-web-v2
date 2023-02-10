<!-- Sidebar -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        
        <!-- Title Logo -->
        <div class="app-brand demo" style="padding-bottom:10px">
            <a class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo/app.png') }}">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-2">
                    Admin
                </span>
            </a>
        </div>

        <!-- Divider -->
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">

            <!-- Dashboard -->
            <li id=main-admin-dashboard class="menu-item">
                <a href="./admin" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Website -->
            <li id=main-admin-website class="menu-item">
                <a href="./" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-world"></i>
                    <div data-i18n="Go To Website">Go to Website</div>
                </a>
            </li>

            <!-- Management Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Management</span>
            </li>

            <!-- Trip Record -->
            <li id=main-admin-announcement class="menu-item">
                <a href="./announcement" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                    <div data-i18n="Trip Record">Announcements</div>
                </a>
            </li>

            <!-- Bus Personnel -->
            <li id=main-admin-personnel class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Bus Personnel">Bus Personnel</div>
                </a>
                <ul class="menu-sub">
                    <li id=menu-personnel class="menu-item">
                        <a href="./personnel" class="menu-link">
                            <div data-i18n="Manage Personnel">Manage Personnel</div>
                        </a>
                    </li>
                    <li id=menu-account class="menu-item">
                        <a href="./account" class="menu-link">
                            <div data-i18n="Accounts List">Accounts List</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Bus Vehicle -->
            <li id=main-admin-vehicle class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-bus"></i>
                    <div data-i18n="Bus Vehicle">Bus Vehicle</div>
                </a>
                <ul class="menu-sub">
                    <li id=menu-bus class="menu-item">
                        <a href="./bus" class="menu-link">
                            <div data-i18n="Manage Bus">Manage Bus</div>
                        </a>
                    </li>
                    <li id=menu-route class="menu-item">
                        <a href="./route" class="menu-link">
                            <div data-i18n="Manage Bus">Manage Route</div>
                        </a>
                    </li>
                    <li id=menu-fare class="menu-item">
                        <a href="./fare" class="menu-link">
                            <div data-i18n="Manage Fare">Manage Fare</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Bus Schedule -->
            <li id=main-admin-schedule class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Bus Schedule">Bus Schedule</div>
                </a>
                <ul class="menu-sub">
                    <li id=menu-schedule class="menu-item">
                        <a href="./schedule" class="menu-link">
                            <div data-i18n="Manage Schedules">Manage Schedules</div>
                        </a>
                    </li>
                    <li id=menu-personnel-schedule class="menu-item">
                        <a href="./personnel-schedule" class="menu-link">
                            <div data-i18n="Assigned Schedules">Assigned Schedules</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Records Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Records</span>
            </li>

            <!-- Trip Record -->
            <li id=main-admin-trip class="menu-item">
                <a href="./trip" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-trip"></i>
                    <div data-i18n="Trip Record">Trip Record</div>
                </a>
            </li>

            <!-- Tracking -->
            <li id=main-admin-tracking class="menu-item">
                <a href="./track" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-map-pin"></i>
                    <div data-i18n="Tracking">Tracking</div>
                </a>
            </li>

            <!-- Account Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Account</span>
            </li>

            <!-- My Profile -->
            <li id=menu-profile class="menu-item">
                <a href="./profile" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="My Profile">My Profile</div>
                </a>
            </li>
        </ul>
    </aside>
<!-- / Sidebar -->