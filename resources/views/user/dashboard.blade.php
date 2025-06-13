@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
        <p>Ini adalah dashboard user setelah login dengan Google.</p>
    </div>
@endsection
