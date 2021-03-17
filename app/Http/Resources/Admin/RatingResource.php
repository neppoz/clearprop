<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray($request)
    {

//        return response()->json([
//            'ratingCheckPassed' => $ratingCheckPassed ?? 'false',
//            'medicalCheckPassed' => $medicalCheckPassed ?? 'false',
//            'balanceCheckPassed' => $balanceCheckPassed ?? 'false',
//            'activityCheckPassed' => $activityCheckPassed ?? 'false'
//        ]);

        return $request;
//        return parent::toJson($request);

    }
}
