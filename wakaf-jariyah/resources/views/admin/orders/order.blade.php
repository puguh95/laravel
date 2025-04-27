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

        .is-invalid~.invalid-feedback {
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
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form
                                action="{{ action([App\Http\Controllers\OrderController::class, 'indexAdmin'], ['page' => request('page')]) }}"
                                method="GET" class="input-group">
                                <div style="width: 70px;">
                                    <select name="data_per_page" class="form-control">
                                        <option value="25" {{ request('data_per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('data_per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('data_per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                        <option value="250" {{ request('data_per_page') == 250 ? 'selected' : '' }}>250
                                        </option>
                                    </select>
                                </div>
                                <input type="text" name="search" placeholder="Cari berdasarkan no donasi, email, atau phone" value="{{ request('search') }}"
                                    class="form-control">
                                <span class="input-group-btn">
                                    <button type="sumbit" class="btn btn-default" type="button">Search</button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
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
                        @if ($paginate['data']->isEmpty())
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
                                    @foreach ($paginate['data'] as $order)
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
                                                <span
                                                    class="badge {{ $order->status_id == '1' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($order->status_id) == '1' ? 'Success' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->status == 'success' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at ? formatEpochFromTimestamp($order->created_at) : '-' }}
                                            </td>
                                            {{-- <td>{{ $order->checked_at ? formatEpoch($order->checked_at) : '-' }}</td> --}}
                                            <td>{{ $order->checked_by ?? '-' }}</td>
                                            <td>
                                                @if ($order->status === 'checking')
                                                    <form id="checked"
                                                        action="{{ route('orders.updateStatus', $order->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success mt-1">Check
                                                            Donation</button>
                                                    </form>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- Paginate --}}
                            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 12px;">
                                <div
                                    style="display: flex; gap: 4px; align-items: center; font-weight: 500; color: #1e293b;">
                                    <a href="{{ $paginate['first_page'] }}"
                                        style="margin-right: 12px; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.25)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <svg style="stroke: #64748b;" onmouseover="this.style.stroke='#f97316'"
                                            onmouseout="this.style.stroke='#64748b'" width="20px" height="20px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19 19L12.7071 12.7071C12.3166 12.3166 12.3166 11.6834 12.7071 11.2929L19 5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M11 19L4.70711 12.7071C4.31658 12.3166 4.31658 11.6834 4.70711 11.2929L11 5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <a href="{{ $paginate['previous_page'] }}"
                                        style="margin-right: 12px; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.25)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <svg style="stroke: #64748b;" onmouseover="this.style.stroke='#f97316'"
                                            onmouseout="this.style.stroke='#64748b'" width="20px" height="20px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.5 19L9.20711 12.7071C8.81658 12.3166 8.81658 11.6834 9.20711 11.2929L15.5 5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>

                                    @foreach ($paginate['links'] as $item)
                                        <a href="{{ $item['url'] }}"
                                            style="min-width: 3ch; padding: 4px 8px; border-radius: 4px; text-align: center; {{ $item['selected'] ? 'background-color: #3b82f6; color: white;' : 'transition: background-color 0.2s, color 0.2s;' }}"
                                            onmouseover="{{ $item['selected'] ? '' : "this.style.backgroundColor='#3b82f6';this.style.color='white';" }}"
                                            onmouseout="{{ $item['selected'] ? '' : "this.style.backgroundColor='';this.style.color='';" }}">
                                            {{ $item['page'] }}
                                        </a>

                                        @if ($loop->index == 3 && $item['page'] != $paginate['max_page'])
                                            <p style="padding: 0 4px;">. . .</p>
                                            <a href="{{ $paginate['last_page'] }}"
                                                style="min-width: 3ch; padding: 4px 8px; border-radius: 4px; text-align: center; transition: background-color 0.2s, color 0.2s;"
                                                onmouseover="this.style.backgroundColor='#3b82f6';this.style.color='white';"
                                                onmouseout="this.style.backgroundColor='';this.style.color='';">
                                                {{ $paginate['max_page'] }}
                                            </a>
                                            @break
                                        @endif
                                    @endforeach

                                    <a href="{{ $paginate['next_page'] }}"
                                        style="margin-left: 12px; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.25)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <svg style="stroke: #64748b;" onmouseover="this.style.stroke='#f97316'"
                                            onmouseout="this.style.stroke='#64748b'" width="20px" height="20px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.5 5L15.7929 11.2929C16.1834 11.6834 16.1834 12.3166 15.7929 12.7071L9.5 19"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <a href="{{ $paginate['last_page'] }}"
                                        style="margin-left: 12px; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.25)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <svg style="stroke: #64748b;" onmouseover="this.style.stroke='#f97316'"
                                            onmouseout="this.style.stroke='#64748b'" width="20px" height="20px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.5 5L11.7929 11.2929C12.1834 11.6834 12.1834 12.3166 11.7929 12.7071L5.5 19"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M13.5 5L19.7929 11.2929C20.1834 11.6834 20.1834 12.3166 19.7929 12.7071L13.5 19"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>

                                <p style="font-size: 14px; font-weight: 500; color: #64748b; margin-top: 4px;">
                                    {{ $paginate['result_text'] }}
                                </p>
                            </div>
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
            $('form #checked').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                var form = $(this); // Get the form element
                var formData = form.serialize(); // Serialize form data

                // Show confirmation before submitting
                if (!confirm('Yakin donasi ini selesai dicek?')) {
                    return; // If user cancels, do nothing
                }

                // Send the form data using AJAX
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    success: function(response) {
                        // Redirect or show a success message if needed
                        window.location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr) {
                        // Check for error 419 (Session Expired)
                        if (xhr.status === 419) {
                            window.location.href = '/login'; // Redirect to login page
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
