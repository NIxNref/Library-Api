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
                <a type="button" class="card b-modal" style="width: 10rem;" data-buku-id="{{ $buku->id }}">

                    <img class="card-img-top" src="{{ Storage::url('public/posts/') . $buku->image }}" alt="Card image cap">
                </a>
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
                    {{-- @if ($buku->id == $id)
                        
                    @endif --}}
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.b-modal').on('click', function(e) {
                // e.preventDefault();
                var bukuId = $(this).data('buku-id');
                var src = "{{ Storage::url('public/posts/') }}";
                $.ajax({
                    url: "{{ route('buku.show', '') }}/" + bukuId,
                    method: "GET",
                    success: function(response) {
                        $("#bukuModal .card-img-top").attr("src", src + '/' + response.image);
                        $("#bukuModal .modal-book-title").text(response.judul);
                        $("#bukuModal .modal-book-author").text("Penulis : " + response
                            .pengarang);
                        $("#bukuModal .modal-book-description").text(response.deskripsi);
                        // Update other modal content based on response fields
                        $('#bukuModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
                // $('#myModalPositions').modal('show').find('.modal-body').load($(this).attr('data-href'));
            });

            // $(".card").click(function(event) {
            //     event.preventDefault();
            //     var bukuId = $(this).data('buku-id'); // Access data-buku-id attribute

            //     $.ajax({
            //         url: "{{ route('buku.show', '') }}/" + bukuId,
            //         method: "GET",
            //         success: function(response) {
            //             $("#bukuModal .card-img-top").attr("src", response.image);
            //             $("#bukuModal .modal-title").text(response.judul);
            //             // Update other modal content based on response fields
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //         }
            //     });
            // });
        });
    </script>
@endpush
