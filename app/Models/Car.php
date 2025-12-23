<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;

class Car extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'year',
        'price',
        'mileage_km',
        'image_path',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'year' => 'integer',
        'price' => 'decimal:2',
        'mileage_km' => 'integer',
    ];

    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value) : null,
        );
    }
}