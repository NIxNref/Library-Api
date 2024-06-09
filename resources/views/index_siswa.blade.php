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

        .button_fav {
            background-color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
        }

        .button_fav.active {
            background-color: yellow;
            /* Warna saat tombol ditekan */
        }

        .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-body .row {
            width: 100%;
        }

        .modal-body img {
            max-width: 100%;
            height: auto;
        }

        .modal-book-rating {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .modal-book-title,
        .modal-book-author,
        .modal-book-publisher,
        .modal-book-description,
        .modal-book-quantity {
            margin-bottom: 10px;
        }

        .modal-book-reviews {
            margin-bottom: 10px;
            padding-right: 15px;
            /* To accommodate scrollbar width */
        }

        .modal-book-description {
            text-transform: capitalize;
            font-family: Arial, sans-serif;
            /* Ganti dengan font yang Anda sukai */
            font-size: 16px;
            /* Sesuaikan ukuran font sesuai preferensi Anda */
            line-height: 1.5;
            /* Sesuaikan ketinggian baris sesuai preferensi Anda */
            color: #333;
            /* Ganti dengan warna teks yang Anda sukai */
            margin: 0;
            /* Hilangkan margin default */
            padding: 10px;
            /* Tambahkan padding untuk memisahkan teks dari tepi kontainer */
            background-color: #f8f8f8;
            /* Ganti dengan warna latar belakang yang Anda sukai */
            border: 1px solid #ccc;
            /* Tambahkan border untuk membingkai teks */
            border-radius: 5px;
            /* Tambahkan border radius untuk sudut yang lebih lembut */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Tambahkan shadow untuk efek ketinggian */
        }

        .custom-hr {
            border: none;
            height: 1px;
            background-color: #000;
            /* Warna garis */
            margin: 10px 0;
            /* Jarak di atas dan di bawah garis */
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
                        <img class="card-img-top" src="{{ $buku->image }}" alt="Card image cap">
                    </a>
                @else
                    <div class="card card-out-of-stock" style="width: 10rem;">
                        <img class="card-img-top" src="{{ $buku->image }}" alt="Card image cap">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img class="img-fluid card-img-top" src="" alt="Book Image">
                        </div>
                        <div class="col-md-6">
                            <h5 class="modal-book-title" style="text-transform: capitalize"></h5>
                            <!-- Menampilkan nama penulis -->
                            <p class="modal-book-author" style="text-transform: capitalize"></p>
                            <!-- Menampilkan penerbit -->
                            <p class="modal-book-publisher" style="text-transform: capitalize"></p>
                            <!-- Menampilkan deskripsi buku -->
                            <p class="modal-book-description" style="text-transform: capitalize"></p>
                            <!-- Menampilkan jumlah buku -->
                            <p class="modal-book-quantity" style="text-transform: capitalize"></p>
                            <div class="modal-book-rating d-flex align-items-center"
                                style="text-transform: capitalize; color: var(--bs-orange)">
                                <iconify-icon icon="material-symbols-light:star-outline" width="24px"
                                    height="24px"></iconify-icon>
                                <span class="rating lead"></span>
                            </div>
                            {{-- <div>
                                <form action="{{ route('fav_siswa', '') }}" method="POST" id="favForm">
                                    @csrf
                                    @method('POST')
                                    <button style="border-color: transparent" class="button_fav">
                                        <iconify-icon icon="material-symbols:bookmark-outline" width="30px" height="30px"
                                            style="margin-left: 20px"></iconify-icon>
                                    </button>
                                </form>
                            </div> --}}

                            <form action="" method="POST" id="pinjamForm">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-info">Pinjam</button>
                            </form>
                            <hr class="custom-hr">
                            <!-- Menampilkan ulasan buku -->
                            <div class="" style="text-transform: capitalize; max-height: 200px; overflow-y: auto;">
                                <p><strong>Ulasan</strong></p>
                            </div>
                            <!-- Menampilkan ulasan buku -->
                            <div class="modal-book-reviews"
                                style="text-transform: capitalize; max-height: 200px; overflow-y: auto;"></div>
                        </div>
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


            // Memilih tombol "Close" atau tombol "X" pada modal
            var closeButton = $('#bukuModal .close');

            // Menambahkan event listener untuk menutup modal saat tombol "Close" atau tombol "X" diklik
            closeButton.on('click', function() {
                hideModal(); // Panggil fungsi hideModal
            });

            // Memilih elemen modal
            var modal = $('#bukuModal');

            // Menambahkan event listener untuk menutup modal saat klik di luar modal
            $(window).on('click', function(event) {
                if ($(event.target).is(modal)) {
                    hideModal(); // Panggil fungsi hideModal
                }
            });

            // Fungsi untuk menutup modal
            function hideModal() {
                modal.modal('hide');
            }


            $('.b-modal').on('click', function() {
                var bukuId = $(this).data('buku-id');

                $.ajax({
                    url: "{{ route('buku.show', '') }}/" + bukuId,
                    method: "GET",
                    success: function(response) {
                        $("#bukuModal .card-img-top").attr("src", response.image);
                        $("#bukuModal .modal-book-title").text(response.judul);
                        $("#bukuModal .modal-book-rating .rating").text(response
                            .average_rating);
                        $("#bukuModal .modal-book-author").text("Penulis : " + response
                            .pengarang);
                        $("#bukuModal .modal-book-description").text(response.deskripsi);
                        $("#bukuModal .modal-book-quantity").text("Stok : " + response
                            .stok_buku);

                        // var reviewsHtml = "";
                        // response.ulasan.forEach(function(review) {
                        //     reviewsHtml += "<p>" + review + "</p>";
                        // });
                        // $("#bukuModal .modal-book-reviews").html(reviewsHtml);

                        // Update form action with the correct book ID
                        var favUrl = "{{ url('fav_siswa') }}/" + bukuId;
                        var pinjamUrl = "{{ route('pinjam_buku', '') }}/" + bukuId;

                        console.log("Favorite URL: " + favUrl);
                        console.log("Pinjam URL: " + pinjamUrl);

                        $('#favForm').attr('action', favUrl);
                        $('#pinjamForm').attr('action', pinjamUrl);

                        $.ajax({
                            url: "http://127.0.0.1:8000/api/showUlasan/" + bukuId,
                            method: "GET",
                            success: function(response) {
                                var reviewsHtml = "";
                                if (response && response.data && response.data
                                    .length > 0) {
                                    response.data.forEach(function(review) {
                                        reviewsHtml +=
                                            "<div class='review'>";
                                        reviewsHtml +=
                                            "<p><strong>From:</strong> " +
                                            review.user.name + "</p>";
                                        reviewsHtml +=
                                            "<p><strong>Review:</strong> " +
                                            review.ulasan + "</p>";
                                        reviewsHtml += "</div>";
                                    });
                                } else {
                                    reviewsHtml =
                                        "<p>No reviews available for this book.</p>";
                                }
                                $("#bukuModal .modal-book-reviews").html(
                                    reviewsHtml);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching reviews: " + error);
                            }
                        });

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
