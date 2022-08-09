<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
        $this->request->add(['email_verified_at' => Carbon::now()]);



        return [
            'name'          => 'required',
            'username'      => 'required|max:20|unique:users',
            'email'         => 'required|email|max:255|unique:users',
            'mobile'        => 'required|numeric|unique:users',
            'status'        => 'required',
            'bio'           => 'nullable',
            'receive_email' => 'required',
            'password'      => 'required|min:8',
            'image'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ];
    }
}
