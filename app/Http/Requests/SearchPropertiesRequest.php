<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchPropertiesRequest extends FormRequest
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
            'bedrooms' => 'integer',
            'startDate' => 'date',
            'endDate' => 'date',
            'rentMin' => "integer",
            'rentMax' => 'integer',
        ];
    }
}
