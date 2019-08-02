<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
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
        $this->sanitize();

        return [
            'content'=> 'required|min:3',
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

       
        $input['content'] = filter_var($input['content'], FILTER_SANITIZE_STRING);
        
        // replace the provided form input with the filtered version
        $this->replace($input);     
    }

}
