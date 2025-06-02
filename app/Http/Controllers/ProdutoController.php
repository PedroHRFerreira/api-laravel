<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Services\ProdutoService;

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

    public function store(StoreProdutoRequest $request, ProdutoService $produtoService)
    {
        $produto = $produtoService->criarProdutoComDesconto($request->validated());

        // O codigo acima recebe o request e o produtoService, e usa o produtoService para criar o produto com o desconto, e retorna o produto criado, logo depois ele cria uma resposta JSON com o produto criado, usando o ProdutoResource, que caso tiver um erro ele retorna uma resposta JSON com uma mensagem de erro.

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

    protected ProdutoService $produtoService;

    // O codigo acima recebe o produtoService, é preciso fazer isso para poder usar o produtoService no controller, com isso eu posso usar o produtoService.

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    // O codigo acima eu faço uma função construtora,, com isso uso o $this que é uma variável que recebe o produtoService e depois atribuo o produtoService a essa variável que se chama $produtoService


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

        $this->produtoService->atualizarProdutoComDesconto($produto, $request->validated());

        // acima estou usando o produtoService para atualizar o produto com o desconto, ou seja o $this é uma váriavel que recebe o produtoService que está passando a function atualizarProdutoComDesconto, e a function recebe o produto e o request como params e retorna o produto atualizado e com o desconto, pois o com o $produto é possivel atualizar o produto para pegar os dados e depois pegar o JSON com o $request.

        return new ProdutoResource($produto);
        
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
