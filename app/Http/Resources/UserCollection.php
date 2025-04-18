<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($user) {
                return new UserResource($user); // Usar UserResource para transformar cada usuario
            }),
            'links' => [
                'self' => 'link-value', // Esto es opcional, puedes generarlo si necesitas
            ],
        ];
    }
}
