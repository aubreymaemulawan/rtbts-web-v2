<!-- Sidebar -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        
        <!-- Title Logo -->
        <div class="app-brand demo" style="padding-bottom:10px">
            <a class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo/app.png') }}">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-2">
                    Dispatcher
                </span>
            </a>
        </div>

        <!-- Divider -->
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">

            <!-- Dashboard -->
            <li id=main-dispatcher-dashboard class="menu-item">
                <a href="./dispatcher" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Announcements -->
            <li id=main-dispatcher-announcement class="menu-item">
                <a href="./dispatcher-announcement" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-megaphone"></i>
                    <div data-i18n="Announcements">Announcements</div>
                </a>
            </li>

            <!-- Website -->
            <li id=main-dispatcher-website class="menu-item">
                <a href="./" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-world"></i>
                    <div data-i18n="Go To Website">Go to Website</div>
                </a>
            </li>

            <!-- Management Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Management</span>
            </li>

            <!-- Assign Schedule List -->
            <li id=main-dispatcher-assign-schedule class="menu-item">
                <a href="./dispatcher-assign-schedule" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Assign Schedule">Assign Schedule</div>
                </a>
            </li>
            <!-- Records Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Records</span>
            </li>

            <!-- Trip Records -->
            <li id=main-dispatcher-trip class="menu-item">
                <a href="./dispatcher-trip" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-trip"></i>
                    <div data-i18n="Trip Records">Trip Records</div>
                </a>
            </li>

            <!-- Account Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Account</span>
            </li>

            <!-- My Profile -->
            <li id=menu-dispatcher-profile class="menu-item">
                <a href="./dispatcher-profile" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="My Profile">My Profile</div>
                </a>
            </li>
        </ul>
    </aside>
<!-- / Sidebar -->