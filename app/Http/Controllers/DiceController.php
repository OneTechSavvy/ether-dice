<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DiceGame;
use App\Events\DiceGameCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;



class DiceController extends Controller
{
 public function index()
    {
        $result = null;
        $winChance = null;
        $payout = null;
        $randNum = null;
        $winAmount = null;
        $betAmount = null;
        $balance = null;
        $jackpotCoins = null;
    
        if (Auth::check()) {
            $user = auth()->user();
            $balance = $user->coins;
            $jackpot = House::where('name', 'DiceJackpot')->first();
            $jackpotCoins = $jackpot ? $jackpot->coins : 0;
        }
        $jackpot = House::where('name', 'DiceJackpot')->first();
        $jackpotCoins = $jackpot ? $jackpot->coins : 0;
        
        $biggestWins = Cache::remember('biggest_wins', 3600, function () {
            return DiceGame::where('result', 'win')
                ->where('created_at', '>=', now()->subDay())
                ->orderBy('win_amount', 'desc')
                ->take(5)
                ->get();
        });
        
        $lastGames = DiceGame::getLastNGames(9);

        return view('dice', [
            'result' => $result,
            'winChance' => $winChance,
            'payout' => $payout,
            'randNum' => $randNum,
            'winAmount' => $winAmount,
            'betAmount' => $betAmount,
            'balance' => $balance,
            'jackpotCoins' => $jackpotCoins,
            'biggestWins' => $biggestWins,
            'lastGames' => $lastGames,
        ]);
    
    

}

public function play(Request $request)
{
    $user = auth()->user();
    $balance = $user->coins;
    
    // Generate a random server seed
    $server_seed = Str::random(32);
    
    // Generate a random client seed
    $client_seed = Str::random(32);
    
    // Combine the server and client seeds to create a unique seed for the game
    $combined_seed = hash('sha256', $server_seed . $client_seed);
    
    // Generate the random number using the combined seed
    $randNum = hexdec(substr($combined_seed, 0, 8)) % 100 + 1;
    
        $betAmount = $request->input('betAmount'); // Get bet amount from request, default to 100
    
        // Validate the bet amount to ensure it is within the user's available balance
        if ($betAmount > $balance) {
            $betAmount = $balance;
        } elseif ($betAmount < 1) {
            $betAmount = 1;
        }
    
        $winChance = $request->input('winChance', 50); // Get win chance from request, default to 50
    
        // Validate the win chance to ensure it is within the valid range
        if ($winChance < 5) {
            $winChance = 5;
        } elseif ($winChance > 95) {
            $winChance = 95;
        }
    
    
        $isWinner = $randNum <= $winChance; // Check if the random number is less than or equal to the win chance
        $result = $isWinner ? 'win' : 'lose'; // Set the result to "win" or "lose" based on the win chance
    
        if ($winChance == 100) {
            $payout = 5; // Set a fixed payout of 5 for the highest win chance
        } else {
            $payout = (100 - $winChance) / $winChance + 1; // Calculate the payout based on the win chance
        }
    
        $winAmount = round($payout * $betAmount, 2); // Calculate the win amount based on the payout and bet amount
    
        $balance -= $betAmount; // Remove bet amount from balance when user plays the game
    
        $house = House::where('name', 'DiceHouse')->first(); // Get the DiceHouse user from the House table
        
        $ticket = null; // Set ticket to null by default
   

    
        if ($result == 'win') {
            $houseEdge = round(0.05 * $winAmount, 2); // Calculate 5% house edge
            $winAmount -= $houseEdge; // Subtract house edge from win amount
            $balance += $winAmount; // Add net win amount to balance if user wins
        
          
            $ticket = rand(1, 100000); // Generate a random number from 1 to 100000 as a ticket
            // Check if the bet amount is greater than or equal to 1 coin
            if ($betAmount >= 1) {
                // Check if the ticket matches the jackpot number
                if ($ticket == 42424) { 
                    $jackpot = House::where('name', 'DiceJackpot')->first();
                    $jackpotWin = $jackpot->coins * 0.8; // Calculate 80% of the DiceJackpot balance
                    $jackpot->coins -= $jackpotWin; // Remove 80% from DiceJackpot balance
                    $jackpot->save(); // Save the changes to the DiceJackpot user's balance in the database
            
                    $balance += $jackpotWin; // Add jackpot win amount to user's balance
                }
            }
            $user->update(['coins' => $balance]); // Update user's coins in database
        
            // Send 90% of house edge to DiceHouse
            $house->coins -= round(0.9 * $houseEdge, 2); 
            $house->save(); // Save the changes to the DiceHouse user's balance in the database
            
            // Send 10% of house edge to DiceJackpot
            $jackpot = House::where('name', 'DiceJackpot')->first();
            $jackpotAmount = round(0.1 * $houseEdge, 2);
            $jackpot->coins += $jackpotAmount;
            $jackpot->save(); // Save the changes to the DiceJackpot user's balance in the database
        } else {
            $house->coins += $betAmount; // Add bet amount to the DiceHouse user's balance if user loses
            $house->save(); // Save the changes to the DiceHouse user's balance in the database
        }
    
        $user->update(['coins' => $balance]); // Update user's coins in database

        $jackpotCoins = $houses['DiceJackpot']->coins ?? 0;

    $game = new DiceGame([
        'user_id' => $user->id,
        'bet_amount' => $betAmount,
        'win_chance' => $winChance,
        'result' => $result,
        'rand_num' => $randNum,
        'payout' => $payout,
        'win_amount' => $winAmount,
        'jackpotCoins' => $jackpotCoins,
        'ticket' => $ticket,
        'created_at' => now(),
    ]);
    
    $game->save();
    $biggestWins = Cache::get('biggest_wins', function () {
        return DiceGame::where('result', 'win')
            ->where('created_at', '>=', now()->subDay())
            ->orderBy('win_amount', 'desc')
            ->take(5)
            ->get();
    });
        

    
    return redirect()->route('dice')->with([
        'winAmount' => $winAmount,
        'result' => $result,
        'rand_num' => $randNum,
    ]);

 
    }
    public function getBiggestWins()
    {
        // Get the biggest wins from cache or fetch them if not available
        $biggestWins = Cache::get('biggest_wins', function () {
            return DiceGame::where('result', 'win')
                ->where('created_at', '>=', now()->subDay())
                ->orderBy('win_amount', 'desc')
                ->take(5)
                ->get();
        });
    
        return $biggestWins;
    }
}


