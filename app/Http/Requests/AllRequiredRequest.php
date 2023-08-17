<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllRequiredRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        if(request()->has('_method')){
            session()->put('updateMeeting',1);
        }else{
            session()->put('addMeeting',1);
        }
        return array_fill_keys(array_keys(request()->except('_token','_method')),'required');
    }
}
