<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('customer')?->id; 
        
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'user_mobile_no' => 'nullable|digits_between:10,12',
            'user_type' => 'required|in:admin,user',
            'user_status' => 'nullable|boolean',
        ];
        // only create time password is required
        if(empty($userId)) {
            $rules['password'] = 'required|min:6';
        }

        return $rules;
    }
}
