<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    //$fillable memberi tahu Laravel kolom mana yang boleh diisi saat kita membuat data.
    protected $fillable = [
        'company',
        'position',
        'status',
        'applied_at',
        'notes',
    ];
}