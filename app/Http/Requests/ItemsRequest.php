<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRequest extends FormRequest
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
            'item_code' => 'required|min:1',
            'quantity' => 'required|numeric|min:0',
            'manufacture' => 'nullable|string|max:10000',
            'model' => 'nullable|string|max:10000',
            'serial_number' => 'nullable|string|max:10000',
            'category_id' => 'nullable|string|max:10000',
            'description' => 'nullable|string|max:10000',
        ];
    }
}
