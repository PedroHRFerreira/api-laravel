<?php

/// Criei esse arquivo de request para validar os dados que serão enviados ao criar um produto, como o nome, o preco, a descricao e a categoria. Primeiro ele foi pensado para ser usado no controller produto para validar os enums.

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CategoriaProduto;
use Illuminate\Validation\Rules\Enum;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'preco.required' => 'O campo preço é obrigatório.',
            'preco.numeric' => 'O campo preço deve ser um número.',
            'preco.min' => 'O campo preço deve ser no mínimo 0.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'type.required' => 'A categoria do produto é obrigatória.',
            'type.enum' => 'A categoria informada é inválida.',
        ];
    }

    /// A função messages() define as mensagens de erro para as regras de validação definidas na função rules(). Ou seja tudo que está dentro do Requests são validações.


    protected function failedValidation(Validator $validator)
    {
         $errors = $validator->errors();

         /// O $errors recebe os erros que foram gerados pela validação.

          throw new HttpResponseException(response()->json([
            'message' => 'Dados inválidos.',
            'status' => 'error',
            'code' => 422,
            'errors' => $errors
        ], 422));

        /// HttpResponseException e usado para retornar uma resposta HTTP personalizada quando uma requisição falhar na validação.
    }

    /// A função failedValidation() é para definir o um json personalidado de erro, caso aconteca algum erro na validação.
}
