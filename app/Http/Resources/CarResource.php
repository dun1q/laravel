<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'year'  => $this->year,
            'price' => $this->price,
            'mileage_km' => $this->mileage_km,
            'user'  => $this->user ? $this->user->name : null,
        ];
    }
}