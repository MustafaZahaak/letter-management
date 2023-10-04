<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use \Illuminate\Http\Request;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required',
            'org_id' => 'required|exists:organizations,id',
            'permission' => ($this->input('name')) != 'super-admin' ? 'required' : ''
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام رول ضروری میباشد',
            'originator.required' => 'منبع ضروری میباشد',
            'originator.exists' => 'منبع وارد شده موجود نمی باشد',
            'permission.required' => 'صلاحیت ها ضروری میباشد ',
        ];
    }
}
