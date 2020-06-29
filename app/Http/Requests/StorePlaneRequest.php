<?php

namespace App\Http\Requests;

use App\Plane;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePlaneRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plane_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'callsign'     => [
                'required',
            ],
            'vendor'       => [
                'required',
            ],
            'counter_type' => [
                'required',
            ],
        ];
    }
}
