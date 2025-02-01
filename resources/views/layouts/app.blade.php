@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    @yield('dashboard-content')
@endsection

@section('adminlte_sidebar')
    @include('layouts.navbar')
@endsection

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('adminlte_js')
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
