<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest{
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
    public function rules(){
        $retValue = [];
        
        switch ($this->method()) {
            case 'GET':
                break;
            case 'DELETE':
                break;
            case 'POST':
                $retValue = [
                    'name' => 'required',
                ];
                break;
            case 'PUT':
                $retValue = [
                    'name' => 'required',
                ];
                break;
            default:
                break;
        }
        
        return $retValue;
    }
    
    public function messages(){
        return [
            'name.required' => 'A név megadása kötelező',
        ];
    }
}