<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'reservation_start' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')],
            'reservation_stop' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')],
            'modus' => [
                'nullable',
                'integer'],
            'status' => [
                'nullable',
                'integer'],
            'user_id' => [
                'nullable',
                'integer'],
            'slot_id' => [
                'nullable',
                'integer'],
            'instructor_id' => [
                'nullable',
                'integer'],
            'instructor_needed' => [
                'nullable',
                'integer'],
            'plane_id' => [
                'required',
                'integer'],
        ];
    }
}
