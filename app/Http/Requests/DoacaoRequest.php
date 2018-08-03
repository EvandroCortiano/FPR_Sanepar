<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoacaoRequest extends FormRequest
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
            'doa_smt_id' => 'required',
        ];
    }

    	//Colocar mensagem 
	public function messages(){
		return[
            'doa_smt_id.required' => 'O motivo da doação deve estar selecionado!',
        ];
    }
}
