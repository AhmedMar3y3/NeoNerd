<!-- resources/views/partials/navbar.blade.php -->
<!--  #f0639a -->
<nav class="navbar p-0 fixed-top d-flex flex-row" style="background: #0F172A">

    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="ms-auto d-flex align-items-center justify-content-center">
            <a class="sidebar-brand brand-logo text-decoration-none ms-5 fs-2" href="{{ route('admin.dashboard') }}" style="color: white">أطلبني</a>
            <!-- Notification Bell -->
            <li class="nav-item dropdown list-unstyled ms-4">
                <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell fa-lg" style="color:white;"></i>
                    <span id="notification-badge" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="display:none;">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" id="notification-list" style="min-width: 300px;">
                    {{-- Notifications and the clear all button will be rendered here by JS --}}
                </ul>
            </li>
            <audio id="notification-sound" src="/sounds/notification.mp3" preload="auto"></audio>
        </div>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>