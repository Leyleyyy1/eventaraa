@extends('layouts.app')

@section('content')
<style>
    .tickets-page {
        padding: 130px 0 50px 0;
    }

    .ticket-card {
        border: 1px solid #e0e0e0;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .ticket-name {
        font-weight: 700;
        font-size: 17px;
        color: #333;
    }

    .ticket-price {
        font-size: 15px;
        font-weight: bold;
        color: #2e7d32;
    }

    .ticket-desc {
        font-size: 13px;
        color: #555;
        margin-top: 8px;
    }

    .btn-habis {
        background-color: #ddd;
        color: #777;
        font-weight: bold;
        border: none;
        padding: 5px 15px;
        border-radius: 8px;
    }

    .btn-tambah {
        color: #A28C4A;
        border: 1px solid #A28C4A;
        background: white;
        padding: 4px 12px;
        font-weight: 600;
        border-radius: 8px;
    }

    .right-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .checkout-btn {
        background-color: #A28C4A;
        color: white;
        font-weight: bold;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        font-size: 15px;
    }

    .checkout-btn:hover {
        background-color: #8d793d;
    }

    .quantity-box {
        display: flex;
        align-items: center;
    }

    .quantity-box button {
        border: 1px solid #aaa;
        background: white;
        font-weight: bold;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    .quantity-box input {
        width: 50px;
        text-align: center;
        border: none;
        font-weight: bold;
        background: transparent;
    }
    .quantity-box button:disabled {
    background-color: #eee;
    color: #aaa;
    cursor: not-allowed;
}


    hr.styled {
        border: 0;
        height: 3px;
        background: linear-gradient(to right, #A28C4A, #d6bd72);
        width: 80px;
        margin: 0 auto 20px;
        border-radius: 2px;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-weight: 800;
        color: #211c0f;
    }

    .section-header p {
        font-size: 15px;
        color: #555;
    }

</style>

<div class="container tickets-page">
    <div class="section-header">
        <h2>Kategori Tiket</h2>
        <p>Pilih jenis tiket sesuai kebutuhanmu </p>
        <hr class="styled">
    </div>

    <form id="checkoutForm" action="{{ route('user.checkout') }}" method="GET">
        @csrf
        <div class="row">

            <div class="col-md-8">
                @foreach($event->tickets as $ticket)
                    <div class="ticket-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="ticket-name">{{ $ticket->nama }}</div>
                                <div class="ticket-price">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</div>
                                <div class="text-muted" style="font-size:13px;">
                                    Stok: <strong>{{ $ticket->stok }}</strong>
                                </div>
                            </div>
                            @if($ticket->stok == 0)
                                <button type="button" class="btn btn-habis" disabled>Habis</button>
                            @else
                            <div>
                                <div class="quantity-box">
                                    <button type="button" onclick="decreaseQty({{ $ticket->id }})" id="btn-minus-{{ $ticket->id }}">−</button>
                                    <input type="number" name="tickets[{{ $ticket->id }}]" id="ticket-{{ $ticket->id }}" value="0" readonly>
                                    <button type="button" onclick="increaseQty({{ $ticket->id }})" id="btn-plus-{{ $ticket->id }}">+</button>
                                </div>
                                <div id="warning-{{ $ticket->id }}" style="color: red; font-size: 12px; margin-top: 5px; display: none;">
                                    Tidak dapat melebihi stok.
                                </div>
                            </div>

                            @endif
                        </div>
                        @if($ticket->deskripsi)
                            <div class="ticket-desc">{{ $ticket->deskripsi }}</div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="right-card mt-2">
                    <h6 class="fw-bold mb-3">Detail Pesanan</h6>
                    <img src="{{ $event->gambar ? asset('storage/' . $event->gambar) : asset('images/default-event.png') }}" class="img-fluid mb-2 rounded" style="height: 120px; object-fit: cover;">

                    <div class="fw-bold">{{ $event->nama }}</div>
                    <div class="text-muted" style="font-size: 13px;">{{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}</div>
                    <div class="text-muted" style="font-size: 13px;">{{ $event->lokasi }}</div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span><strong>Total</strong></span>
                        <span id="totalAmount" class="fw-bold">Rp 0</span>
                    </div>

                    <button type="submit" class="checkout-btn mt-3">Checkout</button>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-5 p-4 rounded text-center" style="background-color: #fef9ed; border-left: 4px solid #A28C4A;">
        <strong>Catatan:</strong> Pastikan detail tiket sudah sesuai. Tiket yang telah dibeli tidak dapat ditukar atau dikembalikan.
    </div>

</div>

<script>
    const ticketData = @json($event->tickets);

    function increaseQty(id) {
        const input = document.getElementById('ticket-' + id);
        const plusBtn = document.getElementById('btn-plus-' + id);
        const warning = document.getElementById('warning-' + id);
        const ticket = ticketData.find(t => t.id === id);

        let currentQty = parseInt(input.value);

        if (currentQty < ticket.stok) {
            input.value = currentQty + 1;
            updateTotal();
            warning.style.display = 'none';
        }

        if (parseInt(input.value) >= ticket.stok) {
            plusBtn.disabled = true;
            plusBtn.style.opacity = 0.5;
            warning.style.display = 'block';
        }
    }

        function decreaseQty(id) {
            const input = document.getElementById('ticket-' + id);
            const plusBtn = document.getElementById('btn-plus-' + id);
            const warning = document.getElementById('warning-' + id);

            let currentQty = parseInt(input.value);

            if (currentQty > 0) {
                input.value = currentQty - 1;
                updateTotal();
            }

            if (parseInt(input.value) < ticketData.find(t => t.id === id).stok) {
                plusBtn.disabled = false;
                plusBtn.style.opacity = 1;
                warning.style.display = 'none';
            }
        }

function decreaseQty(id) {
    const input = document.getElementById('ticket-' + id);
    const plusBtn = document.getElementById('btn-plus-' + id);
    const warning = document.getElementById('warning-' + id);

    let currentQty = parseInt(input.value);

    if (currentQty > 0) {
        input.value = currentQty - 1;
        updateTotal();
    }

    if (parseInt(input.value) < ticketData.find(t => t.id === id).stok) {
        plusBtn.disabled = false;
        plusBtn.style.opacity = 1;
        warning.style.display = 'none';
    }
}

    function updateTotal() {
        let total = 0;
        ticketData.forEach(ticket => {
            const qty = parseInt(document.getElementById('ticket-' + ticket.id).value);
            total += qty * ticket.harga;
        });
        document.getElementById('totalAmount').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection
