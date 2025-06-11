@extends('layouts.admin')

@section('content')
<div style="background: linear-gradient(135deg, #f0f4ff, #ffffff); padding: 30px; border-radius: 16px; max-width: 600px; margin: auto; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; font-weight: 600; color: #334155;">Tambah Event Baru</h2>

    <form action="{{ route('admin.events.store') }}" method="POST" style="margin-top: 25px;">
        @csrf

        <label style="display:block; font-weight:500;">Nama Event</label>
        <input type="text" name="nama" class="form-control" placeholder="Contoh: Tech Expo 2025" style="margin-bottom:15px;">

        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" style="margin-bottom:15px;">

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control" style="margin-bottom:15px;">

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control" style="margin-bottom:15px;">

        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" placeholder="Gedung Aula Universitas" style="margin-bottom:25px;">

        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi event..." style="margin-bottom:25px;"></textarea>

        <h5 class="mt-4">Daftar Tiket</h5>
<div id="ticket-section">
    <div class="ticket-group mb-3">
        <input type="text" name="tickets[0][nama]" placeholder="Nama Tiket (contoh: VIP)" class="form-control mb-2" required>
        <input type="number" name="tickets[0][stok]" placeholder="Stok" class="form-control mb-2" required>
        <input type="number" step="0.01" name="tickets[0][harga]" placeholder="Harga (contoh: 100000)" class="form-control mb-2" required>
    </div>
</div>
<button type="button" class="btn btn-sm btn-secondary" onclick="addTicket()">+ Tambah Tipe Tiket</button>

<script>
    let ticketIndex = 1;
    function addTicket() {
        const section = document.getElementById('ticket-section');
        const group = document.createElement('div');
        group.classList.add('ticket-group', 'mb-3');
        group.innerHTML = `
            <input type="text" name="tickets[${ticketIndex}][nama]" placeholder="Nama Tiket" class="form-control mb-2" required>
            <input type="number" name="tickets[${ticketIndex}][stok]" placeholder="Stok" class="form-control mb-2" required>
            <input type="number" step="0.01" name="tickets[${ticketIndex}][harga]" placeholder="Harga" class="form-control mb-2" required>
        `;
        section.appendChild(group);
        ticketIndex++;
    }
</script>


        <label for="gambar">Gambar Event:</label>
        <input type="file" name="gambar" id="gambar" accept="image/*">

        <button type="submit" style="background:#3b82f6; color:white; padding:10px 20px; border:none; border-radius:10px; font-weight:bold; cursor:pointer;">
            Tambahkan
        </button>
    </form>
</div>
@endsection
