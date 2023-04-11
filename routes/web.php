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
    return view('jackpot');
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
    Route::get('/jackpot', function () {
        return view('jackpot');
    })->name('jackpot');
});

Route::get('/', [JackpotController::class, 'jackpot'])->name('home');
Route::get('/coins', [CoinsController::class, 'index'])->name('coins.index');
Route::post('/coins/update', [CoinsController::class, 'update'])->name('coins.update');
Route::post('/coins/add', [CoinsController::class, 'add'])->name('coins.add');
Route::post('/coins/subtract', [CoinsController::class, 'subtract'])->name('coins.subtract');
Route::post('/crypto-wallets', 'App\Http\Controllers\CryptoWalletsController@update')->name('crypto-wallets.update');
Route::get('/test-connection', [App\Http\Controllers\EthereumController::class, 'testConnection']);
Route::get('/etherscan/successful-transactions', [EtherscanController::class, 'getSuccessfulTransactions']);
Route::post('/join-game', [GameController::class, 'joinGame'])->name('join-game');
Route::get('/dice', [DiceController::class, 'index'])->name('dice');
Route::post('/dice/play', [DiceController::class, 'play'])->middleware('auth')->name('dice.play');
Route::get('/jackpot', [JackpotController::class, 'jackpot'])->name('jackpot');
Route::get('/generateSeed', [SeedController::class, 'generateSeed']);
Route::post('/jackpot/PlayerPool', [JackpotController::class, 'PlayerPool'])->name('jackpot.PlayerPool');
Route::post('/jackpot/jackpot-game', [JackpotController::class, 'jackpotGame'])->name('jackpot.jackpotGame');

Route::get('/coinflip', [CoinflipController::class, 'index'])->name('coinflip.index');

Route::get('/match-betting', [App\Http\Controllers\MatchBettingController::class, 'index']);
Route::get('/match-betting', [MatchBettingController::class, 'showMatches']);

Route::get('/withdraw', [WithdrawController::class, 'create'])->name('withdraw.create')->middleware('auth');
Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store')->middleware('auth');

Route::get('/withdraw/eth', [WithdrawController::class, 'showETHWithdrawForm'])->name('withdraw.eth');



Route::get('/admin', [WithdrawController::class, 'getAllWithdrawals'])->name('admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::put('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::put('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
});

    
Route::middleware(['auth'])->group(function () {
    Route::post('/coinflip/create_game', [CoinflipController::class, 'createGame'])->name('coinflip.create_game');
    Route::post('/coinflip/join_game/{gameId}', [CoinflipController::class, 'joinGame'])->name('coinflip.join_game');



});
Route::get('/coinflip-sse', [SSEController::class, 'coinflipSSE'])->name('coinflip.sse');
Route::get('/dice-games-sse', [SSEController::class, 'diceGamesSSE'])->name('dice.games.sse');





