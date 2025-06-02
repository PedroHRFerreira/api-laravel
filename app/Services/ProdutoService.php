<?php

// Foi criado esse service para centralizar a lógica de negócio relacionada ao Produto, como aplicação de descontos com base na categoria (tipo) do produto, e facilitar a manutenção e reutilização dessa lógica.

namespace App\Services;

use App\Models\Produto;
use App\Enums\CategoriaProduto;

class ProdutoService
{
    /**
     * Cria um novo produto com desconto aplicado de acordo com sua categoria.
     *
     * @param array $dados
     * @return Produto
     * 
     * No código acima eu estou passando o @param array $dados, que representa os dados do produto a serem criados, e o @return Produto, que representa o produto criado.
     */
    public function criarProdutoComDesconto(array $dados): Produto
    {
        // Aplica 20% de desconto se a categoria for ELETRONICO
        if ($dados['type'] === CategoriaProduto::ELETRONICO->value) {
            $dados['preco'] = $dados['preco'] * 0.8;
        }

        // Aplica 10% de desconto se a categoria for MOVEIS
        if ($dados['type'] === CategoriaProduto::MOVEIS->value) {
            $dados['preco'] = $dados['preco'] * 0.9;
        }

        // Cria o produto com o preço ajustado
        return Produto::create($dados);
    }

    /**
     * Atualiza um produto, aplicando o desconto apenas se a categoria (type) for alterada.
     *
     * @param Produto $produto
     * @param array $dados
     * @return Produto
     */
    public function atualizarProdutoComDesconto(Produto $produto, array $dados): Produto
    {
        // Verifica se a categoria foi alterada antes de aplicar desconto

        // O isset() verifica se a chave 'type' existe no array $dados se existir ele retorna true se não ele retorna false
        
        if (isset($dados['type']) && $dados['type'] !== $produto->type) {

            // Aplica 20% de desconto se a nova categoria for ELETRONICO
            if ($dados['type'] === CategoriaProduto::ELETRONICO->value) {
                $dados['preco'] = $dados['preco'] * 0.8;
            }

            // Aplica 10% de desconto se a nova categoria for MOVEIS
            if ($dados['type'] === CategoriaProduto::MOVEIS->value) {
                $dados['preco'] = $dados['preco'] * 0.9;
            }
        }

        // Atualiza o produto com os dados (com ou sem desconto)
        $produto->update($dados);

        return $produto;
    }
}
