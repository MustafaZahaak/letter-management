<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->user()) {
            if ($this->user()->hasRole('super-admin')) {
                return true;
            }
            if ($this->user()->hasRole('admin') && $this->user()->organization_id == $this->input('organization_id')) {
                return true;
            }
        }
        return false;
    }

    public function rules()
    {
        if ($this->user()->hasRole('super-admin')) {
            $roleRule = Rule::notIn(['']);
        }
        if ($this->user()->hasRole('admin')) {
            $roleRule = Rule::notIn(['super-admin']);
        }

        $rules = [
            'name' => 'required',
            'user_name' => 'required|unique:users,user_name',
            'password' => 'required',
            'email' => 'required|email',
            'org_id' => [
                Rule::requiredIf($this->input('roles') != 'super-admin'),
                'exists:organizations,id',
            ],
            'roles' => ['required', $roleRule],
            'roles.*' => [$roleRule]
        ];
        if ($this->method() == 'PUT') {
            $rules['user_name'] = 'required|unique:users,user_name,' . $this->input('id');
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => ' اسم کاربری ضروری میباشد',
            'name.unique' => 'اسم کاربری از قبل موجود میباشد',
            "password.required" => "پاسورد ضروری میباشد",
            "email.required" => "ایمیل ضروری میباشد",
            "email.email" => "ایمیل باید بشکل درست وارد گردد ",
            'organization_id.required' => 'اداره و یا وزارت ضروری میباشد',
            'organization_id.exists' => 'اداره و یا وزارت وارد شده موجود نمی باشد',
            'roles.required' => 'مشخص سازی رول ضروری میباشد ',
        ];
    }
}
