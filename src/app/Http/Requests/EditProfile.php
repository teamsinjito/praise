<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfile extends FormRequest
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
        return [
            'name'=>'required|max:30',
            'profile'=>'max:100'
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'ユーザ名',
            'profile'=>'プロフィール'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute を入力してください。',
            'name.max' => ':attribute は :max 文字以内で入力してください。',
            'profile.max' => ':attribute は :max 文字以内で入力してください。',
        ];
    }
}
