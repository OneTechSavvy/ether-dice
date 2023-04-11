@extends('layouts.test')



@section('content')
    <head>
                <style>

.col-md-offset-3{margin-left:25%}


 </style>


 
        <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

        <script>
    

        </script>
         <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>    
    <body>
        <div class="game-container">
                  <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                          <div class="page-header">
                              <h1>Jackpot</h1>
                          </div>
                          
                      </div>
                  </div>
                  
                  <div class="row topbox">
                      <div class="col-md-6 col-md-offset-3 rollbox">
                          <div class="line"></div>
                          <table><tr id="loadout">
                              
                          </tr></table>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                          <div id="msgbox"class="alert alert-warning" style="margin-top:20px;display:none;">You need to add at least 2 lines!</div>
                      </div>
                  </div>
                  
                  <div class="row">
                      
                      <div class="col-md-12" style="text-align:center">
                          <div id="log"></div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                        <div class="player-container">
                            <h2>Player List</h2>
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Bet Amount</th>
                                        <th scope="col">Chance of Winning</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalBetAmount = $players->sum('bet_amount');
                                    @endphp
                                    @foreach($players as $player)
                                        @php
                                            $percentageChance = $totalBetAmount == 0 ? 0 : ($player->bet_amount / $totalBetAmount) * 100;
                                        @endphp
                                        <tr>
                                            <td>{{ $player->user->name }}</td>
                                            <td>{{ $player->bet_amount }}</td>
                                            <td>{{ number_format($percentageChance, 2) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            
                      
     
                            <form id="playJackpotForm">
                                @csrf
                                <label for="client_seed">Client Seed:</label>
                                <input type="text" name="client_seed" id="client_seed">
                                <br>
                                <button type="submit">Play Jackpot</button>
                            </form>
                            

                      </div>
                  </div>
              </div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      
        <script src="{{ asset('js/animation.js') }}"></script>
    </body>



 @endsection