@extends('layouts.app')

@section('content')
    <style>
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(3px);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            margin-left: 0 !important;
            margin: 0;
            min-height: 100vh;
            background-image: url('https://berduflare.com/pattern/asanoha-400px.png');
            background-repeat: repeat;
            background-size: auto;
        }
        .bg-custom {
            background-color: #006A71 !important;
            color: #fff;
        }

        /* Kelas khusus untuk validasi input yang tidak valid */
        .is-invalid {
            border-color: #dc3545;
        }

        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
<section class="content">
<div class="content-wrapper" style="margin-left: 0">
    <div class="content pt-4">
        <div class="container">
            <h1 class="mb-4">Daftar Donasi</h1>

            {{-- Tabel Donasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mt-4">
                <div class="card-header bg-custom">
                    <h3 class="card-title">Daftar Donasi</h3>
                </div>
                <div class="card-body table-responsive p-0">

                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>Silakan transfer jumlah donasi ke rekening berikut:</th>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td>BSI</td>
                        </tr>
                        <tr>
                            <th>Nomor Rekening</th>
                            <td>1234567890</td>
                        </tr>
                        <tr>
                            <th>Atas Nama</th>
                            <td>Yayasan Wakaf Jariyah</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp {{ number_format(session('amount') ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Setelah transfer, silakan kirim bukti transfer ke admin melalui WhatsApp.</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
