<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'year',
        'price',
        'mileage_km',
        'image_path',
    ];

    protected $casts = [
        'year' => 'integer',
        'price' => 'decimal:2',
        'mileage_km' => 'integer',
    ];
}