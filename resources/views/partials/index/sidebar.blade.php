<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('profile_siswa') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                <path
                    d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z">
                </path>
            </svg>
            <span class="ms-1 font-weight-bold">Profile</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('siswa/dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard_siswa') }}">

                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="line-md:home-twotone-alt" width="1.2em" height="1.2em"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Perpustakaan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('siswa/favourite') ? 'active' : '' }}"
                    href="{{ route('favourite') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="material-symbols:bookmark-outline" width="1.2em"
                            height="1.2em"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Favorite</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('siswa/download') ? 'active' : '' }}"
                    href="{{ route('download') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="line-md:cloud-download-outline-loop" width="1.2em"
                            height="1.2em"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Download</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
