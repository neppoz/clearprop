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

//        ''=> $this->
//        ''=> $this->
        ];
//        return parent::toArray($request);

    }
}


//            "event_start": null,
//            "event_stop": null,
//            "engine_warmup": 0,
//            "warmup_start": null,
//            "counter_start": 802.65,
//            "counter_stop": 803.9,
//            "warmup_minutes": null,
//            "rate": 1.1,
//            "minutes": 75,
//            "amount": 82.5,
//            "departure": "Quarto Assia",
//            "arrival": "Gianmarco terme",
//            "split_cost": 0,

//            "description": "Aut nihil neque accusantium quaerat aut non dolorum.",
//            "created_at": "2020-06-10T12:44:37.000000Z",
//            "updated_at": "2020-06-10T12:44:37.000000Z",
//            "deleted_at": null,
//            "user_id": 29,
//            "plane_id": 1,
//            "type_id": 2,
//            "copilot_id": null,
//            "instructor_id": null,
//            "created_by_id": 29,
//            "user": {
//    "id": 29,
//                "name": "Instructor",
//                "email": "instructor@example.com",
//                "email_verified_at": null,
//                "privacy_confirmed_at": null,
//                "instructor": 1,
//                "medical_due": "09.06.2021",
//                "license": "Cum eveniet cum mag",
//                "lang": "IT",
//                "taxno": "PORRO REM IN CUPIDIT",
//                "phone_1": "+1 (532) 482-5935",
//                "phone_2": "+1 (739) 129-1328",
//                "address": "Esse sint ea natus",
//                "city": "Cernusco sul naviglio",
//                "params": null,
//                "created_at": "2020-06-10T12:44:36.000000Z",
//                "updated_at": "2020-08-24T10:13:24.000000Z",
//                "deleted_at": null,
//                "factor_id": 1
//            },
//            "copilot": null,
//            "instructor": null,
//            "plane": {
//    "id": 1,
//                "callsign": "I-C001",
//                "vendor": "ICP",
//                "model": "Savannah S",
//                "prodno": null,
//                "counter_type": "060",
//                "warmup_type": 1,
//                "warump_type": 0,
//                "active": 1,
//                "created_at": "2020-06-10T12:44:29.000000Z",
//                "updated_at": "2020-07-10T06:29:48.000000Z",
//                "deleted_at": null
//            },
//            "type": {
//    "id": 2,
//                "name": "Volo trasferta",
//                "description": null,
//                "active": 1,
//                "instructor": 0,
//                "created_at": "2020-06-10T12:44:29.000000Z",
//                "updated_at": "2020-06-10T12:44:29.000000Z",
//                "deleted_at": null
//            },
//            "created_by": {
//    "id": 29,
//                "name": "Instructor",
//                "email": "instructor@example.com",
//                "email_verified_at": null,
//                "privacy_confirmed_at": null,
//                "instructor": 1,
//                "medical_due": "09.06.2021",
//                "license": "Cum eveniet cum mag",
//                "lang": "IT",
//                "taxno": "PORRO REM IN CUPIDIT",
//                "phone_1": "+1 (532) 482-5935",
//                "phone_2": "+1 (739) 129-1328",
//                "address": "Esse sint ea natus",
//                "city": "Cernusco sul naviglio",
//                "params": null,
//                "created_at": "2020-06-10T12:44:36.000000Z",
//                "updated_at": "2020-08-24T10:13:24.000000Z",
//                "deleted_at": null,
//                "factor_id": 1
//            }
//        },
