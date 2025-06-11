@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Kelola Event</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Tambah Event</a>
    </div>

    <div class="row">
        @forelse($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($event->gambar)
                        <img src="{{ asset('storage/' . $event->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-event.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->nama }}</h5>
                        <p class="card-text">{{ $event->tanggal }} | {{ $event->jam_mulai }} - {{ $event->jam_selesai }}</p>
                        <p class="card-text">{{ $event->lokasi }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.events.detail', $event->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?')" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada event yang tersedia.</p>
        @endforelse
    </div>
</div>
@endsection
