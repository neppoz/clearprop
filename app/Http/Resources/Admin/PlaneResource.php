<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaneResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'callsign' => $this->callsign,
            'vendor' => $this->vendor,
            'model' => $this->model,
            'active' => $this->active,
        ];

    }
}
