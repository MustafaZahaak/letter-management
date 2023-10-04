<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOriginatorRequest extends FormRequest
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
        $roles = [
            'status' => 'required|in:active,blocked',
            'org_id' => 'required|exists:organizations,id',
            'created_by' => 'required|exists:users,id'
        ];

        if ($this->isMethod('post')) {
            $roles ['name'] = [
                'required', 'max:11',
                Rule::unique('originators')->where(function ($query) {
                    return $query->where('org_id', $this->input('org_id'));
                })
            ];
        } elseif ($this->isMethod('put')) {
            $roles ['name'] = [
                'required', 'max:11',
                Rule::unique('originators')->where(function ($query) {
                    return $query->where('id', '<>', $this->input('id'))->where('org_id', $this->input('org_id'));
                })
            ];
        }
        return $roles;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => $this->created_by ?? auth()->user()->id
        ]);
    }
}
