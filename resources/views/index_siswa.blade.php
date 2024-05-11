@extends('layouts.main_index')
@push('additional-css')
    <style>
        .card-body {
            min-height: 150px;
            min-width: 300px;
            margin-right: 5px;
        }
    </style>
@endpush

@section('main_index')
    {{-- content --}}
    <div class=" py-4 raleway">
        <div class="d-flex flex-row flex-nowrap gap-4">
            @foreach ($bukus as $buku)
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ Storage::url('public/posts/') . $buku->image }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title" style="text-transform: capitalize">{{ $buku->judul }}</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
