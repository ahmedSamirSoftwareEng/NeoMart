<?php

namespace App\Http\Requests;

use App\Models\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id=$this->route('category') ? $this->route('category')->id : null;
        return Category::rules($id);
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
            'parent_id.exists' => 'The selected parent category is invalid.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.min' => 'The name must be at least 3 characters.',
            'parent_id.int' => 'The parent category must be an integer.',
            'parent_id.nullable' => 'The parent category is optional.',
            'status.in' => 'The selected status is invalid.',
            'status.required' => 'The status field is required.',
        ];
    }
}
