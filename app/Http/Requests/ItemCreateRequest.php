<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Gate;

class ItemCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('itemCreate');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:64',
            'category' => Rule::in(config('enums.itemCategory')),
            'found_time' => 'required|date',
            'found_location' => 'required|max:128',
            'color' => Rule::in(config('enums.itemColor')),
            'description' => 'sometimes|max:256',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }
}
