<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewedPage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'url',
        'created_at',
    ];
}
