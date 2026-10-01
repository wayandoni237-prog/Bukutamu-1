<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    // Kolom yang boleh diisi
    protected $fillable = ['user_id', 'pesan'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}