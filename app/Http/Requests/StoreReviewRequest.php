<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
        $now = date("Y-m-d");
        return [
            'chat_id' => ['required', 'exists:users,chat_id', 'string'],
            'tmdb_id' => ['required', 'string', 'max:10'],
            'score' => ['required', 'integer', 'between:0,100'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'watch_date' => ['required', 'date', 'before:'.$now]
        ];
    }
}
