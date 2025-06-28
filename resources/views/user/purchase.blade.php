@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #ffffff;
        font-family: 'Poppins', sans-serif;
    }

    .checkout-section {
        padding: 100px 0 80px 0;
        position: relative;
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .checkout-header h1 {
        font-size: 36px;
        font-weight: 700;
        color: #111;
    }

    .checkout-header p {
        font-size: 15px;
        color: #666;
        margin-top: 10px;
    }

    .checkout-container {
        max-width: 800px;
        margin: auto;
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-label {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 5px;
        color: #333;
    }

    .ticket-list {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .ticket-list li {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .total-section {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 16px;
        margin-top: 10px;
        border-top: 1px solid #ddd;
        padding-top: 15px;
    }

    .btn-checkout {
        background-color: #A28C4A;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 12px;
        border-radius: 8px;
        width: 100%;
        margin-top: 30px;
        font-size: 16px;
    }

    .btn-checkout:hover {
        background-color: #8c763f;
    }

    .checkout-footer {
        margin-top: 60px;
        text-align: center;
        font-size: 13px;
        color: #aaa;
    }


    .decor-line {
        width: 100px;
        height: 3px;
        background-color: #A28C4A;
        margin: 30px auto 10px auto;
        border-radius: 2px;
    }

    .checkout-hint {
        text-align: center;
        font-size: 14px;
        color: #999;
        margin-top: -10px;
    }
</style>

<div class="checkout-section">
    <div class="checkout-header">
        <h1>Checkout Tiket</h1>
        <div class="decor-line"></div>
        <p>Cek kembali tiket kamu sebelum lanjut ke pembayaran</p>
    </div>

    <div class="checkout-container">
        <form id="checkoutForm">
            @csrf

            <div class="info-group">
                <div class="info-label">Nama</div>
                <div>{{ auth()->user()->name }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Email</div>
                <div>{{ auth()->user()->email }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Tiket Dipilih</div>
                <ul class="ticket-list">
                    @php $total = 0; @endphp
                    @foreach ($selectedTickets as $ticket)
                        @php
                            $subtotal = $ticket->harga * $ticket->jumlah;
                            $total += $subtotal;
                        @endphp
                        <li>
                            <span>{{ $ticket->nama }} (x{{ $ticket->jumlah }})</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="total-section">
                <span>Total Harga</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            @php
                $ticketMap = collect($selectedTickets)->mapWithKeys(fn($t) => [$t->id => $t->jumlah]);
            @endphp
            <input type="hidden" id="ticketData" value='@json($ticketMap)'>

            <button type="button" class="btn-checkout" onclick="goToPayment()">Bayar Sekarang</button>
        </form>

        <div id="payment-frame" class="mt-5"></div>
    </div>

    <div class="checkout-footer">
        Transaksi Anda aman & terenkripsi · Powered by Midtrans
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
function goToPayment() {
    const tickets = JSON.parse(document.getElementById("ticketData").value);
    const token = document.querySelector('input[name="_token"]').value;

    fetch("{{ route('user.purchase.pay') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ tickets: tickets })
    })
    .then(response => {
        if (!response.ok) return response.json().then(err => Promise.reject(err));
        return response.json();
    })
    .then(data => {
        if (data.snapToken && data.order_id) {
            const orderId = data.order_id;
            snap.pay(data.snapToken, {
                onSuccess: result => checkStatusAndRedirect(result.order_id),
                onPending: result => checkStatusAndRedirect(result.order_id),
                onError: result => checkStatusAndRedirect(result.order_id),
                onClose: () => checkStatusAndRedirect(orderId)
            });
        } else {
            document.getElementById('payment-frame').innerHTML =
                `<div class='text-danger'>Gagal mendapatkan token Snap: ${data.error || 'Tidak diketahui'}</div>`;
        }
    })
    .catch(err => {
        document.getElementById('payment-frame').innerHTML =
            `<div class='text-danger'>${err.error || 'Kesalahan koneksi ke server.'}</div>`;
    });
}

function checkStatusAndRedirect(orderId) {
    if (!orderId) return;
    fetch(`/user/payment/check-status/${orderId}`)
        .then(res => res.json())
        .then(() => window.location.href = `/user/payment/detail/${orderId}`)
        .catch(() => window.location.href = `/user/payment/detail/${orderId}`);
}
</script>
@endsection
