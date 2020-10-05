<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reservation_start' => $this->reservation_start,
            'reservation_stop' => $this->reservation_stop,
            'description' => $this->description,
            'status' => $this->status,
            'modus' => $this->modus,
            'instructor_needed' => $this->instructor_needed,
            'created_by_id' => $this->created_by,
            'user' => new UserResource($this->user),
            'plane' => new PlaneResource($this->plane),
//            'type' => new TypeResource($this->type),
        ];

    }
}
