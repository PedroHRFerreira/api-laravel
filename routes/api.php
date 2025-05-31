<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::resource('/produtos', ProdutoController::class);

// Para verificar a rotas disponiveis digite no terminal: php artisan route:list, com isso listará todas as rotas.