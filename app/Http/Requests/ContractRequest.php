<?php

namespace App\Http\Requests;

use Efriandika\LaravelSettings\Facades\Settings;

class ContractRequest extends Request
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
            'start_date' => 'required|date_format:"'.Settings::get('date_format').'"',
            'end_date' => 'required|date_format:"'.Settings::get('date_format').'"',
            'description' => 'required',
            'resp_staff_id' => 'required',
            'company_id' => 'required',
        ];
    }
}
