<!-- Modal -->
<div class="modal fade" id="editSiswa_{{ $siswa->id }}" tabindex="-1" role="dialog" aria-labelledby="editSiswaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSiswaLabel">Edit Siswa</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button position-absolute end-3 top-2"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.edit', ['id' => $siswa->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBookId" value="{{ $siswa->id }}">
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Siswa</label>
                            <input autocomplete="off" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name', $siswa->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="email" class="form-label">email</label>
                            <input autocomplete="off" type="email"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                value="{{ old('email', $siswa->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="old_password">Password Lama</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                    id="old_password" name="old_password" required>
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <label for="role_status" class="form-label">Status</label>
                            <input autocomplete="off" type="text"
                                class="form-control @error('role_status') is-invalid @enderror" id="role_status"
                                name="role_status" value="{{ old('role_status', $siswa->role_status) }}">
                            @error('role_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
