<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLetterRequest extends FormRequest
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
            'content' => 'required',
            'type' => 'required|in:imcoming,outgoing',
            'organization_id' => 'required|exists:organizations,id',
            'created_by' => 'required|exists:users,id'
        ];
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
