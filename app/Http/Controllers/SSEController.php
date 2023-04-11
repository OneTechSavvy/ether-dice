<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\CoinflipGame;
use App\Models\DiceGame;

class SSEController extends Controller
{
    public function coinflipSSE()
    {
        $response = new StreamedResponse(function () {
            $last_game_id = null;
            $count = 0; // Initialize the count variable

            while (true) {
                try { // Add the try block here
                    $openGamesQuery = CoinflipGame::whereIn('status', ['open', 'active', 'completed']);

                    if ($last_game_id) {
                        $openGamesQuery->where('id', '>', $last_game_id);
                    }

                    $openGames = $openGamesQuery->with('user')->get();

                    if ($openGames->isNotEmpty()) {
                        $last_game_id = $openGames->max('id');

                        echo 'data: ' . $openGames->toJson() . "\n\n";
                        ob_flush();
                        flush();

                        // Check if there are any games with changed state
                        foreach ($openGames as $game) {
                            if ($game->status_changed) {
                                echo 'event: gamestatechange' . "\n";
                                echo 'data: ' . json_encode([
                                    'game_id' => $game->id,
                                    'status' => $game->status,
                                    'user_id_2' => $game->user_id_2,
                                    'bet_amount_2' => $game->bet_amount_2,
                                    'chosen_side_2' => $game->chosen_side_2,
                                    'winner' => $game->winner
                                ]) . "\n\n";
                                ob_flush();
                                flush();
                            }
                        }

                        usleep(200000); // Adjust sleep time as needed
                        $count++; // Increment game count
                    }
                } catch (Exception $e) { // Handle exceptions gracefully
                    // Log error message or send email notification
                    sleep(10); // Wait before trying again to prevent server overload
                }
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');
        return $response;
    }

public function diceGamesSSE()
{
    $response = new StreamedResponse(function () {
        $last_game_id = null;
        $max_games = 50; // Set max number of games to broadcast
        $count = 0; // Initialize game count
    
        while ($count < $max_games) { // Add conditional exit based on game count
            try {
                $newGamesQuery = DiceGame::where('created_at', '>=', now()->subDay());
        
                if ($last_game_id) {
                    $newGamesQuery->where('id', '>', $last_game_id);
                }
        
                $newGame = $newGamesQuery->orderBy('id', 'desc')->firstOrFail(); // Add error handling and fail fast
        
                $last_game_id = $newGame->id;
        
                echo 'data: ' . json_encode($newGame) . "\n\n"; // Replace $notif with $newGame
                ob_flush();
                flush();
                usleep(200000); // Adjust sleep time as needed
        
                $count++; // Increment game count
            } catch (Exception $e) { // Handle exceptions gracefully
                // Log error message or send email notification
                sleep(10); // Wait before trying again to prevent server overload
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