<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PraiseCreate extends FormRequest
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
            //
            'to_user'=>'required|exists:users,id',
            'to_stamp'=>'required|exists:stamps,id',
            'message'=>'max:30',
        ];
    }
    public function attributes()
    {
        return [
            'to_user' => 'ユーザ',
            'to_stamp' => 'スタンプ',
            'message' => 'メッセージ',
        ];
    }

    public function messages()
    {
        return [
            'to_user.required' => ':attribute を選択してください。',
            'to_user.exists' => '選択した :attribute は存在しません。',
            'to_stamp.required' => ':attribute を選択してください。',
            'to_stamp.exists' => '選択した :attribute は存在しません。',
            'message.max' => ':attribute は :max 文字以内で入力してください。',
        ];
    }
}
