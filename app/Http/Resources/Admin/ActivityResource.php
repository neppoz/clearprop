<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'counter_start'=> $this->counter_start,
            'counter_stop'=> $this->counter_stop,
            'minutes'=> $this->minutes,
            'amount'=> $this->amount,
            'departure'=> $this->departure,
            'arrival'=> $this->arrival,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'user' => new UserResource($this->user),
            'plane' => new PlaneResource($this->plane),
            'type' => new TypeResource($this->type),
        ];

    }
}

