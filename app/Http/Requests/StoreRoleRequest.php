<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user()->hasRole('super_admin')){
            return true;
        }
        if ($this->user() && !$this->user()->hasRole('super_admin') && $this->input('name') != 'super_admin') {
            return true;
        }
        
        return false;
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
            'originator.required' => 'منبع وزارت ضروری میباشد',
            'originator.exists' => 'منبع وارد شده موجود نمی باشد',
            'permission.required' => 'صلاحیت ها ضروری میباشد ',
        ];
    }
}
