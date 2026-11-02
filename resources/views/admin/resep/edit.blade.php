@extends('admin.layouts.app')

@section('title', 'Edit Resep - Admin TWFood')
@section('page-title', 'Edit Resep')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <style>
        /* Wrapper: rounded corners and a border that matches Tabler's inputs */
        #deskripsi-editor {
            border-radius: 0px 0px 6px 6px;
            overflow: hidden;
            border: 1px solid #dfe3e8;
        }

        #deskripsi-editor .ql-toolbar.ql-snow {
            border: none;
            border-bottom: 1px solid #dfe3e8;
            background: #f8f9fa;
        }

        #deskripsi-editor .ql-container.ql-snow {
            border: none;
            font-size: 1rem;
        }

        /* Make the writing area taller */
        #deskripsi-editor .ql-editor {
            min-height: 220px;
            /* adjust: 150px default */
            padding: 12px 16px;
        }

        /* Keep the error border visible when validation fails */
        #deskripsi-editor.border-danger {
            border-color: #d63939 !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">Pengelolaan Resep</div>
                <h2 class="page-title">Edit Resep</h2>
                <div class="text-secondary mt-1">
                    Perbarui informasi resep TWFood.
                </div>
            </div>

            <div class="col-auto">
                <a href="{{ route('admin.resep.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-bold mb-2">Periksa kembali data berikut:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="ti ti-alert-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.resep.update', $resep->id_resep) }}" method="POST" enctype="multipart/form-data"
        id="resep-form">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Resep</h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="judul" class="form-label required">Judul Resep</label>
                    <input type="text" name="judul" id="judul"
                        class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $resep->judul) }}"
                        placeholder="Contoh: Tumis Jamur Tiram" maxlength="100" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi-editor" class="form-label">Deskripsi</label>
                    <div id="deskripsi-editor" class="bg-white @error('deskripsi') border border-danger rounded @enderror">
                    </div>
                    {{-- Hidden textarea holds the HTML from Quill and is what gets submitted --}}
                    <textarea name="deskripsi" id="deskripsi" class="d-none">{{ old('deskripsi', $resep->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Resep Saat Ini</label>

                    <div class="mb-2">
                        @if ($resep->foto)
                            <img src="{{ asset('storage/' . $resep->foto) }}" alt="{{ $resep->judul }}"
                                class="rounded border" style="width: 160px; height: 160px; object-fit: cover;">
                        @else
                            <div class="text-secondary">
                                <i class="ti ti-photo-off me-1"></i>
                                Belum ada foto resep.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Ganti Foto Resep</label>
                    <input type="file" name="foto" id="foto"
                        class="form-control @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        Kosongkan jika tidak ingin mengganti foto.
                    </div>
                    <div id="foto-error" class="text-danger small mt-1 d-none"></div>
                    <img id="foto-preview" src="" alt="Pratinjau foto baru" class="mt-2 rounded border d-none"
                        style="max-height: 200px; max-width: 100%;">
                </div>

                <div class="mb-3">
                    <label for="bahan" class="form-label">Bahan</label>
                    <textarea name="bahan" id="bahan" class="form-control @error('bahan') is-invalid @enderror" rows="6"
                        maxlength="10000" placeholder="Tuliskan bahan-bahan yang diperlukan">{{ old('bahan', $resep->bahan) }}</textarea>
                    @error('bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="langkah_pembuatan" class="form-label">Langkah Pembuatan</label>
                    <textarea name="langkah_pembuatan" id="langkah_pembuatan"
                        class="form-control @error('langkah_pembuatan') is-invalid @enderror" rows="8" maxlength="10000"
                        placeholder="Tuliskan langkah-langkah pembuatan resep">{{ old('langkah_pembuatan', $resep->langkah_pembuatan) }}</textarea>
                    @error('langkah_pembuatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-0">
                    <label for="waktu_memasak" class="form-label">
                        Waktu Memasak (menit)
                    </label>
                    <input type="number" name="waktu_memasak" id="waktu_memasak"
                        class="form-control @error('waktu_memasak') is-invalid @enderror"
                        value="{{ old('waktu_memasak', $resep->waktu_memasak) }}" min="1" max="1440"
                        placeholder="Contoh: 30">
                    @error('waktu_memasak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">
                        Isi dalam menit, antara 1 hingga 1.440 menit. Boleh dikosongkan.
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('admin.resep.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#preview-modal" id="btn-preview">
                    <i class="ti ti-eye me-1"></i>
                    Pratinjau Pelanggan
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    {{-- Customer preview modal --}}
    <div class="modal modal-blur fade" id="preview-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pratinjau Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <img id="preview-foto" src="" alt="" class="img-fluid rounded mb-3 d-none">
                    <h2 id="preview-judul" class="mb-2"></h2>
                    <p class="text-secondary" id="preview-waktu"></p>
                    <div id="preview-deskripsi" class="mb-4 ql-editor p-0"></div>

                    <h4>Bahan</h4>
                    <div id="preview-bahan" class="mb-4" style="white-space: pre-wrap;"></div>

                    <h4>Langkah Pembuatan</h4>
                    <div id="preview-langkah" style="white-space: pre-wrap;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('resep-form');
            const deskripsiInput = document.getElementById('deskripsi');

            // 1. Quill rich text editor for deskripsi
            const quill = new Quill('#deskripsi-editor', {
                theme: 'snow',
                placeholder: 'Masukkan deskripsi resep',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['link'],
                        ['clean'],
                    ],
                },
            });

            // Load the existing description into the editor
            if (deskripsiInput.value.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(deskripsiInput.value);
            }

            // Sync Quill HTML back to the hidden textarea before submit
            form.addEventListener('submit', () => {
                const isEmpty = quill.getText().trim() === '';
                deskripsiInput.value = isEmpty ? '' : quill.root.innerHTML;
            });

            // 2. Image preview with client-side validation
            const fotoInput = document.getElementById('foto');
            const fotoPreview = document.getElementById('foto-preview');
            const fotoError = document.getElementById('foto-error');
            const MAX_SIZE = 2 * 1024 * 1024;
            const ALLOWED = ['image/jpeg', 'image/png', 'image/webp'];

            fotoInput.addEventListener('change', () => {
                const file = fotoInput.files[0];
                fotoError.classList.add('d-none');
                fotoPreview.classList.add('d-none');
                fotoPreview.removeAttribute('src');

                if (!file) return;

                if (!ALLOWED.includes(file.type)) {
                    fotoError.textContent = 'Format file harus JPG, JPEG, PNG, atau WEBP.';
                    fotoError.classList.remove('d-none');
                    fotoInput.value = '';
                    return;
                }

                if (file.size > MAX_SIZE) {
                    fotoError.textContent = 'Ukuran foto maksimal 2 MB.';
                    fotoError.classList.remove('d-none');
                    fotoInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    fotoPreview.src = e.target.result;
                    fotoPreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            });

            // 3. Customer preview: fill the modal from current form values
            const previewModal = document.getElementById('preview-modal');
            previewModal.addEventListener('show.bs.modal', () => {
                const judul = document.getElementById('judul').value.trim();
                const waktu = document.getElementById('waktu_memasak').value.trim();
                const bahan = document.getElementById('bahan').value.trim();
                const langkah = document.getElementById('langkah_pembuatan').value.trim();
                const deskripsiHtml = quill.getText().trim() === '' ? '' : quill.root.innerHTML;

                document.getElementById('preview-judul').textContent = judul || 'Judul resep';
                document.getElementById('preview-waktu').textContent =
                    waktu ? `⏱ ${waktu} menit` : '';
                document.getElementById('preview-deskripsi').innerHTML =
                    deskripsiHtml || '<p class="text-secondary">Belum ada deskripsi.</p>';
                document.getElementById('preview-bahan').textContent = bahan || '-';
                document.getElementById('preview-langkah').textContent = langkah || '-';

                // Use the newly selected photo if there is one, otherwise the current photo
                const previewFoto = document.getElementById('preview-foto');
                const currentFoto = document.querySelector('img[alt="{{ $resep->judul }}"]');
                if (fotoPreview.src && !fotoPreview.classList.contains('d-none')) {
                    previewFoto.src = fotoPreview.src;
                    previewFoto.alt = judul;
                    previewFoto.classList.remove('d-none');
                } else if (currentFoto) {
                    previewFoto.src = currentFoto.src;
                    previewFoto.alt = judul;
                    previewFoto.classList.remove('d-none');
                } else {
                    previewFoto.classList.add('d-none');
                }
            });
        });
    </script>
@endpush
