<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'title_english' => 'required|string|max:100',
            'title_native' => 'nullable|string|max:100',
            'release_date' => 'required|date',
            'imdb_id' => 'nullable|alpha_num|unique:films,imdb_id',
            'film_type' => 'required|string|alpha',
            'poster_url' => 'nullable|url',
            'directors' => 'required',
            'writers' => 'required',
            'countries' => 'required'
        ];
    }
}
