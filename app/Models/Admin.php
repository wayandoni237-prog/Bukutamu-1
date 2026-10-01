<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Tambahkan ini agar data bisa masuk
    protected $fillable = ['name', 'username', 'password'];
}