<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutingRequest extends FormRequest
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
            'in_out' => 'required|string|min:1|max:100',
            'description' => 'nullable|string|max:10000',
        ];
    }
}
