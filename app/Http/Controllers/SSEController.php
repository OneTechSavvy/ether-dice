<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\DiceGame;
use Illuminate\Support\Facades\DB;

class SSEController extends Controller
{

  //  public function diceGamesSSE()
    {
        $response = new StreamedResponse(function () {
            $last_game_id = null;
            $max_games = 50;
            $count = 0;
    
            while ($count < $max_games) {
                try {
                    $newGamesQuery = DiceGame::select('dice_games.*', 'users.name as user_name')
                        ->join('users', 'dice_games.user_id', '=', 'users.id')
                        ->where('dice_games.created_at', '>=', now()->subDay());
    
                    if ($last_game_id) {
                        $newGamesQuery->where('dice_games.id', '>', $last_game_id);
                    }
    
                    $newGame = $newGamesQuery->orderBy('dice_games.id', 'desc')->first();
    
                    if ($newGame) {
                        $last_game_id = $newGame->id;
    
                        echo 'data: ' . json_encode($newGame) . "\n\n";
                        ob_flush();
                        flush();
    
                        $count++;
                    }
                    sleep(1); // Adjust sleep time as needed
                } catch (Exception $e) {
                    sleep(10);
                }
            }
        });
    
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');
    
        return $response;
    }
    

}