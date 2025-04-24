@extends('adminlte::auth.login')

@section('auth_body')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @parent
@endsection
