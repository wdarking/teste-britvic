<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'vehicle_id' => ['required', 'numeric', 'exists:vehicles,id'],
            'date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today',
                Rule::unique('reservations')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'))
                        ->where('vehicle_id', $this->input('vehicle_id'))
                        ->where('date', $this->input('date'));
                })
            ],
        ];
    }
}
