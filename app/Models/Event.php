<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Tambahkan ini

class Event extends Model
{
    use HasFactory, SoftDeletes; // <-- Tambahkan SoftDeletes di sini

    protected $fillable = [
        'admin_id',
        'nama',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'deskripsi',
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
