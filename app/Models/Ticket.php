<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'nama', 
        'harga',
        'stok', 
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
