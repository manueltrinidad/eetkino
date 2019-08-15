<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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
            'content' => 'required|string',
            'review_date' => 'required|date',
            'score' => 'required|integer|between:0,100',
            'is_draft' => 'required|boolean',
            'film_id' => 'required|integer',
        ];
    }
}
