<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder fs-4 mb-0 text-primary">Welcome {{ Auth::user()->name }}</h6>
            {{-- <h6 class="font-weight-bolder mb-0">{{ ucwords(request()->route()->uri) }}</h6> --}}
            {{-- {{ Auth::user()->id }} --}}
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <button type="button" class="nav-link bg-transparent border-0 pointer" data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none font-weight-bold fs-6">Log out</span>
                    </button>
                    @include('partials.modals.logout_modal')
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
