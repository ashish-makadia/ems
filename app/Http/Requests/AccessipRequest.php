<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessipRequest extends FormRequest
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
        $rules = [
            'ip' => ['required','string','unique:access_ips'],
            'type' => ['required','in:Black,White'],
        ];
        if (request()->isMethod('put') || request()->isMethod('PATCH'))
        {
            $rules['ip'][2] = 'unique:access_ips,ip,' . $this->accessip->id;
        }
        return $rules;
    }
}
