<?php

/// Criei esse arquivo de request para validar os dados que serão enviados ao criar um produto, como o nome, o preco, a descricao e a categoria. Primeiro ele foi pensado para ser usado no controller produto para validar os enums.

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CategoriaProduto;
use Illuminate\Validation\Rules\Enum;

/// Illuminate\Validation\Rules\Enum; Esse pacote foi usado para validar os enums, ele é um pacote do laravel que já vem incluso no laravel, e é usado para validar os enums que foram criados na pasta de Enums, que eu criei para armazenar as categorias dos produtos.

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permite que qualquer um faça a requisição (ajuste conforme necessário)
    }

    /// a função acima permite que qualquer um faça a requisição, ou seja, não há restrições de autorização para essa requisição. sendo que qualquer pode fazer a requisição para criar um produto.

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'type' => ['required', new Enum(CategoriaProduto::class)],
        ];
    }

    /// A função rules() define as regras de validação para os dados que serão enviados ao criar um produto. ou seja é obrigátorios os dados acima seguir o padrão definido.
}
