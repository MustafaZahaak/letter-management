<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if ($this->user()->hasRole('super-admin')) {
//            return true;
//        }
//        if ($this->user() && $this->user()->hasRole('admin')) {
//            return true;
//        }

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
            'resource' => 'required',
            'resource_value' => 'required',
            'created_by' => 'required|exists:users,id'
        ];

        if ($this->isMethod('post')) {
            $roles ['name'] = [
                'required',
                Rule::unique('groups')->where(function ($query) {
                    return $query->where('org_id', $this->input('org_id'));
                })
            ];
        } elseif ($this->isMethod('put')) {
            $roles ['name'] = [
                'required',
                Rule::unique('groups')->where(function ($query) {
                    return $query->where('id', '<>', $this->route()->parameter('group'))->where('org_id', $this->input('org_id'));
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
