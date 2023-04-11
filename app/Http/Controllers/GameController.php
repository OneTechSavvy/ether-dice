<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function joinGame(Request $request)
{
    $gameId = $request->input('game_id');
    $userId = Auth::id();

    // TODO: Logic to add the user to the game goes here
    // For example, you could add a new record to a "game_users" table

    // Start the game if enough players have joined
    $numPlayers = DB::table('game_users')->where('game_id', $gameId)->count();
    if ($numPlayers >= 2) {
        // Start the game by returning a JSON response with the necessary data
        $users = DB::table('game_users')->where('game_id', $gameId)->pluck('user_name');
        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }

    return response()->json(['success' => true]);
}
}