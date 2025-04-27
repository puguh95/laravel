@extends('adminlte::page')

@section('title', 'Daftar Donasi')

@section('adminlte_css')
    <style>
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


@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

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
                    @if ($orders->isEmpty())
                        <p class="text-center mt-3">Belum ada donasi yang masuk.</p>
                    @else
                        <table class="table table-bordered table-hover text-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Notes</th>
                                    <th>Item</th>
                                    <th>Amount</th>
                                    <th>Reference No</th>
                                    <th>Status Payment</th>
                                    <th>Status Order</th>
                                    <th>Created At</th>
                                    <!-- <th>Checked At</th> -->
                                    <th>Checked By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ ucfirst($order->gender) }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td>{{ $order->item }}</td>
                                    <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                    <td>{{ $order->reference }}</td>
                                    <td>
                                        <span class="badge {{ $order->status_id == '1' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($order->status_id) == '1' ? 'Success' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->status == 'success' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at ? formatEpochFromTimestamp($order->created_at) : '-' }}</td>
                                    <!-- <td>{{ $order->checked_at ? formatEpoch($order->checked_at) : '-' }}</td> -->
                                    <td>{{ $order->checked_by ?? '-' }}</td>
                                    <td>
                                        @if ($order->status === 'checking')
                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success mt-1">Check Donation</button>
                                            </form>
                                        @else 
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('adminlte_js')
@parent
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle form submission with AJAX
        $('form').on('submit', function(event) {
            event.preventDefault();  // Prevent default form submission

            var form = $(this);  // Get the form element
            var formData = form.serialize();  // Serialize form data

            // Show confirmation before submitting
            if (!confirm('Yakin donasi ini selesai dicek?')) {
                return;  // If user cancels, do nothing
            }

            // Send the form data using AJAX
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                success: function(response) {
                    // Redirect or show a success message if needed
                    window.location.reload();  // Reload the page to reflect changes
                },
                error: function(xhr) {
                    // Check for error 419 (Session Expired)
                    if (xhr.status === 419) {
                        window.location.href = '/login';  // Redirect to login page
                    } else {
                        // Handle other errors
                        alert('Terjadi kesalahan. Coba lagi.');
                    }
                }
            });
        });
    });
</script>
@endsection
