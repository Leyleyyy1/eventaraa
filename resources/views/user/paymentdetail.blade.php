@extends('layouts.app')

@section('content')
<style>
    .payment-wrapper {
        padding: 100px 0 60px 0;
        position: relative;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: #111;
        margin-bottom: 30px;
        border-left: 6px solid #A28C4A;
        padding-left: 15px;
    }

    .back-btn-wrapper {
        position: absolute;
        top: 90px;
        right: 0;
    }

    .left-panel, .right-panel {
        background-color: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .info-item {
        margin-bottom: 18px;
    }

    .info-item strong {
        color: #444;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-paid {
        background-color: #2e7d32;
        color: white;
    }

    .badge-pending {
        background-color: #ffc107;
        color: #333;
    }

    .badge-cancelled {
        background-color: #dc3545;
        color: white;
    }

    .btn-custom {
        background-color: #A28C4A;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
    }

    .btn-custom:hover {
        background-color: #8c773d;
    }

    .btn-secondary {
        border-radius: 8px;
    }

    .alert-info {
        background-color: #fefbea;
        border-color: #fff2c6;
        color: #5f5200;
    }

    .qr-img {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .event-img {
        width: 100%;
        max-height: 250px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .left-panel, .right-panel {
            margin-bottom: 20px;
        }
        .back-btn-wrapper {
            position: static;
            text-align: right;
            margin-bottom: 20px;
        }
    }
</style>

<div class="container payment-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="section-title mb-0">Detail Transaksi Tiket</div>
        <div class="back-btn-wrapper">
            <a href="{{ route('user.user.riwayat') }}" class="btn btn-secondary">← Kembali ke Riwayat</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-7">
            <div class="left-panel">
                <div class="info-item"><strong>Order ID:</strong><br> {{ $transaction->order_id }}</div>
                <div class="info-item"><strong>Nama Tiket:</strong><br> {{ $transaction->ticket_name_snapshot ?? ($transaction->ticket->nama ?? '-') }}</div>
                <div class="info-item"><strong>Jumlah Tiket:</strong><br> {{ $transaction->quantity }}</div>
                <div class="info-item"><strong>Total Bayar:</strong><br> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                <div class="info-item"><strong>Status Pembayaran:</strong><br>
                    @if($transaction->status === 'paid')
                        <span class="badge-status badge-paid">Sudah Dibayar</span>
                    @elseif($transaction->status === 'pending')
                        <span class="badge-status badge-pending">Menunggu Pembayaran</span>
                    @else
                        <span class="badge-status badge-cancelled">Dibatalkan</span>
                    @endif
                </div>
                <div class="info-item"><strong>Metode Pembayaran:</strong><br> {{ ucfirst($transaction->payment_method ?? '-') }}</div>

                @php $event = $transaction->event; @endphp
                @if($event)
                    <hr class="my-4">
                    <div class="info-item"><strong>Nama Event:</strong><br> {{ $transaction->event_name_snapshot ?? $event->nama }}</div>
                    @if($event->gambar)
                        <div class="info-item">
                            <img src="{{ asset('storage/' . $event->gambar) }}" class="event-img" alt="Event Image">
                        </div>
                    @endif
                    <div class="info-item"><strong>Tanggal:</strong><br> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</div>
                    <div class="info-item"><strong>Waktu:</strong><br> {{ $event->jam_mulai }} - {{ $event->jam_selesai }}</div>
                    <div class="info-item"><strong>Lokasi:</strong><br> {{ $event->lokasi }}</div>
                @endif
            </div>
        </div>

        <div class="col-md-5">
            <div class="right-panel">
                <h5 class="mb-3 fw-bold text-uppercase">Informasi Pembayaran</h5>

                @php
                    $info = is_array($transaction->payment_info)
                        ? $transaction->payment_info
                        : json_decode($transaction->payment_info, true);
                @endphp

                @if(is_array($info))
                    @if(isset($info['bank']))
                        <div class="info-item"><strong>Bank:</strong><br> {{ strtoupper($info['bank']) }}</div>
                    @endif
                    @if(isset($info['va_number']))
                        <div class="info-item"><strong>Virtual Account:</strong><br> {{ $info['va_number'] }}</div>
                    @endif
                    @if(isset($info['bill_key']))
                        <div class="info-item"><strong>Bill Key:</strong><br> {{ $info['bill_key'] }}</div>
                    @endif
                    @if(isset($info['biller_code']))
                        <div class="info-item"><strong>Biller Code:</strong><br> {{ $info['biller_code'] }}</div>
                    @endif
                    @if(isset($info['qr_url']))
                        <div class="info-item"><strong>QR Code:</strong><br>
                            <img src="{{ $info['qr_url'] }}" alt="QRIS" width="200" class="qr-img mt-2">
                        </div>
                    @endif
                @endif

                @if($transaction->status === 'pending')
                    <div class="alert alert-info mt-4">
                        <strong>Segera lakukan pembayaran!</strong><br>
                        Waktu tersisa: <span id="countdown">15:00</span><br>
                        <small>Jika waktu habis, transaksi akan dibatalkan otomatis.</small>
                    </div>

                    <form method="GET" action="{{ route('user.purchase.checkstatus', $transaction->order_id) }}">
                        <button type="submit" class="btn btn-custom w-100 mt-2">Cek Status Pembayaran</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@if($transaction->status === 'pending')
<script>
    let countdown = 15 * 60;
    const countdownElement = document.getElementById('countdown');
    const interval = setInterval(() => {
        const minutes = Math.floor(countdown / 60);
        const seconds = countdown % 60;
        countdownElement.textContent =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        if (countdown <= 0) {
            clearInterval(interval);
            countdownElement.textContent = "00:00";
        }
        countdown--;
    }, 1000);
</script>
@endif
@endsection
