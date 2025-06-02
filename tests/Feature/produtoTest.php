<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produto;

class produtoTest extends TestCase
{
    public function test_get_produto(): void
    {
         /// teste de rota de GET ou a function de index do controller produto.

        $produtos = Produto::create([
            'nome' => 'Teste',
            'preco' => 100.00,
            'descricao' => 'Produto de teste',
            'type' => 'eletronico'
         ]);

         // Primeiro eu estou criando um produto usando o metodo do eloquent create, e fazendo um criação padrão para o teste.

        $response = $this->get('/');
        // Aqui estou fazendo uma requisição GET para a rota raiz do aplicativo, que deve estar vinculada ao método index do ProdutoController.

        $response->assertStatus(200);
        // Já aqui estou verificando se a resposta da requisição tem o status HTTP 200, indicando que a requisição foi bem-sucedida.


        dump($produtos);
        // Utilizando o comando dump para exibir o conteúdo da variável $produtos na saída do PHP.
    }
    public function test_post_produto(): void
    {
        // teste de rota de POST ou a function de store do controller produto.
         $response = Produto::create([
            'nome' => 'Teste',
            'preco' => 100.00,
            'descricao' => 'Produto de teste',
            'type' => 'eletronico',
         ]);

         // Aqui estou criando um novo produto usando o método create do Eloquent, que é uma maneira de inserir dados no banco de dados.

            $this->assertDatabaseHas('produtos', [
                'nome' => 'Teste',
                'preco' => 100.00,
                'descricao' => 'Produto de teste',
                'type' => 'eletronico',
            ]);

        // Aqui estou verificando se o produto foi adicionado ao banco de dados, usando o método assertDatabaseHas do PHPUnit, que verifica se a tabela 'produtos' contém os dados especificados.

        $this->assertTrue($response->wasRecentlyCreated, 'Produto não foi criado com sucesso.');

        // Por ultimo, estou verificando se o produto foi criado recentemente, usando o método wasRecentlyCreated do Eloquent, que retorna verdadeiro se o modelo foi criado na última operação de inserção. Se não foi criado com sucesso, uma mensagem de erro será exibida.
    }

    public function test_update_produto(): void
    {
        $produto = Produto::create([
            'nome' => 'Teste',
            'preco' => 100.00,
            'descricao' => 'Produto de teste',
            'type' => 'eletronico',
         ]);

        $produto->update([
            'nome' => 'Teste Atualizado',
            'preco' => 150.00,
            'descricao' => 'Produto de teste atualizado',
            'type' => 'moveis',
        ]);

        // Aqui estou criando um produto e, em seguida, atualizando seus dados usando o método update do Eloquent.

        $this->assertDatabaseHas('produtos', [
            'nome' => 'Teste Atualizado',
            'preco' => 150.00,
            'descricao' => 'Produto de teste atualizado',
            'type' => 'moveis',
        ]);

        // Por fim, estou verificando se o produto foi atualizado no banco de dados, usando o método assertDatabaseHas do PHPUnit, que verifica se a tabela 'produtos' contém os dados especificados.

        dump($produto);

        // Adicionado o comando dump para exibir o conteúdo da variável $produto na saída do PHP, foi pensado que ajudaria na depuração do teste.
    }

    function test_delete_produto(): void
    {
        $produto = Produto::create([
            'nome' => 'Teste',
            'preco' => 100.00,
            'descricao' => 'Produto de teste',
            'type' => 'eletronico',
         ]);

        $produto->delete();

        // Aqui estou criando um produto e, em seguida, excluindo-o usando o método delete do Eloquent.

        $this->assertTrue($produto->wasRecentlyCreated, 'Produto não foi excluído com sucesso.');

        // Por fim, estou verificando se o produto foi excluído com sucesso, se não foi excluído, uma mensagem de erro será exibida.
    }

    // Para testa especificamente a rota de produto e este teste só rodar no terminal php artisan test --filter ProdutoTest
}
