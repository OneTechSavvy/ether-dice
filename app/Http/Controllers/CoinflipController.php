<?php

namespace App\Http\Controllers;
use App\Models\CoinflipGame;
use App\Models\User;



use Illuminate\Http\Request;

class CoinflipController extends Controller
{
    public function index()
    {
        $openGames = CoinflipGame::whereIn('status', ['open'])->get();
        return view('coinflip', ['openGames' => $openGames, 'game' => null]);
    }
    public function createGame(Request $request)
{
    $request->validate([
        'bet_amount' => 'required|integer|min:1',
        'chosen_side' => 'required|in:heads,tails',
    ]);

    $user = auth()->user();
    $betAmount = $request->input('bet_amount');

    if ($user->coins < $betAmount) {
        return redirect()->back()->withErrors(['error' => 'Insufficient coins']);
    }

    $user->coins -= $betAmount;
    $user->save();

    $coinflipGame = new CoinflipGame([
        'user_id' => $user->id,
        'bet_amount' => $betAmount,
        'chosen_side' => $request->input('chosen_side'),
        'status' => 'open',
    ]);

    $coinflipGame->save();

    return redirect()->route('coinflip.index');
}

public function joinGame(Request $request, $gameId)
{
    $user = auth()->user();
    try {
        $game = CoinflipGame::where('id', $gameId)->where('status', 'open')->lockForUpdate()->firstOrFail();
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Invalid game']);
    }

    if ($game->user_id == $user->id) {
        return redirect()->back()->withErrors(['error' => 'You cannot join your own game']);
    }

    if ($user->coins < $game->bet_amount) {
        return redirect()->back()->withErrors(['error' => 'Insufficient coins']);
    }

    $user->coins -= $game->bet_amount;
    $user->save();

    // Set the game as active and store the second user's data
    $countdown = 5;
    // Store the countdown value in the game model
    $game->countdown = $countdown;
    $game->user_id_2 = $user->id;
    $game->chosen_side_2 = $game->chosen_side === 'heads' ? 'tails' : 'heads'; // Set the opposite of the first player's choice
    $game->bet_amount_2 = $game->bet_amount;
    $game->status = 'active';
    $game->save();

    while ($countdown > 0) {
        $game = CoinflipGame::findOrFail($gameId);
        $countdown = $game->countdown - 1;
        $game->countdown = $countdown;
        $game->save();
    }

    // Generate the hash and determine the winner
    $serverSeed = 'serverseed123'; // Replace with your own server seed
    $clientSeed = $game->id; // Use the game ID as the client seed for added randomness
    $hash = hash('sha256', $serverSeed . "-" . $clientSeed);
    $winner = ((int) substr($hash, 0, 8) % 2 == 0) ? 'heads' : 'tails';

    // Update the game with the winner
    $game->winner = $winner;
    $game->status = 'completed';
    $game->save();

    // Determine the winner and update the users' coin balances
    if ($game->chosen_side == $winner) {
        $user->coins += $game->bet_amount * 2;
        $user->save();
    } elseif ($game->chosen_side_2 == $winner) {
        $winnerUser = User::find($game->user_id_2);
        $winnerUser->coins += $game->bet_amount * 2;
        $winnerUser->save();
    } else {
        $user->coins += $game->bet_amount;
        $user->save();
        $winnerUser = User::find($game->user_id_2);
        $winnerUser->coins += $game->bet_amount;
        $winnerUser->save();
    }

    return redirect()->route('coinflip.index')->withSuccess('Game completed! The winner is: ' . $winner);

}

}
