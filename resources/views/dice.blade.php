@extends('layouts.test')

@section('title', 'Home')

@section('content')
    <head>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="{{ asset('css/dice.css') }}">
        <style>
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    height: 300px;
    font-family: sans-serif;
    min-width: 250px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
    background-color: #009879;
    color: #6e6e6e;
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    border-bottom: 1px solid #423939;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #4b1818;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}
        </style>
    </head>
    <body>
      <body>
        <div class="main-container">
          <div class="game-live-wrapper">
            <div class="game-container">
              <div class="left-container">
                <!-- Left container content -->
                <form class="form-container" method="POST" action="{{ route('dice.play') }}">
                  @csrf
                  <div class="win-chance-input">
                      <label for="winChanceDisplay">Win Chance:</label>
                <input type="text" id="winChanceDisplay" readonly style="color: black;">
                        </div>
                  <div class="bet-container">
                    <label for="betAmount">Bet Amount:</label>
                    <input type="hidden" name="winChance" id="winChanceInput" value="{{ $winChance }}">
                    <div class="bet-input-modifiers">
                      <input type="number" id="betAmount" name="betAmount" min="1" max="{{ $balance }}" value="{{ $betAmount }}" style="color: black;">
                      <div class="bet-modifiers">
                        <button id="btn2x" class="modifier-button">2x</button>
                        <button id="btnMin" class="modifier-button">Min</button>
                        <button id="btnMax" class="modifier-button">Max</button>
                      </div>
                    </div>
                  </div>
                  <button class="button-69" type="submit">Roll the Dice!</button>
                </form>
                <div class="result">
                  @if(session('winAmount'))
                      @if(session('result') == 'win')
                          You won {{ session('winAmount') }}!
                      @else
                          Sorry, you lost.
                      @endif
                  @endif
              </div>
              </div>
              <div class="right-container">
                <!-- Right container content -->
                <form method="GET" action="{{ route('dice.play') }}">
                  @csrf
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
                      <div class="jackpot-coins">
                          <span class="jackpot-text">Jackpot:</span> <span class="jackpot-value">{{ $jackpotCoins }}</span>
                      </div>

                    <div class= "mid-div">
                      <input type="range" min="5" max="95" value="{{ $winChance }}" id="slider" name="winChance" style="width: 600px;">
                      <div id="selector">
                          <div class="selectBtn"></div>
                          <div id="selectValue"></div>
                      </div>
                    </div>
                      <div class="win-info">
                          <div class="win-chance" style="display: inline-block;">
                              <p>Win Chance: <span id="win-chance">{{ $winChance }}</span>%</p>
                          </div>
                          <div class="payout" style="display: inline-block; margin-left: 10px;">
                              <p>Payout: <span id="payout">{{ $payout }}</span>x</p>
                          </div>
                          <div class="win-amount" style="display: inline-block; margin-left: 10px;">
                              <p>Win Amount: $<span id="win-amount">{{ $winAmount }}</span></p>
                          </div>
                      </div>
              </form>
              </div>
            </div>
            <div class="live-container">
              <table id="new-games-table" class="styled-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Bet Amount</th>
                        <th>Win Chance</th>
                        <th>Payout</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lastGames as $game)
                        <tr>
                            <td>{{ $game->user_id }}</td>
                            <td>{{ $game->bet_amount }}</td>
                            <td>{{ $game->win_chance }}</td>
                            <td>{{ $game->payout }}</td>
                        </tr>
                    @endforeach
                    <!-- New games will be added here dynamically using JavaScript -->
                </tbody>
            </table>
            </div>
          </div>
          <div class="high-container">
            <!-- High container content -->
            <h2>Biggest Wins in the Last 24 Hours | Updates every Hour</h2>
            <div class="table-responsive">
              <table class="table table-dark table-striped">
                <thead>
                  <tr>
                    <th scope="col">User</th>
                    <th scope="col">Win Amount</th>
                    <th scope="col">Timestamp</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($biggestWins as $win)
                    <tr>
                      <td>{{ $win->user->name }}</td>
                      <td>${{ $win->win_amount }}</td>
                      <td>{{ $win->created_at }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </body>
        <script>
            // Get the range input field and the win chance, payout, and win amount elements
            const betAmountInput = document.getElementById('betAmount');
            const slider = document.getElementById('slider');
            const winChance = document.getElementById('win-chance');
            const payout = document.getElementById('payout');
            const winAmount = document.getElementById('win-amount');
            const winChanceInput = document.getElementById('winChanceInput');
    
// Add an event listener to the bet amount input field to update the win amount
betAmountInput.addEventListener('input', function() {
    updateWinAmount();
});

// Add an event listener to the slider to update the win chance, payout, and win amount elements
slider.addEventListener('input', function() {
    updateWinAmount();
});
function updateWinAmount() {
    // Get the current value of the slider and bet amount input field
    const value = slider.value;
    const betAmount = parseFloat(betAmountInput.value);

    // Calculate the win chance, payout, and win amount based on the slider value
    let chance = value;
    let payoutValue = value == 100 ? 5 : (100 - value) / value + 1;
    payoutValue = payoutValue.toFixed(4);
    let amount = (payoutValue * betAmount).toFixed(2);

    // Update the text content of the win chance, payout, and win amount elements
    winChance.textContent = chance;
    payout.textContent = payoutValue;
    winAmount.textContent = amount;
    winChanceInput.value = value;

    // Update the win chance input field
    const winChanceDisplay = document.getElementById('winChanceDisplay');
    winChanceDisplay.value = chance;
}

// Call updateWinAmount() to initialize win amount based on the initial bet amount
updateWinAmount();


document.getElementById("btn2x").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = parseFloat(betAmount.value) * 2;
});

document.getElementById("btnMin").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = betAmount.min;
});

document.getElementById("btnMax").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = betAmount.max;
});

function connectSSE() {
        const source = new EventSource('{{ route('dice.games.sse') }}');

        source.onmessage = function(event) {
            const game = JSON.parse(event.data);

            const tableBody = document.getElementById('new-games-table').getElementsByTagName('tbody')[0];
            const rowCount = tableBody.rows.length;

            // Remove the oldest game if there are already 10 games displayed
            if (rowCount >= 10) {
                tableBody.deleteRow(0);
            }

            // Add the new game
            const row = tableBody.insertRow();

            row.insertCell().innerHTML = game.user_id;
            row.insertCell().innerHTML = game.bet_amount;
            row.insertCell().innerHTML = game.win_chance;
            row.insertCell().innerHTML = game.payout;
        };

        source.onerror = function(error) {
    if (source.readyState === EventSource.CLOSED) {
        console.log("EventSource connection closed");
        return;
    } else if (source.readyState === EventSource.CONNECTING) {
        console.log("EventSource reconnecting...");
        return;
    }

    console.error("EventSource failed:", error);
};
    }

// Call the connectSSE function with a 1-second delay after the page is loaded
window.addEventListener('DOMContentLoaded', function() {
    setTimeout(connectSSE, 1000);
});
        </script>
    @endsection

    
        
       