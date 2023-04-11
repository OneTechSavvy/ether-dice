@extends('layouts.test')

@section('title', 'Coinflip')

@section('content')
    <style>
        .main-container {
            padding: 20px;
        }

        .top-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .my-games-container,
        .live-games-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(355px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .game-card {
          display: flex;
          border-radius: 10px; /* Add this line to round the corners */
            padding: 20px;
            height: 200px;
            background: #212121;
            box-shadow: 15px 15px 15px rgb(25, 25, 25),
                -15px -15px 10px rgb(60, 60, 60);
        }
        .vs-container {
  display: flex;
  align-items: center;
  width: 30px;
  padding: 10px;
  justify-content: center;
}
.vs-text {
  font-size: 18px; /* Adjust font size as needed */
  color: white;
  margin: 0; /* Remove any default margin */
  padding: 0; /* Remove any default padding */
}
        
.player-card {
  display: flex;
  height: 170px;
  border-radius: 10px; /* Add this line to round the corners */
  background: #383838;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 140px; /* Adjust width as needed */
}
.player-card-2 {
  display: flex;
  height: 170px;
  border-radius: 10px; /* Add this line to round the corners */
  background: #383838;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 140px; /* Adjust width as needed */
}
.join-container {
margin-bottom: 45px;
padding-top: 40px;
}
        .join-game-btn {
            display: inline-block;
            background-color: #27ae60;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }

        .join-game-btn:hover {
            background-color: #2ecc71;
        }
        body {
    color: #ffffff;
}
h2 {
  font-size: 30px;
  font-weight: bold;
  padding: 10px;
}
input[type="number"] {
  color: black;
}
.dots-container {
  display: flex;
  align-items: center;
}

.dot {
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin-right: 10px;
  cursor: pointer;
  border: 2px solid #ccc;
}

.dot-heads {
  background-color: #fff;
}

.dot-tails {
  background-color: #000;
}

.dot.active {
  border-color: #27ae60;
}

#chosen_side {
  display: none;
}
.coin-container {
  width: 200px;
  height: 200px;
  position: relative;
}

#coin {
  position: relative;
  margin: 0 auto;
  width: 100px;
  height: 100px;
  cursor: pointer;
}
#coin div {
  width: 100%;
  height: 100%;
  -webkit-border-radius: 50%;
     -moz-border-radius: 50%;
          border-radius: 50%;
  -webkit-box-shadow: inset 0 0 45px rgba(255,255,255,.3), 0 12px 20px -10px rgba(0,0,0,.4);
     -moz-box-shadow: inset 0 0 45px rgba(255,255,255,.3), 0 12px 20px -10px rgba(0,0,0,.4);
          box-shadow: inset 0 0 45px rgba(255,255,255,.3), 0 12px 20px -10px rgba(0,0,0,.4);
}
.side-a {
     background-image: url('{{ asset('icons/ethcoin.png') }}');
    background-size: cover;
    background-position: center;
  }

  .side-b {
    background-image: url('{{ asset('icons/bnbcoin.png') }}');
    background-size: cover;
    background-position: center;
  }

#coin {
  transition: -webkit-transform 1s ease-in;
  -webkit-transform-style: preserve-3d;
}
#coin div {
  position: absolute;
  -webkit-backface-visibility: hidden;
}
.side-a {
  z-index: 100;
}
.side-b {
  -webkit-transform: rotateY(-180deg);

}

#coin.heads {
  -webkit-animation: flipHeads 3s ease-out forwards;
  -moz-animation: flipHeads 3s ease-out forwards;
    -o-animation: flipHeads 3s ease-out forwards;
       animation: flipHeads 3s ease-out forwards;
}
#coin.tails {
  -webkit-animation: flipTails 3s ease-out forwards;
  -moz-animation: flipTails 3s ease-out forwards;
    -o-animation: flipTails 3s ease-out forwards;
       animation: flipTails 3s ease-out forwards;
}


.profile-picture {
  width: 75px;
  height: 75px;
  border-radius: 50%;
  margin-bottom: 10px;
  margin-top: 10px;
}
.username {
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 5px;
}
.coin-icon {
  width: 20px;
  height: 20px;
  vertical-align: middle;
  margin-right: 8px;
}
.coin-box {
  display: inline-flex;
  background-color: black;
  border-radius: 2px;
  padding: 3px 6px;
  border: 2px solid orange;
  border-radius: 5px;
  padding: 5px;
  align-items: center;
  justify-content: center;
}

.coin-balance {
  display: inline-block;
  margin: 1px;
  font-size: 14px;
  font-weight: bold;
}

