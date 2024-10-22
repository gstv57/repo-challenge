<?php

namespace App\Http\Requests\Produto;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome'                  => ['required', 'string'],
            'descricao'             => ['required', 'string'],
            'preco'                 => ['required', 'numeric', 'min:0.1'],
            'quantidade_em_estoque' => ['required', 'integer', 'min:1'],
            'categoria'             => ['required', 'string'],
            'imagem'                => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:10000'],
            'brand'                 => ['required', 'string', 'max:100'],
            'modelo'                => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string'   => 'O campo nome deve ser no formato texto.',

            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.string'   => 'O campo descrição deve ser no formato texto.',

            'preco.required' => 'O campo preço é obrigatório.',
            'preco.numeric'  => 'O campo preço deve ser um número.',
            'preco.min'      => 'O valor não pode ser menor que 0,1',

            'quantidade_em_estoque.required' => 'O campo quantidade em estoque é obrigatório.',
            'quantidade_em_estoque.integer'  => 'O campo quantidade em estoque deve ser um número inteiro.',
            'quantidade_em_estoque.min'      => 'O campo quantidade em estoque deve ser pelo menos :min.',

            'categoria.required' => 'O campo categoria é obrigatório.',
            'categoria.string'   => 'O campo categoria deve ser no formato texto.',

            'imagem.required' => 'O campo imagem é obrigatório.',
            'imagem.image'    => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes'    => 'A imagem deve ser do tipo: :values.',
            'imagem.max'      => 'A imagem não deve ultrapassar :max kilobytes.',

            'brand.required' => 'O campo marca é obrigatório.',
            'brand.string'   => 'O campo marca deve ser no formato texto.',
            'brand.max'      => 'O campo marca não deve ultrapassar :max caracteres.',

            'modelo.required' => 'O campo modelo é obrigatório.',
            'modelo.string'   => 'O campo modelo deve ser no formato texto.',
            'modelo.max'      => 'O campo modelo não deve ultrapassar :max caracteres.',
        ];
    }

}
