@extends('layouts.app')

@section('content')
<style>
    .event-wrapper {
        padding: 120px 0 50px 0;
    }
    .event-title {
        font-weight: 700;
        font-size: 32px;
        margin-bottom: 20px;
    }
    .event-img {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .event-meta {
        font-size: 15px;
        color: #666;
        margin-top: 5px;
    }
    .detail-box {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 0 10px rgba(0,0,0,0.06);
        margin-top: 50px;
    }
    .detail-box h5 {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .ticket-card {
        border: 1px solid #e0e0e0;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .ticket-title {
        font-weight: 700;
        font-size: 16px;
    }
    .ticket-desc {
        font-size: 14px;
        color: #555;
        margin-top: 5px;
    }
    .ticket-price {
        font-weight: bold;
        color: green;
        margin-top: 12px;
    }
    .btn-beli {
        background: linear-gradient(to right, #A28C4A, #A28C4A);
        border: none;
        padding: 10px 24px;
        border-radius: 30px;
        color: white;
        font-weight: bold;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        transition: 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
    }
    .btn-beli:hover {
        opacity: 0.95;
    }
    .detail-icon {
        margin-right: 8px;
        color: #f9a825;
    }
</style>

<div class="container event-wrapper">
    <div class="row">
        <div class="col-md-8">
            <h2 class="event-title">{{ $event->nama }}</h2>

            <img class="event-img mb-3" src="{{ $event->gambar ? asset('storage/' . $event->gambar) : asset('images/default-event.png') }}" alt="Event Image">

            <div class="event-meta mt-2">
                <i class="bi bi-person detail-icon"></i> Penyelenggara
            </div>
            <div class="event-meta mb-3"><strong>{{ $event->admin->organization ?? '-' }}</strong></div>

            <div>
                <p style="font-size: 15px; color: #333;">{{ $event->deskripsi }}</p>
            </div>

            <div class="mt-4">
                @foreach($tickets as $ticket)
                    <div class="ticket-card" id="beli">
                        <div class="ticket-title">{{ strtoupper($ticket->nama) }}</div>
                        <div class="ticket-desc">{{ $ticket->deskripsi }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="ticket-price">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="detail-box">
                <h5>Detail Event</h5>
                <p>
                    <i class="bi bi-calendar-event detail-icon"></i>
                    <strong>Tanggal</strong><br>{{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                </p>
                <p>
                    <i class="bi bi-clock detail-icon"></i>
                    <strong>Waktu</strong><br>{{ $event->jam_mulai }} - {{ $event->jam_selesai }} WIB
                </p>
                <p>
                    <i class="bi bi-geo-alt detail-icon"></i>
                    <strong>Lokasi</strong><br>{{ $event->lokasi }}
                </p>
                <a href="{{ route('user.tickets.select', $event->id) }}" class="btn btn-beli w-100 mt-3">Beli Tiket Sekarang</a>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endsection
