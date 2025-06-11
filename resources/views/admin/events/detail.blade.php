@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Detail Event</h2>

    <div class="card">
        @if($event->gambar)
            <img src="{{ asset('storage/' . $event->gambar) }}" class="card-img-top" style="height: 300px; object-fit: cover;">
        @endif
        <div class="card-body">
            <h4>{{ $event->nama }}</h4>
            <p><strong>Tanggal:</strong> {{ $event->tanggal }}</p>
            <p><strong>Jam:</strong> {{ $event->jam_mulai }} - {{ $event->jam_selesai }}</p>
            <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
            <p><strong>Deskripsi:</strong><br>{{ $event->deskripsi }}</p>
            <a href="{{ route('admin.events.kelolaevent') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
