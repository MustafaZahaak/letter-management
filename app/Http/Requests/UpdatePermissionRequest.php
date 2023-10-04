<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:25',
                Rule::unique('permissions')->where(function ($query) {
                    return $query->where('id', '<>', $this->input('id'));
                })
            ],
            'module_name'=>'required',
            'description'=>'required',
        ];
    }
}
