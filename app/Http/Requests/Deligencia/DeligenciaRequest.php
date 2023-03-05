<?php

namespace App\Http\Requests\Deligencia;

use Illuminate\Foundation\Http\FormRequest;

class DeligenciaRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }

    public function createRules(): array
    {
        return [

            'rol'           => 'required|string|max:191',  
            'caratulado'    => 'required|string|max:191',  
            'tribunal'      => 'required|string|max:191',
            'materia'       => 'required|string|max:191',
            'obs'           => 'string|max:1000|nullable',
            'cliente_id'    => 'required|integer|exists:personas,id',
            'abogado_id'    => 'required|integer|exists:personas,id',
        ];
    }

    public function updateRules(): array
    {
        return [

            'rol'           => 'required|string|max:191',  
            'caratulado'    => 'required|string|max:191',  
            'tribunal'      => 'required|string|max:191',
            'materia'       => 'required|string|max:191',
            'obs'           => 'string|max:1000|nullable',
            'cliente_id'    => 'required|integer|exists:personas,id',
            'abogado_id'    => 'required|integer|exists:personas,id',
            
        ];
    }
}
