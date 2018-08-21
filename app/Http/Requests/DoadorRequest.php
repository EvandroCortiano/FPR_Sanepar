<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoadorRequest extends FormRequest
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
            'ddr_nome' => 'required|max:150',
            'ddr_matricula' => 'unique:cad_doador'
        ];
    }

    	//Colocar mensagem 
	public function messages(){
		return[
            'ddr_nome.required' => 'O Nome do doador e obrigatorio!',
            'ddr_nome.max' => 'Nome inserido é muito extenso, favor abreviar!',
            'ddr_matricula.unique' => 'Matricula ja cadastrada ao sistema, favor pesquisar doador com esta matricula!',
        ];
    }
}
