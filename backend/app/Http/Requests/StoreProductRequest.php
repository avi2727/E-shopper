<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Set to true for learning purposes
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'availability' => 'required',
            'trandy' => 'required',
            'justArrived' => 'required',
            'category_id' => 'required',
            'size' => 'required',
            'color' => 'required',
            'information' => 'required',
            'location' => 'required|string',
            'supcategory_id' => 'required|max:10',
        ];
    }
}
