<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IsImage;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Rules for updating organization
        if( $this->method() == 'PUT' ){
            $rules['id']='required';
        }

        //Rules for creating a new organization
        $rules=  [
            'english_name'=>['required','max:100'],
            'dari_name'=>['required','max:100'],
            'pashto_name'=>['required','max:100'],
            'contact_no'=>'required',
            'email'=>'required|email',
            'address'=>'required',
            'address2'=>'max:100',
            'city'=>'required|max:100',
            'postcode'=>'max:100',
            'country'=>'required',
            'logo'=>'required',
        ];

        return $rules;
         
    }
}
