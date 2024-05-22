@extends('layouts.main_index')
@push('additional-css')
    <style>
        .card-body {
            min-height: 150px;
            min-width: 300px;
            margin-right: 5px;
        }

        .card-out-of-stock {
            position: relative;
            opacity: 0.6;
            pointer-events: none;
        }

        .card-out-of-stock::after {
            content: 'Stok Habis';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 5px;
            border-radius: 3px;
        }
    </style>
@endpush

@section('main_index')
    {{-- content --}}
    <div class=" py-4 raleway">
        <div class="d-flex flex-row flex-nowrap gap-4">
            @foreach ($bukus as $buku)
                @if ($buku->stok_buku > 0)
                    <a type="button" class="card b-modal" style="width: 10rem;" data-buku-id="{{ $buku->id }}">
                        <img class="card-img-top" src="{{ Storage::url('public/posts/') . $buku->image }}"
                            alt="Card image cap">
                    </a>
                @else
                    <div class="card card-out-of-stock" style="width: 10rem;">
                        <img class="card-img-top" src="{{ Storage::url('public/posts/') . $buku->image }}"
                            alt="Card image cap">
                    </div>
                @endif
            @endforeach
        </div>
        <div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Buku</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img class="card-img-top" src="" alt="Book Image">
                        <span class="modal-book-rating d-flex align-items-center"
                            style="text-transform: capitalize; color: var(--bs-orange)">
                            <iconify-icon icon="material-symbols-light:star-outline" width="24px"
                                height="24px"></iconify-icon>
                            <span class="rating lead"></span></span>
                        <h5 class="modal-book-title" style="text-transform: capitalize"></h5>
                        <!-- Menampilkan nama penulis -->
                        <p class="modal-book-author" style="text-transform: capitalize"></p>
                        <!-- Menampilkan deskripsi buku -->
                        <p class="modal-book-description" style="text-transform: capitalize"></p>
                        <!-- Tambahkan lebih banyak bidang sesuai kebutuhan -->
                        <form action="{{ route('pinjam_buku', $buku->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-info">Pinjam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            $('.b-modal').on('click', function() {
                var bukuId = $(this).data('buku-id');
                var src = "{{ Storage::url('public/posts/') }}";
                // var iconStr = `<iconify-icon icon="material-symbols-light:star-outline" width="1.2em" height="1.2em"></iconify-icon>`;
                $.ajax({
                    url: "{{ route('buku.show', '') }}/" + bukuId,
                    method: "GET",
                    success: function(response) {
                        $("#bukuModal .card-img-top").attr("src", src + '/' + response.image);
                        $("#bukuModal .modal-book-title").text(response.judul);
                        $("#bukuModal .modal-book-rating .rating").text(response
                            .average_rating);
                        $("#bukuModal .modal-book-author").text("Penulis : " + response
                            .pengarang);
                        $("#bukuModal .modal-book-description").text(response.deskripsi);
                        $('#bukuModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
@endpush