@-webkit-keyframes flipHeads {
  from { -webkit-transform: rotateY(0); -moz-transform: rotateY(0); transform: rotateY(0); }
  to { -webkit-transform: rotateY(1800deg); -moz-transform: rotateY(1800deg); transform: rotateY(1800deg); }
}
@-webkit-keyframes flipTails {
  from { -webkit-transform: rotateY(0); -moz-transform: rotateY(0); transform: rotateY(0); }
  to { -webkit-transform: rotateY(1980deg); -moz-transform: rotateY(1980deg); transform: rotateY(1980deg); }
}


    </style>
    
    <body>
      <div class="main-container">
        <div class="top-container" style="display: flex; justify-content: space-between;">
          <div>
            <h2 style="font-size: 36px; font-weight: bold;">COINFLIP</h2>
          </div>
          <div style="display: flex; align-items: center;">
            <form action="{{ route('coinflip.create_game') }}" method="POST" style="display: flex;">
              @csrf
              <label for="bet_amount" style="margin-right: 10px;">Bet Amount:</label>
              <input type="number" name="bet_amount" id="bet_amount" required style="padding: 5px; border-radius: 5px; border: none; margin-right: 10px; color: black;">
              <label for="chosen_side" style="margin-right: 10px;">Choose a side:</label>
              <div class="dots-container">
                <input type="hidden" name="chosen_side" id="chosen_side" value="heads">
                <span class="dot dot-heads active"></span>
                <span class="dot dot-tails"></span>
              </div>
              <button type="submit" class="btn">Create Game</button>
            </form>
          </div>
        </div>
        <div class="my-games-wrapper">
          <h2 class="heading-secondary">My Games</h2>
          <div class="my-games-container">
            @forelse ($openGames as $game)
            <div class="game-card">
              <div class="player-card">
                <div class="profile-picture {{ $game->chosen_side == 'a' ? 'side-a' : 'side-b' }}"></div>
                <div class="player-info">
                  <div class="username">{{ $game->user->name }}</div>
                  <div class="coin-box">
                    <img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">
                    <p class="coin-balance">{{ $game->bet_amount }}</p>
                  </div>
                </div>
              </div>
            
              <div class="vs-container">
                <p class="vs-text">VS</p>
              </div>
            
              <div class="player-card-2">
                <!-- Add a second player-card structure here, you can replace the data with appropriate values -->
                <div class="join-container">
                  @if (auth()->check() && $game->user_id != auth()->user()->id)
                  <form id="join-form-{{ $game->id }}" action="{{ route('coinflip.join_game', $game->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">Join Game</button>
                  </form>
                  @endif
                </div>
                <div class="coin-box">
                  <img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">
                  <p class="coin-balance">{{ $game->bet_amount }}</p>
                </div>
              </div>
            </div> <!-- Make sure this closing div tag is placed here -->
            @empty
            <p>No games found.</p>
            @endforelse
          </div>
        </div>
        <div class="live-games-wrapper">
          <h2 class="heading-secondary">Live Games</h2>
          <div class="live-games-container" id="open-games-container">
            @forelse ($openGames as $game)
            <div class="game-card">
              <div class="player-card">
                <div class="profile-picture {{ $game->chosen_side == 'a' ? 'side-a' : 'side-b' }}"></div>
                <div class="player-info">
                  <div class="username">{{ $game->user->name }}</div>
                  <div class="coin-box">
                    <img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">
                    <p class="coin-balance">{{ $game->bet_amount }}</p>
                  </div>
                </div>
              </div>
            
              <div class="vs-container">
                <p class="vs-text">VS</p>
              </div>
            
              <div class="player-card-2">
                <!-- Add a second player-card structure here, you can replace the data with appropriate values -->
                <div class="join-container">
                  @if (auth()->check() && $game->user_id != auth()->user()->id)
                  <form id="join-form-{{ $game->id }}" action="{{ route('coinflip.join_game', $game->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">Join Game</button>
                  </form>
                  @endif
                </div>
                <div class="coin-box">
                  <img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">
                  <p class="coin-balance">{{ $game->bet_amount }}</p>
                </div>
              </div>
            </div> <!-- Make sure this closing div tag is placed here -->
            @empty
            <p>No games found.</p>
            @endforelse
          </div>
      </div>
    </body>
<script>
 const dots = document.querySelectorAll('.dot');
dots.forEach(dot => {
  dot.addEventListener('click', (e) => {
    // Remove active class from all dots
    dots.forEach(dot => dot.classList.remove('active'));
    // Set active class to clicked dot
    e.target.classList.add('active');
    // Update chosen_side input value
    const chosenSideInput = document.querySelector('#chosen_side');
    chosenSideInput.value = e.target.classList.contains('dot-heads') ? 'heads' : 'tails';
  });
});   

