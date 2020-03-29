<?php

namespace App\Http\Requests;

use App\Factor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreFactorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('factor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:factors'],
        ];

    }
}
