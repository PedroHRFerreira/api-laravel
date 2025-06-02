<?php

// foi criado esse arquivo na intenção de manter a lógica do formato do JSON, aqui, Não necessariamente o formato do JSON de erro, mas um formato de sucesso.

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'preco' => $this->preco,
            'descricao' => $this->descricao,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // oque acima é oque vai ser exibido no JSON, isso no objetos. Eu posso mudar isso para deixar se exibido apenas oque eu desejo.
    }
    
    public function with(Request $request): array
    {
        return [
            'status' => 'success',
            'code' => 200,
        ];

        // o status e o code no JSON, interessante para validações de erros no front-end. 
    }
}
