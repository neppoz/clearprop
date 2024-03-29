<?php

namespace App\Http\Requests;

use App\Booking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'plane_id' => [
                'sometimes',
                'integer'],
            'status' => [
                'sometimes',
                'integer'],
            'users' => [
                'sometimes',
                'array'],
            'seats' => [
                'exclude_if:checkin,0|required|integer'],
            'seats_taken' => [
                'sometimes',
                'integer',
                'lte:seats'],
            'seats_available' => [
                'sometimes',
                'integer'],
        ];

    }
}
