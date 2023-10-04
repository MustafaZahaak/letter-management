<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreSmsRequest extends FormRequest
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
            "file_path" => "required_if:group_id,==,''",
            "group_id" =>"required_if:file_path,==,''",
            "originator" => "required",
            "priority" => "required",
            "language" => "required",
            "delivery_start_date" => "required|date",
            "delivery_end_date" => "required|date",
            "message" => "required",
            'created_by' => 'required|exists:users,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file_path.required' => 'A file is required',
            'originator.required' => 'Originator is required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => $this->created_by ?? auth()->user()->id
        ]);
    }

}
