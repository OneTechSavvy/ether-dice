<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinsController;
use app\http\controllers\CryptoWalletsController;
use app\http\controllers\EthereumController;
use App\Http\Controllers\EtherscanController;
use App\Http\Controllers\JackpotGameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DiceController;
use App\Http\Controllers\JackpotController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\CoinflipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\MatchBettingController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\SSEController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dice');
});
Route::get('/deposit', function () {
    return view('deposit');
});

Route::get('/whitepaper', function () {
    return view('whitepaper');
});
Route::get('/dashboard', function () {
    return view('dasboard');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dice', function () {
        return view('dice');
    })->name('dice');
});

Route::get('/', [DiceController::class, 'index'])->name('home');
Route::post('/crypto-wallets', 'App\Http\Controllers\CryptoWalletsController@update')->name('crypto-wallets.update');
Route::get('/test-connection', [App\Http\Controllers\EthereumController::class, 'testConnection']);
Route::get('/dice', [DiceController::class, 'index'])->name('dice');
Route::post('/dice/play', [DiceController::class, 'play'])->middleware('auth')->name('dice.play');


Route::get('/withdraw', [WithdrawController::class, 'create'])->name('withdraw.create')->middleware('auth');
Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store')->middleware('auth');

Route::get('/withdraw/eth', [WithdrawController::class, 'showETHWithdrawForm'])->name('withdraw.eth');




Route::get('/admin', [WithdrawController::class, 'getAllWithdrawals'])->name('admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::put('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::put('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
});

    
Route::get('/dice-games-sse', [SSEController::class, 'diceGamesSSE'])->name('dice.games.sse');







