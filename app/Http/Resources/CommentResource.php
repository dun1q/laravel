<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        $isFriend = false;
        if ($request->user() && $this->user) {
            $isFriend = $this->user->friends->contains($request->user()->id);
        }
        return [
            'id' => $this->id,
            'text' => $this->text,
            'car' => new CarResource($this->car),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at,
            'is_friend' => $isFriend,
        ];
    }
}
