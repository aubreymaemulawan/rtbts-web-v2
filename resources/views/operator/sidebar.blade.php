<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        
        <!-- Title Logo -->
        <div class="app-brand demo" style="padding-bottom:10px">
            <a class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo/app.png') }}">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-2">
                    Driver
                </span>
            </a>
        </div>

        <!-- Divider -->
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">

            <!-- Dashboard -->
            <li id=main-operator-dashboard class="menu-item">
                <a href="./operator" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Announcements -->
            <li id=main-operator-announcement class="menu-item">
                <a href="./operator-announcement" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-megaphone"></i>
                    <div data-i18n="Announcements">Announcements</div>
                </a>
            </li>

            <!-- Website -->
            <li id=main-operator-website class="menu-item">
                <a href="./" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-world"></i>
                    <div data-i18n="Go To Website">Go to Website</div>
                </a>
            </li>

            <!-- Records Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Records</span>
            </li>

            <!-- Schedule List -->
            <li id=main-operator-schedule class="menu-item">
                <a href="./operator-schedule" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Schedule List">Schedule List</div>
                </a>
            </li>

            <!-- Trip Records -->
            <li id=main-operator-trip class="menu-item">
                <a href="./operator-trip" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-trip"></i>
                    <div data-i18n="Trip Records">Trip Records</div>
                </a>
            </li>

            <!-- Account Divider -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Account</span>
            </li>

            <!-- My Profile -->
            <li id=menu-operator-profile class="menu-item">
                <a href="./operator-profile" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="My Profile">My Profile</div>
                </a>
            </li>
        </ul>
    </aside>
<!-- / Sidebar -->