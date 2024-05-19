<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <a href="{{ route('dashboard_admin') }}"
        class="text-center align-items-center justify-content-center d-flex text-decoration-none"
        style="color: black; cursor: default">
        <iconify-icon icon="basil:book-open-solid" width="40" height="40"></iconify-icon>
        <span class="expletus-sans" style="font-size: 30px">TBPERPUS</span>
    </a>
    <hr class="horizontal dark mt-0">
    <div class="w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard_admin') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: {{ request()->is('admin/dashboard') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;">
                            <path
                                d="M7 3h2v18H7zM4 3h2v18H4zm6 0h2v18h-2zm9.062 17.792-6.223-16.89 1.877-.692 6.223 16.89z">
                            </path>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Perpustakaan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/data_admin') ? 'active' : '' }}"
                    href="{{ route('data_admin') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: {{ request()->is('admin/data_admin') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;">
                            <path
                                d="M20 6c0-2.168-3.663-4-8-4S4 3.832 4 6v2c0 2.168 3.663 4 8 4s8-1.832 8-4V6zm-8 13c-4.337 0-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3c0 2.168-3.663 4-8 4z">
                            </path>
                            <path d="M20 10c0 2.168-3.663 4-8 4s-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3z">
                            </path>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Data Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/data_siswa') ? 'active' : '' }}"
                    href="{{ route('data_siswa') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: {{ request()->is('admin/data_siswa') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;">
                            <path
                                d="M20 6c0-2.168-3.663-4-8-4S4 3.832 4 6v2c0 2.168 3.663 4 8 4s8-1.832 8-4V6zm-8 13c-4.337 0-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3c0 2.168-3.663 4-8 4z">
                            </path>
                            <path d="M20 10c0 2.168-3.663 4-8 4s-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3z">
                            </path>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Data User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/data_petugas') ? 'active' : '' }}"
                    href="{{ route('data_petugas') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: {{ request()->is('admin/data_petugas') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;">
                            <path
                                d="M20 6c0-2.168-3.663-4-8-4S4 3.832 4 6v2c0 2.168 3.663 4 8 4s8-1.832 8-4V6zm-8 13c-4.337 0-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3c0 2.168-3.663 4-8 4z">
                            </path>
                            <path d="M20 10c0 2.168-3.663 4-8 4s-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3z">
                            </path>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Data Petugas</span>
                </a>
            </li>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <li class="nav-item">
                <a type="button" class="nav-link border-0 pointer" data-bs-toggle="modal"
                    data-bs-target="#logoutModal">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="line-md:logout" width="25" height="25"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Log out</span>
                </a>
            </li>

        </ul>
        {{-- <li class="d-flex align-items-center">
            <button type="button" class="border-0 pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none font-weight-bold fs-6">Log out</span>
            </button>
            @include('partials.modals.logout_modal')
        </li> --}}
    </div>  
</aside>
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
