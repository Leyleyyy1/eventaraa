@extends('layouts.admin')

@section('content')
<style>
    .event-admin-wrapper {
        padding-top: 30px;
        padding-bottom: 50px;
    }

    .card-event-admin {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: 0.3s ease;
        background-color: #fffaf7;
    }

    .card-event-admin:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(0,0,0,0.1);
    }

    .event-img-admin {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-weight: 600;
        color: #4e342e;
    }

    .card-text {
        font-size: 14px;
        color: #6d4c41;
    }

    .event-actions .btn {
        border-radius: 8px;
        font-size: 13px;
        padding: 6px 12px;
    }

    .btn-detail {
        background-color: #6d4c41;
        color: #fff;
    }

    .btn-detail:hover {
        background-color: #5d4037;
    }

    .btn-edit {
        background-color: #f4a825;
        color: #fff;
    }

    .btn-edit:hover {
        background-color: #d48c00;
    }

    .btn-delete {
        background-color: #d84315;
        color: #fff;
    }

    .btn-delete:hover {
        background-color: #bf360c;
    }

    .btn-add {
        background-color: #4e342e;
        color: #fff;
    }

    .btn-add:hover {
        background-color: #3e2723;
    }
</style>

<div class="container event-admin-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Kelola Event</h3>
        <a href="{{ route('admin.events.create') }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card card-event-admin">
                    <img src="{{ $event->gambar ? asset('storage/' . $event->gambar) : asset('images/default-event.png') }}"
                         alt="{{ $event->nama }}"
                         class="event-img-admin">

                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $event->nama }}</h5>
                        <p class="card-text mb-1">
                            <i class="bi bi-calendar-event"></i> {{ $event->tanggal }}<br>
                            <i class="bi bi-clock"></i> {{ $event->jam_mulai }} - {{ $event->jam_selesai }}
                        </p>
                        <p class="card-text mb-2">
                            <i class="bi bi-geo-alt"></i> {{ $event->lokasi }}
                        </p>

                        <div class="d-flex gap-2 flex-wrap event-actions">
                            <a href="{{ route('admin.events.detail', $event->id) }}" class="btn btn-detail">Detail</a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    Tidak ada event yang tersedia.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
