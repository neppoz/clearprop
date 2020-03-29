<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name'        => [
                'required'],
            'email'       => [
                'required'],
            'factor_id'   => [
                'required',
                'integer'],
            'medical_due' => [
                'date_format:' . config('panel.date_format'),
                'nullable'],
            'roles.*'     => [
                'integer'],
            'roles'       => [
                'required',
                'array'],
            'lang'        => [
                'required'],
        ];

    }
}
