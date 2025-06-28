@extends('layouts.admin')

@section('content')
<style>
    .transaksi-wrapper {
        padding: 40px 20px;
        font-family: 'Poppins', sans-serif;
    }

    .transaksi-title {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 30px;
    }

    .table-transaksi {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table thead {
        background-color: #f1f5f9;
        color: #1f2937;
        font-weight: 500;
    }

    .table td, .table th {
        vertical-align: middle;
        font-size: 14px;
        color: #374151;
    }

    .badge {
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    .badge.bg-success {
        background-color: #10b981;
        color: #ffffff;
    }

    .badge.bg-warning {
        background-color: #facc15;
        color: #1f2937;
    }

    .badge.bg-danger {
        background-color: #ef4444;
        color: #ffffff;
    }

    .text-center {
        color: #6b7280;
    }

    .pagination {
        list-style: none;
        display: flex;
        gap: 8px;
        justify-content: center;
        padding-left: 0;
        margin-top: 25px;
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

<div class="transaksi-wrapper">
    <h1 class="transaksi-title">Daftar Transaksi</h1>

    <div class="table-responsive table-transaksi">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Event</th>
                    <th>Tiket</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody id="transactionTable">
                @forelse($transactions as $key => $transaction)
                    <tr class="transaction-row">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $transaction->user->name ?? '-' }}</td>
                        <td>{{ $transaction->event->nama ?? '-' }}</td>
                        <td>{{ $transaction->ticket->nama ?? '-' }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($transaction->status === 'paid')
                                <span class="badge bg-success">Dibayar</span>
                            @elseif($transaction->status === 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <ul class="pagination" id="pagination"></ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.transaction-row');
        const rowsPerPage = 10;
        const pagination = document.getElementById('pagination');
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? 'table-row' : 'none';
            });

            renderPagination(page);
        }

        function renderPagination(current) {
            pagination.innerHTML = '';

            function createPage(label, pageNumber, disabled = false, active = false) {
                const li = document.createElement('li');
                li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                const btn = document.createElement('button');
                btn.className = 'page-link';
                btn.textContent = label;
                if (!disabled && pageNumber !== null) {
                    btn.addEventListener('click', () => {
                        currentPage = pageNumber;
                        showPage(currentPage);
                    });
                }
                li.appendChild(btn);
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
