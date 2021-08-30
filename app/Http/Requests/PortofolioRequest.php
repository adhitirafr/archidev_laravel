<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortofolioRequest extends FormRequest
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
            'title' => 'required',
            'category_id' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function message()
    {
        return [
            'title.required' => 'Title is required',
            'category_id.required' => 'Category id is required',
            'picture.required' => 'Image is required',
            'picture.max' => 'Image size must be under 2Mb.',
            'picture.mimes' => 'Supported image are jpeg,png,jpg,gif,svg',
        ];
    }
}
