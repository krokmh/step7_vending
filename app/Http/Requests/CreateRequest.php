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
            'price' => 'required|numeric|max:999',
            'stock' => 'required|numeric|max:99',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',

        ];
    }
}
