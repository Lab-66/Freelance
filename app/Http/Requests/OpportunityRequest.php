<?php

namespace App\Http\Requests;

use Efriandika\LaravelSettings\Facades\Settings;

class OpportunityRequest extends Request
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
            'opportunity' => 'required',
            'email' => 'required|email',
            'customer_id' => 'required',
            'sales_person_id' => 'required',
            'sales_team_id' => 'required',
            'next_action' => 'required||date_format:"'.Settings::get('date_format').'"',
            'expected_closing' => 'required|date_format:"'.Settings::get('date_format').'"',
            'expected_revenue' => 'required|numeric',
            'phone' => 'required|regex:/^\d{5,15}?$/',
            'next_action_title' => 'required',
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $this->merge(['tags' => implode(',', $this->get('tags', []))]);
        return parent::getValidatorInstance();
    }

	public function messages()
	{
		return [
			'phone.regex' => 'Phone number can be only numbers',
		];
	}
}
