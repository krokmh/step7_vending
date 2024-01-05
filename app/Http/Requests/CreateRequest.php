<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // ProductContoroller、70~77、141~147l部分
        return [
            'product_name' => 'required',
            'company_id' => 'required', 
            'price' => 'required|numeric|digits:4',
            'stock' => 'required|numeric|digits:2',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',

        ];
    }

    /**
     * 項目名
     *
     * @return array
     */
    // public function attributes()
    // {
    //     return [
    //         'product_name' => '商品名',
    //         'company_id' => '会社のID', 
    //         'price' => '価格',
    //         'stock' => '在庫',
    //     ];
    // }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    // public function messages() {
    //     return [
    //         'product_name.required' => ':attributeは必須項目です',
    //         'company_id.required' => ':attributeは必須項目です。', 
    //         'price.required' => ':attributeは必須項目です。',
    //         'price.digits' => ':attributeは:digits1桁以内で入力してください。',
    //         'stock.required' => ':attributeは必須項目です。',
    //         'stock.digits' => ':attributeは:digits桁以内で入力してください。',
    //         'comment' => 'nullable',
    //         'img_path' => 'nullable|image|max:2048',
    //     ];
    // }

    
}
