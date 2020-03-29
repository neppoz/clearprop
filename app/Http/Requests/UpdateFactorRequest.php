<?php

namespace App\Http\Requests;

use App\Factor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateFactorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('factor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:factors,name,' . request()->route('factor')->id],
        ];

    }
}
