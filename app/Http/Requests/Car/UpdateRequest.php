<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'year' => ['required', 'max:255'],
            'model' => ['required', 'max:255'],
            'brand' => ['required', 'max:255'],
            'license_plate' => [
                'required',
                'max:255',
                Rule::unique('cars')->ignore($this->route('car'))
            ],
        ];
    }
}
