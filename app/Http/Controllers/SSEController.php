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
            // Initialize the last sent game ID to 0
            $lastSentGameId = 0;
    
            while (true) {
                try {
                    // Fetch the latest game
                    $latestGame = DiceGame::select('dice_games.*', 'users.name as user_name')
                        ->join('users', 'dice_games.user_id', '=', 'users.id')
                        ->orderBy('dice_games.id', 'desc')
                        ->first();
    
                    // Check if there is a new game
                    if ($latestGame && $latestGame->id > $lastSentGameId) {
                        // Update the last sent game ID
                        $lastSentGameId = $latestGame->id;
    
                        echo 'data: ' . json_encode($latestGame) . "\n\n";
                        ob_flush();
                        flush();
                    }
    
                    // Sleep for a while before checking for new data
                    usleep(100000); // Sleep for 0.1 seconds
                } catch (Exception $e) {
                    usleep(100000); // Sleep for 0.1 seconds
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