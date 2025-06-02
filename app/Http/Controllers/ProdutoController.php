<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();
        // eu estava usando o all() para pegar todos os dados da requisição, mas agora eu estou usando o query() para criar uma consulta SQL para buscar os produtos no banco de dados. Com isso posso adicionar filtros, ordenar, paginar, etc.

        if ($request->has('nome')) {
            $query->where('nome', $request->nome);
        }

        // Acima eu estou usando o where() do query para buscar os produtos no banco de dados com o nome igual ao nome informado na requisição.
        

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Acima eu estou usando o where() do query para buscar os produtos no banco de dados com a categoria igual ao type informado na requisição.


        // dd($produtos) utilizado para depurar e verificar o conteúdo da variável

        $produtos = $query->get();

        // Acima eu estou usando o get() do query para buscar os produtos no banco de dados.


       // empty Verifica se a coleção está vazia
        if(empty($produtos)){
            return response()->json([
                'message' => 'Nenhum produto encontrado.',
                'status' => 'error',
                'code' => 404,
            ]);
        }

        return new ProdutoResource($produtos);

        // Antes eu está usando o response()->json e criando o formato de JSON no controller do produto, mas eu crei o Resources, para cuidar do formato de JSON se envolver o Controller nisso.
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());

        // O codigo usando acima foi mudado de $request->all() para $request->validated() pois assim eu estou usando o metodo validated() do request para validar os dados da requisição, e no all() eu pegaria todos os dados mas não ia validar eles, assim eu estou usando o validated() para validar os dados da requisição e retornar os erros se eles forem inválidos.

        if(!$produto) {
            return response()->json([
                'message' => 'Dados não encontrados.',
                'status' => 'error',
                'code' => 404,
            ]);
        }

        return new ProdutoResource($produto);
        // O código acima está retornando uma resposta JSON com o produto recém-criado, um status de sucesso e um código de status HTTP 200 (Created).

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

        $produto->update($request->validated());

        // acima eu estava usando o all() para pegar todos os dados da requisição, mas agora eu estou usando o validated() para validar os dados da requisição e retornar os erros se eles forem inválidos, dessa forma eu estou usando o update() do Eloquent para atualizar o produto no banco de dados com os dados da requisição validados.

        return new ProdutoResource($produtos);
        
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
