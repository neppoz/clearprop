<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAssetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('asset_create');
    }

    public function rules()
    {
        return [
            'category_id' => [
                'integer',
                'nullable',
            ],
            'serial_number' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'start_hours' => [
                'required',
                'nullable',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_hours' => [
                'required',
                'integer',
                'min:1',
                'max:2147483647',
            ],
            'end_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'location_id' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
