<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
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
            'bedrooms' => 'integer|min:1|max:15|required',
            'rent' => 'integer|min:0|max:10000|required',
            'area' => 'string|max:100|required',
            'startDate' => 'date|required',
            'endDate' => 'date|required',
            'images' => 'array',
        ];
    }
}
