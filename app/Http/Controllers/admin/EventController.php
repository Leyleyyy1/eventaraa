<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('tickets')->latest()->get();
        return view('admin.events.kelolaevent', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
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

        $gambarPath = $request->hasFile('gambar') ? $request->file('gambar')->store('gambar-event', 'public') : null;

        $event = Event::create([
            'admin_id' => auth()->id(),
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        foreach ($request->tickets as $ticket) {
            $event->tickets()->create($ticket);
        }

        return redirect()->route('admin.events.kelolaevent')->with('success', 'Event dan tiket berhasil ditambahkan.');
    }

    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('admin.events.detail', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tickets' => 'required|array|min:1',
            'tickets.*.nama' => 'required|string|max:255',
            'tickets.*.stok' => 'required|integer|min:1',
            'tickets.*.harga' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            if ($event->gambar) {
                Storage::disk('public')->delete($event->gambar);
            }
            $event->gambar = $request->file('gambar')->store('gambar-event', 'public');
        }

        $event->update([
            'nama' => $validated['nama'],
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $event->gambar,
        ]);

        $event->tickets()->delete();

        foreach ($request->tickets as $ticket) {
            $event->tickets()->create($ticket);
        }

        return redirect()->route('admin.events.kelolaevent')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->gambar) {
            Storage::disk('public')->delete($event->gambar);
        }

        $event->delete();

        return redirect()->route('admin.events.kelolaevent')->with('success', 'Event berhasil diarsipkan.');
    }
}
