@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #ffffff;
        font-family: 'Segoe UI', sans-serif;
    }

    .riwayat-section {
        padding-top: 80px;
        padding-bottom: 50px;
    }

    .riwayat-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .card-riwayat {
        border-left: 5px solid #5C4033;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .card-riwayat:hover {
        transform: translateY(-2px);
    }

    .badge-status {
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 6px;
    }

    .pagination {
        list-style: none;
        display: flex;
        gap: 8px;
        justify-content: center;
        padding-left: 0;
        margin-top: 20px;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination .page-link {
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        color: #5C4033;
        background-color: #f2f2f2;
        transition: background-color 0.2s;
    }

    .pagination .page-item.active .page-link {
        background-color: #5C4033;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #bbb;
        background-color: #f9f9f9;
        pointer-events: none;
    }
</style>

<div class="container riwayat-section">
    <div class="riwayat-header">
        <h2 class="fw-bold text-dark">Riwayat Transaksi</h2>
    </div>

    <div class="row" id="riwayatContainer">
        @forelse ($transactions as $transaction)
            <div class="col-md-6 mb-4 riwayat-item">
                <div class="card-riwayat p-4 h-100">
                    <h5 class="fw-bold text-dark mb-2">
                        {{ $transaction->event_name_snapshot ?? ($transaction->event->nama ?? 'Event Tidak Ditemukan') }}
                    </h5>
                    <p><strong>Lokasi:</strong> {{ $transaction->event->lokasi ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->event->tanggal ?? now())->format('d M Y') }}</p>
                    <p><strong>Waktu:</strong>
                        @if(isset($transaction->event->jam_mulai) && isset($transaction->event->jam_selesai))
                            {{ \Carbon\Carbon::parse($transaction->event->jam_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($transaction->event->jam_selesai)->format('H:i') }} WIB
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>Status:</strong>
                        @if($transaction->status === 'paid')
                            <span class="badge-status bg-success text-white">Sudah Dibayar</span>
                        @elseif($transaction->status === 'pending')
                            <span class="badge-status bg-warning text-dark">Menunggu</span>
                        @else
                            <span class="badge-status bg-danger text-white">Dibatalkan</span>
                        @endif
                    </p>
                    <a href="{{ route('user.purchase.detail', $transaction->order_id) }}" class="btn btn-outline-primary btn-sm mt-3">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada riwayat transaksi.</div>
            </div>
        @endforelse
    </div>

    <ul class="pagination" id="pagination"></ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.riwayat-item');
        const itemsPerPage = 6;
        const totalPages = Math.ceil(items.length / itemsPerPage);
        let currentPage = 1;
        const pagination = document.getElementById('pagination');

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            items.forEach((item, index) => {
                item.style.display = (index >= start && index < end) ? 'block' : 'none';
            });

            renderPagination(page);
        }

        function renderPagination(current) {
            pagination.innerHTML = '';

            function createPage(label, pageNumber, disabled = false, active = false) {
                const li = document.createElement('li');
                li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                const button = document.createElement('button');
                button.className = 'page-link';
                button.textContent = label;
                if (!disabled && pageNumber !== null) {
                    button.addEventListener('click', () => {
                        currentPage = pageNumber;
                        showPage(currentPage);
                    });
                }
                li.appendChild(button);
                return li;
            }

 
            pagination.appendChild(createPage('«', current - 1, current === 1));
            if (current === 1) {
                pagination.appendChild(createPage('1', 1, false, true));
                if (totalPages > 1) {
                    pagination.appendChild(createPage('...', null, true));
                    pagination.appendChild(createPage(totalPages, totalPages));
                }
            } else if (current === totalPages) {
                pagination.appendChild(createPage('...', null, true));
                pagination.appendChild(createPage(totalPages, totalPages, false, true));
            } else {
                pagination.appendChild(createPage('...', null, true));
                pagination.appendChild(createPage(current, current, false, true));
                pagination.appendChild(createPage('...', null, true));
                pagination.appendChild(createPage(totalPages, totalPages));
            }


            pagination.appendChild(createPage('»', current + 1, current === totalPages));
        }

        showPage(currentPage);
    });
</script>
@endsection
