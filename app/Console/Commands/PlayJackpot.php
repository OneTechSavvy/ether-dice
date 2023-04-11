<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PlayJackpot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jackpot:play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play the jackpot game if there are at least 2 players';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if there are at least 2 players in the game
        $players = Player::all(); // Replace 'Player' with the name of your Player model class
        if (count($players) >= 2) {
            // Play the game
            $jackpotController = new JackpotController();
            $winner = $jackpotController->jackpotGame();
    
            // Output the winner information
            $this->info("Winner: {$winner['name']} (Loadout Number: {$winner['loadoutNumber']})");
        } else {
            $this->info("Not enough players to start the game.");
        }
    }
}
