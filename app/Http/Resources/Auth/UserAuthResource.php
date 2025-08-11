<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    private $token;
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'image' => $this->image ?? env('APP_URL') . '/defaults/profile.webp',
            'profile_completed' => $this->profile_completed(),
            'token' => $this->token,
        ];
    }
}
