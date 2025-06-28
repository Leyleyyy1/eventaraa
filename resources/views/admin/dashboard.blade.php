@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background-color: #a1887f;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-calendar-event"></i> Total Event</h5>
                    <p class="card-text fs-4">{{ number_format($totalEvents) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background-color: #bcaaa4;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-receipt"></i> Total Transaksi</h5>
                    <p class="card-text fs-4">{{ number_format($totalTransactions) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background-color: #d7ccc8;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-currency-dollar"></i> Total Pendapatan</h5>
                    <p class="card-text fs-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

<!-- Chart Transaksi 7 Hari -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Grafik Transaksi (7 Hari Terakhir)</h5>
        <canvas id="chart-transaksi" height="100"></canvas>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart-transaksi').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($transactionsPerDay->keys()) !!},
                datasets: [{
                    label: 'Transaksi per Hari (7 Hari Terakhir)',
                    data: {!! json_encode($transactionsPerDay->values()) !!},
                    backgroundColor: '#4e342e',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision:0
                        }
                    }
                }
            }
        });
    </script>
@endsection

