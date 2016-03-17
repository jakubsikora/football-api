<?php

namespace App\Http\Requests;
use App\Http\ApiResponse;
use App\Http\Requests\Request;

class StoreResultRequest extends Request
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
            'league_id' => 'required',
            'date' => 'required',
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'ft_home_goals' => 'required',
            'ft_away_goals' => 'required',
            'ft_result' => 'required'
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
