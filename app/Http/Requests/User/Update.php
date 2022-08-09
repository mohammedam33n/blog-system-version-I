<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->route('user');
        return [
            'name'          => 'required',
            'username'      => 'required|max:20|unique:users,username,' . $user->id,
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile'        => 'required|numeric|unique:users,mobile,' . $user->id,
            'status'        => 'required',
            'password'      => trim('nullable|min:8'),
            'image'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ];
    }
}
