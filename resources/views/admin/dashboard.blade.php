@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: #795548;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person"></i> Total User</h5>
                    <p class="card-text fs-4">1,200</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: #a1887f;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-calendar-event"></i> Total Event</h5>
                    <p class="card-text fs-4">85</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: #bcaaa4;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-receipt"></i> Transaksi</h5>
                    <p class="card-text fs-4">500</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: #d7ccc8;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-bar-chart-line"></i> Laporan</h5>
                    <p class="card-text fs-4">15</p>
                </div>
            </div>
        </div>
    </div>
@endsection
