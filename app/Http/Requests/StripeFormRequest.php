<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeFormRequest extends FormRequest
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
            //
            // 'card_no' => 'required',
            // 'ccExpiryMonth' => 'required',
            // 'ccExpiryYear' => 'required',
            // 'cvvNumber' => 'required',
            //'amount' => 'required',

            // We are not passing FORM values to our server TO avoid PCI
        ];
    }
}
