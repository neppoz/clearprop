<?php

namespace App\Http\Requests;

use App\Activity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateActivityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'user_id'       => [
                'required',
                'integer'],
            'type_id'       => [
                'required',
                'integer'],
            'plane_id'      => [
                'required',
                'integer'],
            'event'         => [
                'required',
                'date_format:' . config('panel.date_format')],
            'counter_start' => [
                'required'],
            'counter_stop'  => [
                'required'],
            'event_start'   => [
                'date_format:' . config('panel.time_format'),
                'nullable'],
            'event_stop'    => [
                'date_format:' . config('panel.time_format'),
                'nullable'],
        ];
    }
}
