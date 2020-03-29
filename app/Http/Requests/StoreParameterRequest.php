<?php

namespace App\Http\Requests;

use App\Parameter;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreParameterRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('parameter_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'slug' => [
                'required',
                'unique:parameters'],
        ];

    }
}
