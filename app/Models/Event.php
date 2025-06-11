<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'nama',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'deskripsi',
        'gambar', // Tambahkan kolom gambar
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
