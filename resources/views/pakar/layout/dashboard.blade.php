<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penyuluh | Balai Penyuluhan Pertanian </title>

    <link rel="icon" type="image/png" href="{{ asset('obat/logo.png') }}" />


    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('lte/dist/css/adminlte.css') }}" as="style" />
    {{-- <link rel="stylesheet" href="{{ asset('css/konsultasi.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    {{-- link css --}}
    <link rel="stylesheet" href="{{ asset('css/cuaca.css') }}">
    <link rel="stylesheet" href="{{ asset('css/activitas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    {{-- end link css --}}

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />

    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/dasbor.css') }}">
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary sidebar-collapse">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="#" class="nav-link">Home</a>
                    </li>
                    
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">

                    <!--begin::Messages Dropdown Menu-->
                    <li class="nav-item dropdown" id="notification-dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text position-relative">
                                <span class="navbar-badge badge text-bg-danger d-none" id="notification-count"></span>
                            </i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" id="notification-list">
                            <span class="dropdown-item dropdown-header">Tidak ada pesan baru</span>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('notifications.fetch') }}" class="dropdown-item dropdown-footer">Lihat
                                Semua
                                Pesan</a>
                        </div>
                    </li>
                    <!--end::Messages Dropdown Menu-->

                    <!--begin::Fullscreen Toggle-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <!--end::Fullscreen Toggle-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">

                        <img src="{{ asset('lte/dist/assets/img/pakar.jpg') }}"
                            class="user-image rounded-circle shadow" alt="User Image" />
                        <!--
        Diubah: Mengambil nama pengguna yang sedang login.
        - : Memastikan kode ini hanya berjalan jika ada pengguna yang login.
        - auth()->user()->name: Mengakses properti 'name' dari user yang terautentikasi.
    -->
                        @auth
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        @endauth
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Image-->
                            <li class="user-header text-bg-primary">
                                <img src="{{ asset('lte/dist/assets/img/pakar.jpg') }}" class="rounded-circle shadow"
                                    alt="User Image" />
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2023</small>
                                </p>
                            </li>
                            <!--end::User Image-->
                            <!--begin::Menu Body-->
                            <li class="user-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </li>
                            <!--end::Menu Body-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="./index.html" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="{{ asset('lte/dist/assets/img/pakar.jpg') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light">Sistem Pakar</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        aria-label="Main navigation" data-accordion="false" id="navigation">

                        <li class="nav-item">
                            <a href="{{ route('pakar.dashboard') }}"
                                class="nav-link {{ request()->routeIs('pakar.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dasbor</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.users.index') }}"
                                class="nav-link {{ request()->routeIs('pakar.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Data Petani</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.penyakit.index') }}"
                                class="nav-link {{ request()->routeIs('pakar.penyakit.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bug-fill"></i>
                                <p>Jenis Penyakit</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.gejala.index') }}"
                                class="nav-link {{ request()->routeIs('pakar.gejala.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-activity"></i>
                                <p>Data Gejala</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.diagnosa.index') }}"
                                class="nav-link {{ request()->routeIs('pakar.diagnosa.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-clipboard2-pulse-fill"></i>
                                <p>Diagnosa</p>
                            </a>
                        </li>

                        <li class="nav-header">KOMUNIKASI</li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.chat.index') }}"
                                class="nav-link {{ request()->routeIs('pakar.chat.index') || request()->routeIs('chat.show') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-chat-dots-fill"></i>
                                <p>
                                    Chat Masuk

                                    <span id="chat-notification-badge"
                                        class="badge text-bg-danger float-end d-none">0</span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">PENGATURAN</li>

                        <li class="nav-item">
                            <a href="{{ route('pakar.profile.edit') }}"
                                class="nav-link {{ request()->routeIs('pakar.profile.edit') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-fill-gear"></i>
                                <p>Edit Profil</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="confirmLogout(event)">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Logout</p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display:none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        @yield('content')
        <!--begin::Footer-->
        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <!--end::To the end-->
            <!--begin::Copyright-->
            <strong>
                Copyright &copy; 2025&nbsp;
                <a href="" class="text-decoration-none">Balai Penyuluhan Pertanian</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script src="{{ asset('js/cuaca.js') }}"></script>
    <script src="{{ asset('js/activitas.js') }}"></script>
    {{-- <script src="{{ asset('js/konsultasi.js') }}"></script>  --}}
    <script src="{{ asset('js/style.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

    {{-- Notification --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationCountEl = document.getElementById('notification-count');
            const notificationListEl = document.getElementById('notification-list');
            const defaultAvatar = "{{ asset('lte/dist/assets/img/pakar.jpg') }}";
            const seeAllUrl = "{{ route('pakar.chat.index') }}";

            function fetchNotifications() {
                // Pastikan route ini benar dan bisa diakses
                fetch("{{ route('notifications.fetch') }}")
                    .then(response => {
                        if (!response.ok) {
                            console.error("Network response was not ok: " + response.statusText);
                            return;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data) return;

                        // Update jumlah notifikasi
                        if (data.count > 0) {
                            notificationCountEl.textContent = data.count;
                            notificationCountEl.classList.remove('d-none');
                            notificationCountEl.classList.add('active');
                        } else {
                            notificationCountEl.classList.add('d-none');
                            notificationCountEl.classList.remove('active');
                        }

                        // Bangun ulang daftar dropdown notifikasi
                        let html =
                            `<span class="dropdown-item dropdown-header">${data.count} Pesan Baru</span><div class="dropdown-divider"></div>`;

                        if (data.notifications && data.notifications.length > 0) {
                            data.notifications.forEach(notif => {
                                html += `
                        <a href="${notif.url}" class="dropdown-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="${defaultAvatar}" alt="User Avatar" class="img-size-50 rounded-circle me-3" />
                                </div>
                                <div class="flex-grow-1">
                                    <h3 class="dropdown-item-title">${notif.sender_name}</h3>
                                    <p class="fs-7">${notif.message_preview}</p>
                                    <p class="fs-7 text-secondary">
                                        <i class="bi bi-clock-fill me-1"></i> ${notif.time}
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>`;
                            });
                        } else {
                            html +=
                                `<a href="#" class="dropdown-item text-center text-muted">Tidak ada pesan baru</a><div class="dropdown-divider"></div>`;
                        }

                        html +=
                            `<a href="${seeAllUrl}" class="dropdown-item dropdown-footer">Lihat Semua Pesan</a>`;
                        notificationListEl.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }

            // Panggil fungsi saat halaman pertama kali dimuat
            fetchNotifications();

            // Panggil fungsi setiap 15 detik
            setInterval(fetchNotifications, 15000);
        });
    </script>
    {{-- and notifition --}}

    {{-- swite Allert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    {{-- and swite Allert --}}
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

            // Disable OverlayScrollbars on mobile devices to prevent touch interference
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->

    <!-- OPTIONAL SCRIPTS -->

    <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>

    <!-- sortablejs -->
    <script>
        new Sortable(document.querySelector('.connectedSortable'), {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>

    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function confirmLogout(event) {
            event.preventDefault(); // Mencegah link langsung jalan

            // Tampilkan SweetAlert
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik 'Ya', kirim form logout
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

     {{-- map --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('js/map.js') }}"></script>
    {{-- and map --}}

</body>
<!--end::Body-->

</html>
