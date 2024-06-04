@extends('layouts.main_index_admin')
@section('main_index')
    {{-- content --}}
    {{-- <style>
        .text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 56px;
        }
    </style> --}}

    <div class="container-fluid py-4">
        <div class="container-fluid py-4">
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#createBuku">
                Buat Buku
            </button>
            @include('partials.buku.create_buku')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Perpustakaan</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No.
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                                Gambar
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Judul</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Penerbit</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Penulis</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Deskripsi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Stok Buku</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bukus as $buku)
                                            <tr>
                                                <td>
                                                    <p class="text-center font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ $buku->image }}"
                                                        class="rounded" style="width: 150px">
                                                </td>
                                                <td class="px-3">
                                                    <p class="text-xs text-secondary mb-0"
                                                        style="text-transform: capitalize">{{ $buku->judul }}</p>
                                                </td>
                                                <td class="px-3">
                                                    <p class="text-xs text-secondary mb-0"
                                                        style="text-transform: capitalize">{{ $buku->penerbit }}</p>
                                                </td>
                                                <td class="px-3">
                                                    <p class="text-xs text-secondary mb-0"
                                                        style="text-transform:capitalize">{{ $buku->pengarang }}</p>
                                                </td>
                                                <td class="px-3">
                                                    <p class="text-xs text-secondary mb-0 text-truncate"
                                                        style="text-transform:capitalize">{{ $buku->deskripsi }}</p>
                                                </td>
                                                <td class="px-3">
                                                    <p class="text-xs text-secondary mb-0">{{ $buku->stok_buku }}</p>
                                                </td>
                                                <td class="gap-3">
                                                    <button type="button" class="btn bg-gradient-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editBuku_{{ $buku->id }}"
                                                        data-book-id="{{ $buku->id }}">
                                                        Edit
                                                    </button>
                                                    @include('partials.buku.edit_buku')
                                                    <form id="deleteForm_{{ $buku->id }}"
                                                        action="{{ route('buku.delete', $buku->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="confirmDelete({{ $buku->id }})">Delete</button>
                                                    </form>
                                                </td>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        @elseif (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm_' + id).submit();
                }
            })
        }
    </script>
@endsection
