<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStore extends FormRequest
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
            'middle_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string',  'max:255' ],
            'zip_code' => ['required', 'integer' ],
            'state_id' => ['required', 'integer'],
            'country_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'department_id' => ['required', 'integer'],
        ];
    }
}
