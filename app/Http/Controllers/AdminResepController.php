<?php

namespace App\Http\Controllers;

use Stevebauman\Purify\Facades\Purify;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminResepController extends Controller
{

    /**
     * Membersihkan HTML dari editor deskripsi.
     */
    private function bersihkanDeskripsi(?string $html): ?string
    {
        if ($html === null || trim(strip_tags($html)) === '') {
            return null;
        }

        return Purify::clean($html);
    }


    /**
     * Menampilkan daftar resep.
     */
    public function index()
    {
        $resep = Resep::orderBy('judul')->get();

        return view(
            'admin.resep.index',
            compact('resep')
        );
    }


    /**
     * Menampilkan form tambah resep.
     */
    public function create()
    {
        return view('admin.resep.create');
    }


    /**
     * Menyimpan resep baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'judul' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[\p{L}\p{N}\s.,!?:;\'"()\-+&\/%@#*_]+$/u',
                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (mb_strlen(strip_tags((string) $value)) > 5000) {
                            $fail('Deskripsi maksimal 5.000 karakter.');
                        }
                    },
                ],

                'foto' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

                'bahan' => [
                    'nullable',
                    'string',
                    'max:10000',
                ],

                'langkah_pembuatan' => [
                    'nullable',
                    'string',
                    'max:10000',
                ],

                'waktu_memasak' => [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:600',
                ],
            ],
            [
                'judul.required' =>
                'Judul resep wajib diisi.',

                'judul.string' =>
                'Judul resep harus berupa teks.',

                'judul.min' =>
                'Judul resep minimal 3 karakter.',

                'judul.max' =>
                'Judul resep maksimal 100 karakter.',

                'deskripsi.string' =>
                'Deskripsi harus berupa teks.',

                'deskripsi.max' =>
                'Deskripsi maksimal 5.000 karakter.',

                'foto.image' =>
                'File yang dipilih harus berupa gambar.',

                'foto.mimes' =>
                'Format foto harus JPG, JPEG, PNG, atau WEBP.',

                'foto.max' =>
                'Ukuran foto maksimal 2 MB.',

                'bahan.string' =>
                'Bahan harus berupa teks.',

                'bahan.max' =>
                'Bahan maksimal 10.000 karakter.',

                'langkah_pembuatan.string' =>
                'Langkah pembuatan harus berupa teks.',

                'langkah_pembuatan.max' =>
                'Langkah pembuatan maksimal 10.000 karakter.',

                'waktu_memasak.integer' =>
                'Waktu memasak harus berupa angka bulat.',

                'waktu_memasak.min' =>
                'Waktu memasak minimal 1 menit.',

                'waktu_memasak.max' =>
                'Waktu memasak maksimal 600 menit.',
            ]
        );

        $data['deskripsi'] = $this->bersihkanDeskripsi($data['deskripsi'] ?? null);

        try {
            // Simpan foto jika ada.
            if ($request->hasFile('foto')) {
                $data['foto'] = $request
                    ->file('foto')
                    ->store('recipes', 'public');
            }

            // Simpan resep.
            Resep::create($data);

            return redirect()
                ->route('admin.resep.index')
                ->with(
                    'success',
                    'Resep berhasil ditambahkan.'
                );
        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Resep gagal ditambahkan. Silakan coba lagi.'
                );
        }
    }


    /**
     * Menampilkan form edit resep.
     */
    public function edit($id)
    {
        $resep = Resep::findOrFail($id);

        return view(
            'admin.resep.edit',
            compact('resep')
        );
    }


    /**
     * Mengupdate resep.
     */
    public function update(
        Request $request,
        $id
    ) {
        $resep = Resep::findOrFail($id);

        $data = $request->validate(
            [
                'judul' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[\p{L}\p{N}\s.,!?:;\'"()\-+&\/%@#*_]+$/u',

                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (mb_strlen(strip_tags((string) $value)) > 5000) {
                            $fail('Deskripsi maksimal 5.000 karakter.');
                        }
                    },
                ],

                'foto' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

                'bahan' => [
                    'nullable',
                    'string',
                    'max:10000',
                ],

                'langkah_pembuatan' => [
                    'nullable',
                    'string',
                    'max:10000',
                ],

                'waktu_memasak' => [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:600',
                ],
            ],
            [
                'judul.required' =>
                'Judul resep wajib diisi.',

                'judul.string' =>
                'Judul resep harus berupa teks.',

                'judul.min' =>
                'Judul resep minimal 3 karakter.',

                'judul.max' =>
                'Judul resep maksimal 100 karakter.',

                'deskripsi.string' =>
                'Deskripsi harus berupa teks.',

                'deskripsi.max' =>
                'Deskripsi maksimal 5.000 karakter.',

                'foto.image' =>
                'File yang dipilih harus berupa gambar.',

                'foto.mimes' =>
                'Format foto harus JPG, JPEG, PNG, atau WEBP.',

                'foto.max' =>
                'Ukuran foto maksimal 2 MB.',

                'bahan.string' =>
                'Bahan harus berupa teks.',

                'bahan.max' =>
                'Bahan maksimal 10.000 karakter.',

                'langkah_pembuatan.string' =>
                'Langkah pembuatan harus berupa teks.',

                'langkah_pembuatan.max' =>
                'Langkah pembuatan maksimal 10.000 karakter.',

                'waktu_memasak.integer' =>
                'Waktu memasak harus berupa angka bulat.',

                'waktu_memasak.min' =>
                'Waktu memasak minimal 1 menit.',

                'waktu_memasak.max' =>
                'Waktu memasak maksimal 600 menit.',
            ]
        );

        $data['deskripsi'] = $this->bersihkanDeskripsi($data['deskripsi'] ?? null);

        try {
            // Simpan foto lama.
            $fotoLama = $resep->foto;

            // Jika ada foto baru.
            if ($request->hasFile('foto')) {
                $data['foto'] = $request
                    ->file('foto')
                    ->store('recipes', 'public');
            }

            // Update resep.
            $resep->update($data);

            // Hapus foto lama setelah update berhasil.
            if (
                $request->hasFile('foto') &&
                $fotoLama &&
                Storage::disk('public')->exists($fotoLama)
            ) {
                Storage::disk('public')->delete($fotoLama);
            }

            return redirect()
                ->route('admin.resep.index')
                ->with(
                    'success',
                    'Resep berhasil diperbarui.'
                );
        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Resep gagal diperbarui. Silakan coba lagi.'
                );
        }
    }


    /**
     * Menghapus resep.
     */
    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);

        /*
         * Jangan hapus resep yang masih memiliki
         * hubungan dengan produk.
         */
        if ($resep->produk()->exists()) {
            return back()->with(
                'error',
                'Resep tidak dapat dihapus karena masih memiliki produk terkait.'
            );
        }

        try {
            $fotoResep = $resep->foto;

            // Hapus resep.
            $resep->delete();

            // Hapus foto.
            if (
                $fotoResep &&
                Storage::disk('public')->exists($fotoResep)
            ) {
                Storage::disk('public')->delete($fotoResep);
            }

            return redirect()
                ->route('admin.resep.index')
                ->with(
                    'success',
                    'Resep berhasil dihapus.'
                );
        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Resep gagal dihapus. Silakan coba lagi.'
            );
        }
    }
}
