<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'nama', // Ubah dari nama_tiket ke nama
        'harga',
        'stok', // Ubah dari kuota ke stok
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
