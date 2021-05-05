<?php

namespace Intranet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultadoStoreRequest extends FormRequest
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
            'evaluacion' => 'required|composite_unique:resultados,idModuloGrupo,evaluacion',
            'matriculados' => 'required|numeric|max:60',
            'evaluados' => 'required|numeric|max:60',
            'aprobados' => 'required|numeric|max:60',
            'udProg' => 'required|numeric|max:30',
            'udImp' => 'required|numeric|max:30',
        ];
    }
}