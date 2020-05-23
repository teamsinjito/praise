<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostComment extends FormRequest
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
            'comment'=>'required|max:30',
        ];
    }
    public function attributes()
    {
        return [
            'comment' => 'コメント',
            // 'comment' => 'comment',

        ];
    }

    public function messages()
    {
        return [
            'comment.required' => ':attribute を入力してください。',
            // 'comment.required' => ':attribute please enter.',
            'comment.max' => ':attribute は :max 文字以内で入力してください。',
        ];
    }

    protected function failedValidation( Validator $validator )
    {
        $response['data']    = [];
        $response['status']  = 'NG';
        $response['summary'] = 'Failed validation.';
        $response['errors']  = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json( $response, 422 )
        );
    }
}
