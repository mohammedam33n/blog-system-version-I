<?php

namespace App\Http\Requests\Post;

use Stevebauman\Purify\Facades\Purify;
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

        $this->request->add(['slug' => null]);

        return [
            'title'         => 'required',
            'description'   => Purify::clean('required|min:50'),
            'status'        => 'required',
            'comment_able'  => 'required',
            'category_id'   => 'required',
            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
        ];
    }
}
