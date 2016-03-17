<?php

namespace App\Http\Requests;
use App\Http\ApiResponse;
use App\Http\Requests\Request;

class UpdateLeagueRequest extends Request
{
    use ApiResponse;

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
            'code' => 'unique:leagues',
        ];
    }

    /**
     * [response description]
     * @param  array  $errors [description]
     * @return [type]         [description]
     */
    public function response(array $errors)
    {
        return $this->respondUnprocessableEntity($errors);
    }
}
