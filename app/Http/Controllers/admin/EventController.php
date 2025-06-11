<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Menampilkan semua event
    public function index()
    {
        $events = Event::with('tickets')->latest()->get();
        return view('admin.events.kelolaevent', compact('events'));
    }

    // Menampilkan form untuk membuat event baru
    public function create()
    {
        return view('admin.events.create');
    }

    // Menyimpan event baru ke database
public function store(Request $request)
{
    // Debug data yang diterima dari form

    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
        'lokasi' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|max:2048',
        'tickets' => 'required|array|min:1',
        'tickets.*.nama' => 'required|string|max:255',
        'tickets.*.stok' => 'required|integer|min:1',
        'tickets.*.harga' => 'required|numeric|min:0',
    ]);

    // Upload gambar
    $gambarPath = null;
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('gambar-event', 'public');
    }

    // Simpan event
    $event = Event::create([
        'admin_id' => auth()->id(), // Pastikan admin_id diisi
        'nama' => $request->nama,
        'tanggal' => $request->tanggal,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'lokasi' => $request->lokasi,
        'deskripsi' => $request->deskripsi,
        'gambar' => $gambarPath,
    ]);



    // Simpan tiket
    foreach ($request->tickets as $ticket) {
        $event->tickets()->create([
            'nama' => $ticket['nama'],
            'stok' => $ticket['stok'],
            'harga' => $ticket['harga'],
        ]);
    }


    return redirect()->route('admin.events.kelolaevent')->with('success', 'Event dan tiket berhasil ditambahkan.');
}



    // Menampilkan detail event
    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('admin.events.detail', compact('event'));
    }

    // Menampilkan form untuk mengedit event
    public function edit($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // Memperbarui event di database
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tickets.*.nama' => 'required|string|max:255',
            'tickets.*.stok' => 'required|integer|min:1',
            'tickets.*.harga' => 'required|numeric|min:0',
        ]);

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            if ($event->gambar) {
                Storage::disk('public')->delete($event->gambar);
            }
            $gambarPath = $request->file('gambar')->store('gambar-event', 'public');
            $event->gambar = $gambarPath;
        }

        // Update event
        $event->update([
            'nama' => $validated['nama'],
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        // Hapus tiket lama dan simpan tiket baru
        $event->tickets()->delete();
        foreach ($request->tickets as $ticketData) {
            $event->tickets()->create([
                'nama' => $ticketData['nama'],
                'stok' => $ticketData['stok'],
                'harga' => $ticketData['harga'],
            ]);
        }

        return redirect()->route('admin.events.kelolaevent')->with('success', 'Event berhasil diperbarui.');
    }

    // Menghapus event (soft delete)
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete(); // Soft delete

        return redirect()->route('admin.events.kelolaevent')->with('success', 'Event berhasil diarsipkan.');
    }
}
