<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;

class CustomerRequest extends Request
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
        $minimum_characters = Settings::get('minimum_characters');
        $max_upload_file_size = Settings::get('max_upload_file_size');
        $allowed_extensions = Settings::get('allowed_extensions');

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'first_name' => 'required|min:'.$minimum_characters.'|max:50|alpha',
                    'last_name' => 'required|min:'.$minimum_characters.'|max:50|alpha',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6|confirmed',
                    'phone_number' => 'required|regex:/^\d{5,15}?$/',
                    'sales_team_id' => 'required',
                    'website' => 'url',
                    'mobile' => 'regex:/^\d{5,15}?$/',
                    'fax' => 'regex:/^\d{5,15}?$/',
                    'user_avatar' => 'mimes:'.$allowed_extensions.'|image|max:'.$max_upload_file_size,
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                if (preg_match("/\/(\d+)$/", $this->url(), $mt))
                    $user = User::find($mt[1]);
                return [
                    'first_name' => 'required|min:'.$minimum_characters.'|max:50|alpha',
                    'last_name' => 'required|min:'.$minimum_characters.'|max:50|alpha',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'password' => 'min:6|confirmed',
                    'website' => 'url',
                    'phone_number' => 'required|regex:/^\d{5,15}?$/',
                    'sales_team_id' => 'required',
                    'mobile' => 'regex:/^\d{5,15}?$/',
                    'fax' => 'regex:/^\d{5,15}?$/',
                    'user_avatar' => 'mimes:'.$allowed_extensions.'|image|max:'.$max_upload_file_size,
                ];
            }
            default:break;
        }

        return [

        ];
    }

	public function messages()
	{
		return [
			'phone_number.regex' => 'Phone number can be only numbers',
			'mobile.regex' => 'Mobile number can be only numbers',
			'fax.regex' => 'Fax number can be only numbers',
		];
	}
}
