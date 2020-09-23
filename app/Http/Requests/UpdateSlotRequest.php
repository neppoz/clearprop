<?php

namespace App\Http\Requests;

use App\Models\Slot;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSlotRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('slot_edit');
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
