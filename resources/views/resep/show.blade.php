@extends('layouts.public')

@section('title', $resep->judul . ' - TWFood')

@section('content')

    <section class="section">

        <div class="container">

            {{-- =========================
                 JUDUL RESEP
            ========================== --}}

            <div class="section-title">

                <h1>
                    {{ $resep->judul }}
                </h1>
                @if ($resep->deskripsi)
                    <div class="resep-deskripsi">
                        {!! $resep->deskripsi !!}
                    </div>
                @endif

            </div>


            {{-- =========================
                 FOTO RESEP
            ========================== --}}

            @if ($resep->foto)
                <div style="text-align:center; margin-bottom:40px;">

                    <img src="{{ asset('storage/' . $resep->foto) }}"
                        alt="{{ $resep->judul }}"
                        style="
                            max-width:600px;
                            width:100%;
                            border-radius:8px;
                        ">

                </div>
            @endif


            {{-- =========================
                 WAKTU MEMASAK
            ========================== --}}

            @if ($resep->waktu_memasak)
                <div class="content-card">

                    <strong>
                        Waktu Memasak
                    </strong>

                    <p>
                        {{ $resep->waktu_memasak }}
                        menit
                    </p>

                </div>
            @endif


            {{-- =========================
                 PRODUK TWFOOD
            ========================== --}}

            @if ($resep->produk->count() > 0)

                <div class="content-card" style="margin-top:20px;">

                    <h3>
                        Produk TWFood yang Digunakan
                    </h3>

                    <ul>

                        @foreach ($resep->produk as $item)
                            <li>

                                {{ $item->produk->nama_produk }}

                                @if ($item->jumlah)
                                    —
                                    {{ $item->jumlah }}
                                @endif

                            </li>
                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =========================
                 BAHAN
            ========================== --}}

            <div class="content-card" style="margin-top:20px;">

                <h3>
                    Bahan
                </h3>

                <p style="white-space:pre-line;">

                    {{ $resep->bahan }}

                </p>

            </div>


            {{-- =========================
                 LANGKAH PEMBUATAN
            ========================== --}}

            <div class="content-card" style="margin-top:20px;">

                <h3>
                    Langkah Pembuatan
                </h3>

                <p style="white-space:pre-line;">

                    {{ $resep->langkah_pembuatan }}

                </p>

            </div>


            {{-- =========================
                 KEMBALI
            ========================== --}}

            <div style="text-align:center;">

                <a href="{{ route('resep.public') }}" class="button">
                    Kembali ke Daftar Resep
                </a>

            </div>

        </div>

    </section>

@endsection
