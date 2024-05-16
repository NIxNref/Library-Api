@extends('layouts.main_landing')
<nav class="navbar-1-landing justify-content-between" style="background-color: transparent;">
    <a href="{{ url('/') }}"
        class="text-center align-items-center justify-content-center d-flex text-decoration-none"
        style="color: white; cursor: default; padding-left: 4rem; padding-top: 2rem">
        <iconify-icon icon="basil:book-open-solid" width="45" height="45"></iconify-icon>
        <span class="expletus-sans" style="font-size: 40px; margin-left: 1rem">TBPERPUS</span>
    </a>
    <div>
        <a href="{{ route('login') }}" style="padding-right: 4rem; color: white" class="raleway">Sign In</a>
        <a href="{{ url('/register') }}" class="btn-1-landing text-decoration-none raleway">Get Started</a>
    </div>
</nav>
@section('landing_content')
@endsection
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
