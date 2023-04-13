@extends('layouts.test')

@section('title', 'Home')

@section('content')
    <head>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="{{ asset('css/dice.css') }}">
        <style>
.styled-table {
    border-collapse: separate;
    border-spacing: 0;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 300px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    border-radius: 10px;
    overflow: hidden;
}

.styled-table thead tr {
    background-color: #aca327;
    color: #ffffff;
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #504f4f;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}
.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}
.popup-button {
  display: inline-block;
    margin-right: 10px;
    padding: 5px 10px;
    background-color: #494949;
    border: none;
    cursor: pointer;

}
.buttons-container {
    margin-bottom: 10px;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #585656;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
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
                      <input type="text" id="winChanceDisplay" readonly style="color: black;" disabled>

                        </div>
                  <div class="bet-container">
                    <label for="betAmount">Bet Amount:</label>
                    <input type="hidden" name="winChance" id="winChanceInput" value="{{ $winChance }}">
                    <div class="bet-input-modifiers">
                      <input type="number" id="betAmount" name="betAmount" min="1" max="{{ $balance }}" value="{{ $betAmount }}" style="color: black;"required>
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
                <div class="buttons-container">
                  <button id="button1" class="popup-button">Jackpot</button>
                  <button id="button2" class="popup-button">Fairness</button>
              </div>
          
                 <!-- Add the first modal (initially hidden) -->
                <div id="modal1" class="modal">
                  <div class="modal-content">
                      <span class="close close1">&times;</span>
                      <p>A Jackpot is a huge prize separate from your standard Dice wins, and comes as a percentage of Jackpot Pool.

                        Jackpot Pool carries a 10% gross profit of the Dice game. This grows each time the Dice is played without a Jackpot won.
                        
                        How To Enter?
                        The bet needs to be a winning one.
                        How To Hit The Jackpot?
                        You receive a random 5 digit number every time you make a valid bet.
                        When this number is 42424, you've hit the Jackpot!
                        The prize is sent to your account balance once you win. You do not need to report it anywhere.
                        How Big Is The Prize?
                        Jackpot Prize = 80% of the Jackpot Pool 
                       </p>
                  </div>
              </div>
               <!-- Add the second modal (initially hidden) -->
              <div id="modal2" class="modal">
                <div class="modal-content">
                    <span class="close close2">&times;</span>
                    <p>Information about the game (Modal 2)...</p>
                </div>
            </div>
            
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
                            <td>{{ $game->user->name }}</td>
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
        document.addEventListener('DOMContentLoaded', function() {
            var button1 = document.getElementById('button1');
            var button2 = document.getElementById('button2');
            var modal1 = document.getElementById('modal1');
            var modal2 = document.getElementById('modal2');
            var closeButton1 = document.getElementsByClassName('close1')[0];
            var closeButton2 = document.getElementsByClassName('close2')[0];
        
            function showModal1() {
                modal1.style.display = 'block';
            }
        
            function showModal2() {
                modal2.style.display = 'block';
            }
        
            function hideModal1() {
                modal1.style.display = 'none';
            }
        
            function hideModal2() {
                modal2.style.display = 'none';
            }
        
            button1.onclick = showModal1;
            button2.onclick = showModal2;
            closeButton1.onclick = hideModal1;
            closeButton2.onclick = hideModal2;
            window.onclick = function(event) {
                if (event.target == modal1) {
                    hideModal1();
                } else if (event.target == modal2) {
                    hideModal2();
                }
            };
        });
        </script>
        
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
        tableBody.deleteRow(rowCount - 1);
    }

            // Add the new game
            const row = tableBody.insertRow(0);

            row.insertCell().innerHTML = game.user_name;
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

    
        
       