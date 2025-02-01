@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_body')
    <form action="{{ route('login.pharmacist') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Pharmacist Email" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-block">Login as Pharmacist</button>
    </form>
@endsection
