@extends('layouts.admin')

@section('content')
<div style="background: linear-gradient(135deg, #f0f4ff, #ffffff); padding: 30px; border-radius: 16px; max-width: 600px; margin: auto; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; font-weight: 600; color: #334155;">Tambah Event Baru</h2>

    <!-- Form untuk menambahkan event -->
<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Menampilkan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Input Nama Event -->
    <label>Nama Event</label>
    <input type="text" name="nama" class="form-control" placeholder="Contoh: Tech Expo 2025" required>

    <!-- Input Tanggal -->
    <label>Tanggal</label>
    <input type="date" name="tanggal" class="form-control" required>

    <!-- Input Jam Mulai -->
    <label>Jam Mulai</label>
    <input type="time" name="jam_mulai" class="form-control" required>

    <!-- Input Jam Selesai -->
    <label>Jam Selesai</label>
    <input type="time" name="jam_selesai" class="form-control" required>

    <!-- Input Lokasi -->
    <label>Lokasi</label>
    <input type="text" name="lokasi" class="form-control" placeholder="Gedung Aula Universitas" required>

    <!-- Input Deskripsi -->
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi event..."></textarea>

    <!-- Input Tiket -->
    <h5>Daftar Tiket</h5>
    <div id="ticket-section">
        <div class="ticket-group mb-3">
            <input type="text" name="tickets[0][nama]" placeholder="Nama Tiket (contoh: VIP)" class="form-control mb-2" required>
            <input type="number" name="tickets[0][stok]" placeholder="Stok" class="form-control mb-2" required>
            <input type="number" step="0.01" name="tickets[0][harga]" placeholder="Harga (contoh: 100000)" class="form-control mb-2" required>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addTicket()">+ Tambah Tipe Tiket</button>

    <!-- Script untuk menambahkan tiket -->
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

   <!-- Input Gambar -->
    <label for="gambar">Upload Gambar</label>
    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">

    <!-- Preview Gambar -->
    <img id="preview" style="max-height: 200px; margin-top: 10px; display: none;"/>

    <script>
        document.getElementById("gambar").addEventListener("change", function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById("preview");
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>


    <button type="submit" class="btn btn-success mt-3">Simpan</button>
</form>

</div>
@endsection
