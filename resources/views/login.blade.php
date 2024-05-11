@extends('layouts.main_login')
@section('login_content')
    {{-- content --}}
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8 raleway">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder" style="color: var(--bs-semi-white)">HI EVERYONE</h3>
                                <p class="mb-0" style="color: var(--bs-semi-white)">Welcome To TBPERPUS Enjoy !
                                </p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login_user') }}">
                                    @csrf
                                    <label>Email</label>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                                            aria-describedby="email-addon" name="email">
                                    </div>
                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" placeholder="Password"
                                            aria-label="Password" aria-describedby="password-addon" name="password">
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto" style="color: var(--bs-semi-white)">
                                    Don't have an account?
                                    <a href="{{ route('register_user') }}"
                                        class="text-decoration-spacing text-decoration-underline font-weight-bold"
                                        style="color: var(--bs-semi-white)">Create account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <img src="../assets/img/curved-images/curved6.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Check if there are any error messages from Laravel validation
        @if ($errors->any())
            // Loop through each error message and display it using SweetAlert
            @foreach ($errors->all() as $error)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $error }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endforeach
        @endif
    </script>
@endsection
