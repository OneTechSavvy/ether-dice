<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MatchBettingController extends Controller
{
    public function index()
    {
        $matches = $this->fetchMatches();

        return view('MatchBetting', compact('matches'));
    }
    private function fetchMatches()
    {
        $client = new \GuzzleHttp\Client();
        $apiKey = '_QtgPdO20W3-3KUaIhss8O1HS9Vjhicuy7xtNEB4iLxGlbeyFKM'; // Replace with your actual API key
    
        $response = $client->request('GET', 'https://api.pandascore.co/csgo/matches/upcoming?sort=&page=1&per_page=50', [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => "Bearer {$apiKey}",
            ],
        ]);
    
        return json_decode($response->getBody(), true);
        
    }
    
public function showMatches()
{
    $matches = $this->fetchMatches();
    return view('matchbetting', ['matches' => $matches]);
}
    
}