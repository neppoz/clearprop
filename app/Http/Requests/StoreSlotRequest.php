<?php

namespace App\Http\Requests;

use App\Models\Slot;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSlotRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('slot_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
        ];
    }
}
