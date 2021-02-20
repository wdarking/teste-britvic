<?php

namespace App\Http\Requests\Reservation;

use App\Models\Reservation;
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
        $rules = [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'vehicle_id' => ['required', 'numeric', 'exists:vehicles,id'],
            'date' => [
                'bail',
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
        ];

        // first we fetch the reservation being updated
        $reservation = Reservation::findOrFail($this->route('reservation'));

        // then we check if the form requested date is not equals to the
        // current reservation date. if the requested date is not the same,
        // we push the custom unique reservation rule statement to the rules array.
        // reference: https://laravel.com/docs/8.x/validation#rule-unique

        if ($this->input('date') != $reservation->date) {
            array_push(
                $rules['date'],
                Rule::unique('reservations')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'))
                        ->where('vehicle_id', $this->input('vehicle_id'))
                        ->where('date', $this->input('date'));
            }));
        }

        return $rules;
    }
}
