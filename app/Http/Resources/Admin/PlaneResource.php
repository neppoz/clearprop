<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaneResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          'callsign' => $this->callsign,
          'vendor' => $this->vendor,
          'model' => $this->model,
          'active' => $this->active,
        ];
//        return parent::toArray($request);

    }
}
