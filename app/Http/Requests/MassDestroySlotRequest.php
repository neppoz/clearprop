<?php

namespace App\Http\Requests;

use App\Models\Slot;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySlotRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('slot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:slots,id',
        ];
    }
}
