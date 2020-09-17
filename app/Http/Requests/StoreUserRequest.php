<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            'lang' => [
                'required',
            ],
            'taxno' => [
                'string',
                'nullable',
            ],
            'phone_1' => [
                'string',
                'nullable',
            ],
            'phone_2' => [
                'string',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'factor_id' => [
                'required',
                'integer',
            ],
            'planes.*' => [
                'integer',
            ],
            'planes' => [
                'array',
            ],
            'license' => [
                'string',
                'nullable',
            ],
            'medical_due' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];


    }
}
