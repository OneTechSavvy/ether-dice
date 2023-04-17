@extends('layouts.test')

@section('title', 'Home')

@section('content')
    <head>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="{{ asset('css/dice.css') }}">
        <style>
            .styled-table {
              font-family: 'Oswald', sans-serif;
                position: relative;
                top: 5px;
                border-spacing: 0;
                border-collapse: separate;
                margin: 10px 0;
                font-size: 0.75em;
                
                
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                border-radius: 10px;
                overflow: hidden;
            }

            .styled-table thead tr {
             
              background-color: orange;
                color: black;
                text-align: left;
                font-size: 14px;
            }

            .styled-table th,
            .styled-table td {
                padding: 4px 11px;
                
            }

            .styled-table tbody tr {
              border-bottom: 1px solid #dddddd;

              
               
                
            }

            .styled-table tbody tr:nth-of-type(even) {
              background-color: black;
            
            }

            .styled-table tbody tr:last-of-type {
                border-bottom: 2px solid #009879;
                font-family: 'Oswald', sans-serif;
                
            }

            .styled-table tbody tr.active-row {
                font-weight: bold;
              
                color: #009879;
            }

            .popup-button {
                font-family: 'Oswald', sans-serif;
                display: inline-block;
                font-size: 13px;
                margin-right: 7px;
                padding: 3px 7px;
                background-color: grey;
                border: 2px solid black;
                cursor: pointer;
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 5px;
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
                background-color: black;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid orange;
                width: 40%;
            }

            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .logo {
                position: absolute;
                margin-bottom: 300px;
                margin-left: 390px;
                width: 150px;
                height: 150px;
                opacity: 0.7;
            }

            

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

            .info {
                position: absolute;
                font-family: 'Oswald', sans-serif;
                font-size: 10px;
                top: 420px;
            }

            .win-chance-input {
                font-family: 'Oswald', sans-serif;
            }
         
            #dice1{
              width: 100px;
              position: absolute;
              bottom: 370px;
              left: 40px;
              transform: rotate(70deg);
              transform: rotate(0.25turn);
            }
            #dice2{
              bottom: 400px;
              position: absolute;
              width: 100px;   
              left: 90px;
              
              transform: rotate(40deg);
              transform: rotate(-0.25turn);
          }
          #winthe{
            position: absolute;
            width: 300px;
            top: 60px;
            right: 300px;
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
                <img src="{{ asset('icons/dice.png') }}" id= "dice1"  alt="Cahoot Logo">
                <img src="{{ asset('icons/dice.png') }}" id= "dice2"  alt="Cahoot Logo">
                <form class="form-container" method="POST" action="{{ route('dice.play') }}">
                  @csrf
                  <div class="win-chance-input">
                      <label for="winChanceDisplay">Choose number  </label>
                      <input type="text" id="winChanceDisplay" readonly style="color: black; border-radius: 10px;" disabled>
                        </div>
                  <div class="bet-container">
                    <label for="betAmount">Bet Amount:</label>
                    <input type="hidden" name="winChance" id="winChanceInput" value="{{ $winChance }}" style="border-radius: 6px; width: 20px;">
                    <div class="bet-input-modifiers">
                      <input type="number" id="betAmount" placeholder="0.00" name="betAmount" min="1" max="{{ $balance }}" value="{{ session('betAmount', $betAmount) }}" required>
                      <div class="bet-modifiers">
                        <button id="btn01" class="modifier-button">0.1</button>
                        <button id="btn1" class="modifier-button">1</button>
                        <button id="btn10" class="modifier-button">10</button>
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
                  <button id="button1"style="margin-left: 2px;" class="popup-button">Jackpot</button>
                  <button id="button2" style="margin-left: 65px;" class="popup-button">Fairness</button>
              </div>
              <img src="{{ asset('icons/winthejackpot.png') }}" alt="Cahoot Logo" id="winthe">

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
                      <img src="{{ asset('img/coins2.png') }}" alt="Coin Icon" height="20px" width="20px" >
                      <span class="jackpot-value">{{ $jackpotCoins }}  </span>

                      </div>
              

                    <div class= "mid-div">
                      <input type="range" min="5" max="95" value="{{ session('winChance', $winChance) }}" id="slider" name="winChance" style="width: 600px;">
                      <div id="selector">
                          <div class="selectBtn"></div>
                          <div id="selectValue"></div>
                      </div>
                    </div>
                      <div class="win-info">
                          <div class="win-chance" style="display: inline-block;">
                              <p>Win Chance:<br> </p><span id="win-chance">{{ $winChance }}</span>%
                          </div>
                          <div class="payout" style="display: inline-block; margin-left: 10px;">
                              <p>Multiplier:<br></p> <span id="payout">{{ $payout }}</span>x
                          </div>
                          <div class="win-amount" style="display: inline-block; margin-left: 10px;">
                              <p>Win Amount:<br></p> $<span id="win-amount" style="prosent">{{ $winAmount }}</span>
                          </div>
                      </div>

                      <div class="info">
                            1 ethdice coin is worth approximately $0.5. Chance of winning jackpot is 1/100 000 when betting atleast 1 coin. <br>
                            Chosen win chance does not matter - chance of winning the jackpot stays the same! 

                      </div>
              </form>
              </div>
            </div>
            <div class="live-container">
              <table id="new-games-table" class="styled-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Bet Amount</th>
                        <th>Win Chance</th>
                        <th>Won</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lastGames as $game)
                        <tr>
                            <td>{{ $game->user->name }}</td>
                            <td>{{ $game->bet_amount }}</td>
                            <td>{{ $game->win_chance }}</td>
                            
                            <td>{{ $game->win_amount }}</td>
                          
                           
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
document.getElementById("btn01").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = 0.1;
});
document.getElementById("btn1").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = 1;
});
document.getElementById("btn10").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = 10;
});
document.getElementById("btn2x").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = parseFloat(betAmount.value) * 2;
});

document.getElementById("btnMin").addEventListener("click", function(event) {
  event.preventDefault();
  var betAmount = document.getElementById("betAmount");
  betAmount.value = 0.1;
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

    
        
       