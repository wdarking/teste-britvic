<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'license_plate' => ['required', 'max:255', 'unique:vehicles'],
        ];
    }
}
