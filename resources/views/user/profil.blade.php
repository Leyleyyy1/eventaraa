@extends('layouts.app')

@section('content')
<style>
    .profil-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background-color: #f1f5f9; 
        font-family: 'Poppins', sans-serif;
    }

    .profil-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 500px;
        text-align: center;
    }

    .profil-icon {
        font-size: 60px;
        color: #6b7280; 
        margin-bottom: 20px;
    }

    .profil-title {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 24px;
    }

    .profil-info p {
        font-size: 16px;
        color: #374151;
        margin-bottom: 12px;
    }

    .profil-info strong {
        color: #111827;
    }
</style>

<div class="profil-wrapper">
    <div class="profil-card">
        <div class="profil-icon">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="profil-title">Profil Pengguna</div>
        <div class="profil-info">
            <p><strong>Nama Lengkap:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Tanggal Daftar:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
