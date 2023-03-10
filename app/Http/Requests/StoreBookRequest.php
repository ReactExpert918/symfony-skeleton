<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        $rules = [
            'title' => ['required'],
            'release_date' => ['date','date_format:d/m/Y'],
            'description' => 'required',
            'isbn' => 'required',
            'format' => 'required',
            'number_of_pages' => ['required', 'numeric'],
        ];

        return $rules;
    }
}
