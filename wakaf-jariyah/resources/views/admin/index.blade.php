@extends('adminlte::page')

@section('title', 'Halaman Dashboard')

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

@section('adminlte_js')
@parent
<script></script>
@endsection
