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

        .is-invalid~.invalid-feedback {
            display: block;
        }

        .btn-whatsapp {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .btn-pay {
            display: inline-block;
            background-color: #008cff;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
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
                                @if ($order->status_id == 2)
                                    <tr>
                                        <th>Silakan selesaikan pembayaran:</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $order->payment_name }}</td>
                                </tr>
                                {{-- <tr>
                            <th>Nomor Rekening</th>
                            <td>1234567890</td>
                        </tr> --}}
                                <tr>
                                    <th>Atas Nama</th>
                                    <td>Yayasan Wakaf Jariyah</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>Rp {{ number_format($order->amount ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($order->status_id == 1)
                                            Selesai
                                        @elseif ($order->status_id == 2)
                                            Pending
                                        @else
                                            Gagal
                                        @endif
                                    </td>
                                </tr>
                                @if ($order->status_id == 1)
                                    <tr>
                                        <th>Setelah transfer, silakan kirim bukti transfer ke admin melalui WhatsApp.</th>
                                        <th><a href="https://wa.me/{{ env('PHONE_NUMBER', '') }}?text=Halo%20admin,%20saya%20ingin%20memverifikasi%20pembayaran%20dengan%20ID:%20{{ $order->order_id }}" target="_blank" class="btn-whatsapp">WhatsApp</a></th>
                                    </tr>
                                @elseif ($order->status_id == 2)
                                    <tr>
                                        <th>Mohon lakukan pembayaran menggunakan tombol disamping.</th>
                                        <th><a href="{{ $order->payment_url }}" class="btn-pay">Bayar</a></th>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
