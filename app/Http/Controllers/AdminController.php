<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\User; // Import the User model
use App\Models\DiceGame; 
use App\Models\CoinflipGame; 
use App\Models\JackpotGame; 
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    $withdrawals = Withdrawal::all();
    $total_users = User::count(); // Get the count of all users
    $diceGamesCount = DiceGame::count();
    $coinflipGamesCount = CoinflipGame::count();
    $jackpotGamesCount = JackpotGame::count();
    $totalGames = $diceGamesCount + $coinflipGamesCount + $jackpotGamesCount;
    return view('admin.index', compact('withdrawals', 'total_users','totalGames'));
}
public function approveWithdrawal($id)
{
    $withdrawal = Withdrawal::findOrFail($id);
    $withdrawal->status = 'approved';
    $withdrawal->save();
    
    return redirect()->back()->with('success', 'Withdrawal request approved!');
}

public function rejectWithdrawal($id)
{
    $withdrawal = Withdrawal::findOrFail($id);
    $withdrawal->status = 'rejected';
    $withdrawal->save();
    
    return redirect()->back()->with('success', 'Withdrawal request rejected!');
}
}
