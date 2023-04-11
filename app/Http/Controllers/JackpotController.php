<?php

namespace App\Http\Controllers;

use App\Models\JackpotPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\JackpotGame;

class JackpotController extends Controller
{
    public function index()
    {
        
        return view('jackpot.index');
    }
    public function jackpot()
    {
        $players = JackpotPlayer::with('user')->get();
    
        return view('jackpot', compact('players'));
    }
    public function playerPool(Request $request)
    {
        // get the authenticated user
        $user = Auth::user();

        // get the bet amount from the request
        $betAmount = $request->input('betAmount');

        // validate the bet amount
        if ($betAmount <= 0) {
            return response()->json(['error' => 'Invalid bet amount']);
        }

        // check if the user has already joined the jackpot
        $player = JackpotPlayer::where('user_id', $user->id)->first();

        if (!$player) {
            // add the user as a new player to the jackpot
            $player = JackpotPlayer::create([
                'user_id' => $user->id,
                'bet_amount' => $betAmount,
            ]);
        } else {
            // update the existing player's bet amount
            $player->bet_amount = $betAmount;
            $player->save();
        }

        // retrieve all players from the database
        $players = JackpotPlayer::all();

        // calculate the total bet amount and percentage chance of winning
        $totalBetAmount = $players->sum('bet_amount');
        $percentageChance = $totalBetAmount == 0 ? 0 : $betAmount / $totalBetAmount * 100;

        // return the player data and the total bet amount and percentage chance of winning
        return response()->json([
            'balance' => $user->coins,
            'players' => $players->pluck('user.name'),
            'totalBetAmount' => $totalBetAmount,
            'percentageChance' => $percentageChance,
        ]);
    }

    public function JackpotGame(Request $request)
    {
        // check if there are at least 2 players in the jackpot
        $playerCount = JackpotPlayer::count();
        if ($playerCount < 2) {
            return response()->json(['error' => 'Not enough players to play']);
        }
        
        // generate the server seed and client seed
        $serverSeed = Hash::make(Str::random(32));
        $clientSeed = $request->input('client_seed') ?? Str::random(32);
    
        // retrieve all players from the database
        $players = JackpotPlayer::all();
    
        // calculate the total bet amount and percentage chance of winning for each player
        $totalBetAmount = $players->sum('bet_amount');
        $playerChances = $players->map(function ($player) use ($totalBetAmount) {
            $percentageChance = $totalBetAmount == 0 ? 0 : $player->bet_amount / $totalBetAmount * 100;
            return [
                'player_id' => $player->id,
                'percentage_chance' => $percentageChance,
            ];
        });
    
        // generate a winning player based on the server seed and client seed
        $hash = hash('sha256', $serverSeed . "-" . $clientSeed);
        $roll = hexdec(substr($hash, 0, 8)) % 100;
        $cumulativeProbability = 0;
        foreach ($playerChances as $playerChance) {
            $cumulativeProbability += $playerChance['percentage_chance'];
            if ($roll <= $cumulativeProbability) {
                $winner = $playerChance['player_id'];
                break;
            }
        }
    
        // retrieve the winning player's name and bet amount
        $winningPlayer = JackpotPlayer::find($winner)->user;
        $winningAmount = $totalBetAmount;
    
        // calculate the commission amount
        $commission = $winningAmount * 0.05;
        $winningAmount -= $commission;
    
        // add the winnings and commission to the winner's balance
        $winningPlayer->coins += $winningAmount;
        $winningPlayer->save();
    
        // create a new JackpotGame instance and save it to the database
        $game = new JackpotGame();
        $game->winner_id = $winningPlayer->id;
        $game->winning_amount = $winningAmount;
        $game->commission_amount = $commission;
        $game->server_seed = $serverSeed;
        $game->client_seed = $clientSeed;
        $game->save();
    
// Create an array of player names and bet amounts
$playerData = $players->map(function ($player) {
    return [
        'name' => $player->user->name,
        'bet_amount' => $player->bet_amount,
    ];
})->toArray();

$winningLoadoutNumber = rand(1, 100);

// Create an array with the server seed, client seed, winner, winning amount, and players
$data = [
    'server_seed' => $serverSeed,
    'client_seed' => $clientSeed,
    'winner' => [
        'name' => $winningPlayer->name,
        'winning_amount' => $winningAmount,
        'players' => $playerData,
    ],
];
    
        // encode the data as a JSON string and output it to the browser
        return response()->json($data);
    }
}