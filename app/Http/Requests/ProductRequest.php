<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'productName' => 'required|string',
            'quantity' => 'bail|required|numeric|min:0|not_in:0',
            'price' => 'bail|required|numeric|min:0|not_in:0',
            'status' => 'required|boolean'
        ];
    }

    /**
     * If validation get fail return back to the page
     */
    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()->with($this->request);
    }
}
