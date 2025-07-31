@extends('adminlte::master')

@section('title', 'Formulir Donasi')

@section('adminlte_css')
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
@endsection


@section('body')
<div class="content-wrapper" style="margin-left: 0">
    <div class="content pt-4">
        <div class="container">
            <h1 class="mb-4">Formulir Donasi</h1>

            {{-- Form Donasi --}}
            <div class="card">
                <div class="card-header bg-custom">
                    <h3 class="card-title">Formulir Donasi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama" required>
                            <div class="invalid-feedback">
                                Bagian ini wajib diisi.
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                            <div class="invalid-feedback">
                                Bagian ini wajib diisi.
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control" placeholder="Masukkan Jenis Kelamin" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                Bagian ini wajib diisi.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">No. HP</label>
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Masukkan No Hp" required
                                pattern="^\+?[0-9]{10,15}$" 
                                title="Nomor telepon tidak valid. Harap masukkan nomor telepon yang benar (minimal 10 digit, maksimal 15 digit)." />
                            <div class="invalid-feedback">
                                Bagian ini wajib diisi dan harus berupa nomor telepon yang valid.
                            </div>
                        </div>

                        <div class="form-row d-flex align-items-end">
                            <div class="form-group col-md-10">
                                <label for="item">Item Donasi</label>
                                <select name="item" id="item" class="form-control" required onchange="updateAmount()">
                                <option value="">Pilih Item</option>
                                <option value="Al-Quran Varian 1 (Rp. 25.000)" data-priced="25000">Al-Quran Varian 1 (Rp. 25.000)</option>
                                <option value="Al-Quran Varian 2 (Rp. 50.000)" data-priced="50000">Al-Quran Varian 2 (Rp. 50.000)</option>
                                <option value="Al-Quran Varian 3 (Rp. 75.000)" data-priced="75000">Al-Quran Varian 3 (Rp. 75.000)</option>
                                </select>
                                <div class="invalid-feedback">
                                Bagian ini wajib diisi.
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="qty">Kuantitas</label>
                                <input name="qty" id="qty" class="form-control" required type="number" min="1" step="1"
                                    oninput="this.value = this.value.replace(/^0+/, '')"
                                    onchange="updateAmount()"
                                    placeholder="pcs" inputmode="numeric"
                                    pattern="^[1-9][0-9]*$"
                                    title="input hanya berbentuk angka" />
                                <div class="invalid-feedback">
                                Bagian ini wajib diisi dan harus berupa angka absolut.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah (Rp)</label>
                            <input type="text" id="amount" name="amount" class="form-control" readonly required>
                        </div>

                        <!-- <div class="form-group">
                            <label>No Pembayaran</label>
                            <input type="text" name="payment_no" class="form-control" required>
                        </div> -->

                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea name="notes" rows="3" class="form-control" placeholder="Masukkan Pesan (optional)"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <input type="text" name="payment_name" id="payment_name" value="" class="d-none">
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="" class="d-none">Pilih</option>
                                @foreach ($payment_methods as $item)
                                    <option value="{{ $item['paymentMethod'] }}">{{ $item['paymentName'] }}</option>                                 
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Bagian ini wajib diisi.
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Kirim Donasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('adminlte_js')
@parent
<script> 
    $(document).ready(function() {
        // Fungsi untuk menangani validasi form ketika form disubmit
        $('form').on('submit', function(event) {
            var phoneInput = $('#phone'); // Mengambil elemen input nomor telepon

            // Reset status invalid sebelum validasi
            phoneInput.removeClass('is-invalid');

            // Validasi jika input kosong atau format tidak sesuai dengan pola
            if (!phoneInput[0].checkValidity()) {
                phoneInput.addClass('is-invalid'); // Menambahkan kelas is-invalid jika tidak valid
                event.preventDefault(); // Mencegah form disubmit jika ada error
            }
        });

        // Untuk menangani validasi input secara langsung saat pengguna mengetik
        $('#phone').on('input', function() {
            var phoneInput = $(this);

            // Jika input valid, hapus kelas is-invalid
            if (phoneInput[0].checkValidity()) {
                phoneInput.removeClass('is-invalid');
            } else {
                phoneInput.addClass('is-invalid');
            }
        });
    });

    function updateAmount() {
        const itemSelect = document.getElementById('item');
        const qty = document.getElementById('qty').value;
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-priced');
        document.getElementById('amount').value = qty ? price * qty : '';
    }

    document.querySelector('#payment_method').addEventListener('change', (e) => {
        let pm = document.querySelector('#payment_method');

        document.querySelector('#payment_name').value = pm.options[pm.selectedIndex].text;
    });
</script>
@endsection
