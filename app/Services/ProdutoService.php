<?php

// Foi criado esse arquivo para manter a lógica de negocio do produto, como o desconto, e a criação do produto com o desconto e outras que possam ser usadas futuramente.

namespace App\Services;

use App\Models\Produto;
use App\Enums\CategoriaProduto;

class ProdutoService
{
    public function criarProdutoComDesconto(array $dados): Produto

        // O metodo criarProdutoComDesconto recebe um array de dados e retorna um objeto Produto com o desconto aplicado, ele será usado no controller para criar o produto com o desconto.

    {
        if ($dados['type'] === CategoriaProduto::ELETRONICO->value) {
            $dados['preco'] = $dados['preco'] * 0.8;
        }

        // Primeira condição verifica se o type do produto é eletronico, se for ele aplica um desconto de 20% no preco do produto

        if ($dados['type'] === CategoriaProduto::MOVEIS->value) {
            $dados['preco'] = $dados['preco'] * 0.9;
        }

        // Segunda condição verifica se o type do produto é moveis, se for ele aplica um desconto de 10% no preco do produto

        return Produto::create($dados);
        // No final retorna o produto com o desconto, isso com ele criado.
    }
}
