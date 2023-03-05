<?php

namespace App\Http\Requests\Personas;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
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

            'name'          => 'required|string|max:191',
            'APaterno'      => 'string|max:191|nullable',
            'AMaterno'      => 'string|max:191|nullable',
            'rut'           => 'string|max:20|nullable',
            'email'         => 'email|nullable',
            'telefono'      => 'numeric|min:7|nullable',
            'obs'           => 'string|max:1000|nullable',
            'tipo_persona'  => 'required|string',
        ];
    }

    public function updateRules(): array
    {
        return [

            'name'          => 'required|string|max:191',
            'APaterno'      => 'string|max:191|nullable',
            'AMaterno'      => 'string|max:191|nullable',
            'rut'           => 'string|max:20|nullable',
            'email'         => 'email|nullable',
            'telefono'      => 'numeric|min:7|nullable',
            'obs'           => 'string|max:1000|nullable',
            'tipo_persona'  => 'required|string',
            
        ];
    }
}
