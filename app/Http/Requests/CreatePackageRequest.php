<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePackageRequest extends FormRequest
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
        $rules = [
            'price' => 'required',
            'auto_renewal' => 'required',
            'validity' => 'required|numeric|min:1|max:31',
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = [
                'required',
                Rule::unique('packages')->where(function ($query) {
                    return $query->where(
                        ['name' => $this->input('name'), 'price' => $this->input('prices')]
                    ) && $query->where('id','<>', $this->route('package'));
                })
            ];
        } else {
            $rules['name'] = [
                'required',
                Rule::unique('packages')->where(function ($query) {
                    return $query->where(['name' => $this->input('name'), 'price' => $this->input('price')]);
                })
            ];
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => 'package name is required',
            'name.unique' => 'package name is already in use',
            'price.required' => 'price is required',
            'auto_renewal.required' => 'auto renewal is required',
        ];
    }
}