jQuery(document).ready(function($){

$('#coin').on('click', function(){
  var flipResult = Math.random();
  $('#coin').removeClass();
  setTimeout(function(){
    if(flipResult <= 0.5){
      $('#coin').addClass('heads');
      console.log('it is head');
    }
    else{
      $('#coin').addClass('tails');
      console.log('it is tails');
    }
  }, 100);
});
});


document.addEventListener('DOMContentLoaded', function() {
    var source = new EventSource("{{ route('coinflip.sse') }}");

    source.onmessage = function(event) {
        var openGames = JSON.parse(event.data);
        var openGamesHtml = '';

        for (var i = 0; i < openGames.length; i++) {
    var game = openGames[i];
    // Update the HTML structure based on the data you want to display
    openGamesHtml += '<div class="game-card">';

    // Player 1
    openGamesHtml += '<div class="player-card">';
    openGamesHtml += '<div class="profile-picture ' + (game.chosen_side == 'a' ? 'side-a' : 'side-b') + '"></div>';
    openGamesHtml += '<div class="player-info">';
    openGamesHtml += '<div class="username">' + game.user.name + '</div>';
    openGamesHtml += '<div class="coin-box">';
    openGamesHtml += '<img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">';
    openGamesHtml += '<p class="coin-balance">' + game.bet_amount + '</p>';
    openGamesHtml += '</div></div></div>';

    // VS container
    openGamesHtml += '<div class="vs-container"><p class="vs-text">VS</p></div>';

// Player 2
      openGamesHtml += '<div class="player-card-2" data-game-id="' + game.id + '">';

    // Check for game status and remove join-container if game is active
    if (game.status === 'active') {
    const joinContainer = document.querySelector(`.player-card-2[data-game-id="${game.id}"] .join-container`);
    if (joinContainer) {
        joinContainer.remove();
      }
    openGamesHtml += '<div class="profile-picture ' + (game.chosen_side_2 == 'a' ? 'side-a' : 'side-b') + '"></div>';
    openGamesHtml += '<div class="player-info">';
    openGamesHtml += '<div class="username">' + game.user_2.name + '</div>';
    openGamesHtml += '<div class="coin-box">';
    openGamesHtml += '<img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">';
    openGamesHtml += '<p class="coin-balance">' + game.bet_amount_2 + '</p>';
    openGamesHtml += '</div></div></div>';
} else {
        @if (auth()->check() && isset($game) && $game->user_id != auth()->user()->id)
        openGamesHtml += '<div class="join-container">';
        openGamesHtml += '<form id="join-form-' + game.id + '" action="{{ route('coinflip.join_game', '') }}/' + game.id + '" method="POST">';
        openGamesHtml += '@csrf';
        openGamesHtml += '<button type="submit" class="join-game-btn">Join Game</button>';
        openGamesHtml += '</form>';
        openGamesHtml += '</div>';
        @endif

        openGamesHtml += '<div class="coin-box">';
        openGamesHtml += '<img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">';
        openGamesHtml += '<p class="coin-balance">' + game.bet_amount + '</p>';
        openGamesHtml += '</div></div>';
    }
    openGamesHtml += '</div>';
}
}
        


source.addEventListener('gamestatechange', function (event) {
    const gameData = JSON.parse(event.data);
    const playerCard2 = document.querySelector(`.player-card-2[data-game-id="${gameData.game_id}"]`);

    if (playerCard2) {
        if (gameData.status === 'active') {
            // Display user 2 information
            const profilePicture = document.createElement('div');
            profilePicture.className = `profile-picture ${gameData.chosen_side_2 === 'a' ? 'side-a' : 'side-b'}`;
            playerCard2.querySelector('.coin-box').className += ' green';
            playerCard2.querySelector('.vs-text').textContent = '';
            playerCard2.querySelector('.username').textContent = gameData.user_id_2;
            playerCard2.querySelector('.coin-balance').textContent = gameData.bet_amount_2;
        }

        if (gameData.status === 'completed') {
            // Display winner information
            const winnerElement = document.createElement('div');
            winnerElement.className = 'winner';
            winnerElement.textContent = gameData.winner === 'a' ? `The winner is: ${gameData.user_id}` : `The winner is: ${gameData.user_id_2}`;
            playerCard2.querySelector('.coin-balance').className += gameData.winner === 'a' ? ' green' : ' red';
            playerCard2.querySelector('.vs-text').textContent = '';
            playerCard2.appendChild(winnerElement);

            // Remove the game card after 5 seconds
            setTimeout(() => {
                playerCard2.closest('.game-card').remove();
            }, 5000);
        }
    }
});



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
})
    </script>
</html>
@endsection