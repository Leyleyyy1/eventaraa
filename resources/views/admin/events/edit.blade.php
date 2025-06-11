@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Event</h2>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $event->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $event->tanggal) }}" required>
        </div>

        <div class="mb-3">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', $event->jam_mulai) }}" required>
        </div>

        <div class="mb-3">
            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', $event->jam_selesai) }}" required>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $event->lokasi) }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $event->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
            @if($event->gambar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $event->gambar) }}" width="200" style="object-fit: cover;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.events.kelolaevent') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
