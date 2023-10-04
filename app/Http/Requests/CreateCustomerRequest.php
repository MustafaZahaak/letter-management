<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->user()) {
            if ($this->user()->hasRole('super-admin')) {
                return true;
            }
        }
        return false;
    }

    public function rules()
    {
        $rules = [];

        if ($this->isMethod('POST')) {
            $rules = [
                'number' => [
                    'required',
                    Rule::unique('customers')->where(function ($query) {
                        return $query->where(['number' => $this->input('number'),
                        'name' => $this->input('name')]);
                    })
                ]
            ];
        }

        if ($this->isMethod('PUT')) {
            $rules['number'] = [
                'required',
                Rule::unique('customers')->where(function ($query) {
                    return $query->where(
                        ['number' => $this->input('number'), 'name' => $this->input('name')]
                    ) && $query->where('id','<>', $this->route('customer'));
                })
            ];
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'number.required' => 'customer number is required',
            'number.unique' => 'customer number is already in use',
        ];
    }
}
