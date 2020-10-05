<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'granTotal' => $this->granTotal,
            'incomeAmountTotal' => $this->incomeAmountTotal,
//            'activityAmountTotal'
//            'activityHoursAndMinutes'
        ];

    }
}

