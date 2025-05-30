<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use App\Enums\CategoriaProduto;
use App\Http\Requests\StoreProdutoRequest;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        // dd($produtos) utilizado para depurar e verificar o conteúdo da variável

       // empty Verifica se a coleção está vazia
        if(empty($produtos)){
            return response()->json([
                'message' => 'Nenhum produto encontrado.',
                'status' => 'error',
                'code' => 404,
            ]);
        }

        return response()->json([
            'produtos' => $produtos,
            'status' => 'success',
            'code' => 200,
        ]);

        // Ou seja a function de index() está retornando todos os produtos cadastrados no banco de dados usando o Produto::all().
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = Produto::create($request->all());
        // O codigo usando acima está usando o método create() do Eloquent para criar um novo produto no banco de dados com os dados fornecidos na requisição. usando um o metodo do eloquent que se chamada create, eu usei o $request->all() pois vai ser postado todos os dados que estão dentro da variável da model $fillable e estou pegando todos todos os dados usando o Request $request.

        return response()->json([
            'produto' => $produto,
            'status' => 'success',
            'code' => 200,
        ]);

        // O código acima está retornando uma resposta JSON com o produto recém-criado, um status de sucesso e um código de status HTTP 200 (Created).

        if(!$request) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'status' => 'error',
                'code' => 422,
            ]);
        }

    }

    public function update(StoreProdutoRequest $request, string $id)
    {
        $produto = Produto::find($id);
        // O código acima está usando o metodo find() do Eloquent para buscar um produto pelo seu ID. Se o produto não for encontrado, ele retornará null.

        if(!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado.',
                'status' => 'error',
                'code' => 404,
            ]);
        }

        // Depois do find, eu estou fazendo um verificação para ver se o produto existe, se não existir, ele retorna uma resposta JSON com uma mensagem de erro.

        $produto->update($request->all());

        // acima Já que se passar da validação, eu estou usando o metodo update() do Eloquent para atualizar o produto com os dados fornecidos na requisição. Nota que eu estou passando $request->all() para atualizar todos os campos do produto com os dados da requisição, pois assim eu foco em deixa a model cuidar dos campos que eu quero atualizar.

        return response()->json([
            'produto' => $produto,
            'status' => 'success',
            'code' => 200,
        ]);

        // Finalmente, o código retorna uma resposta JSON com o produto atualizado, um status de sucesso e um código de status HTTP 200 (OK).
    }

    public function destroy(string $id)
    {
        $produto = Produto::find($id);
        // O código acima está usando o método find() do Eloquent para buscar um produto pelo seu ID. Se o produto não for encontrado, ele retornará null.

        if (!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado.',
                'status' => 'error',
                'code' => 404,
            ]);
        }

        // Depois do find, eu estou fazendo um verificação para ver se o produto existe, se não existir, ele retorna uma resposta JSON com uma mensagem de erro.

        $produto->delete();
        // Se o produto for encontrado, o código acima está usando o método delete() do Eloquent para excluir o produto do banco de dados.

        return response()->json([
            'message' => 'Produto deletado com sucesso.',
            'status' => 'success',
            'code' => 200,
        ]);

        // finalmente, o código retorna uma resposta JSON com uma mensagem de sucesso e um código de status HTTP 200 (OK).
    }
}
