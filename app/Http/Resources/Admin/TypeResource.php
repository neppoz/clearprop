<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'instructor' => $this->instructor,
            'active' => $this->active,
        ];

    }
}
