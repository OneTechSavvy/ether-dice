<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CahootBet') }}</title>

    <!-- Fonts -->

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-1WpdEfwIuvfgzJmBjK8UGl5X5v5x+jZ5Qj1i8DGwWQQLvCjKt/ybbJtj8bPss3qpr/7A1jbmGzMmjEpAz+fK3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap');
</style>

    <style>
       
body {  

        min-height:calc(100vh);
        background:#3b3b47;
        background:-moz-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);
        background:-webkit-gradient(left top,left bottom,color-stop(0,#202027),color-stop(19%,#202027),color-stop(50%,#3e3e4a),color-stop(80%,#202027),color-stop(100%,#202027));
        background:-webkit-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-o-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-ms-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%)}@media (max-width:767px){body{-webkit-user-select:none;
        -webkit-tap-highlight-color:transparent;-webkit-touch-callout:none}}img{max-width:100%
        }
        
.navbar-dark {
  background-color: #2C2C36;
  color: #ffffff;
  
}
.btn {
  background-color: orange;
  color: black;
  transition: all 0.5s ease;
  margin-right: 5px;

}
.btn:hover {
  color: black;
  opacity: 0.7;
}
.logo {
  width: 250px;
}

.navbar-brand {
  margin-left: 10px;
}

.navbar-nav li a img {
  height: 25px;
  margin-right: 8px;
}

.navbar {
    font-family: 'Oswald', sans-serif;
  color: #ffffff;
  border-bottom: 1px solid orange;

  
}

.nav-icon-coinflip {
    content: url(icons/coinfliptest.png);
    opacity: 1;
  transition: opacity 0.6s ease-in-out;
    
}
.nav-icon-jackpot {
    content: url(icons/jackpottest.png);
    opacity: 1;
  transition: opacity 0.6s ease-in-out;
    
}
.nav-icon-dice {
    content: url(icons/dicetest.png);
    opacity: 1;
  transition: opacity .6s ease-in-out;
    
}

.nav-icon-coinflip:hover {
    content: url(icons/coinfliptestorange.png);
    opacity: 0.5;
}


.nav-icon-jackpot:hover {
    content: url(icons/jackpottestorange.png);
    opacity: 0.7;
    
}
.nav-icon-dice:hover {
    content: url(icons/dicetestorange.png);
    opacity: 0.7;
    
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

.coin-box img {
  vertical-align: middle;
  margin-right: 8px;
  width: 25px;
  height: 25px;
  
}

.coin-balance {
  display: inline-block;
  margin: 1px;
  font-size: 14px;
  font-weight: bold;
}
footer {
  background-color: #16181F;
}

h3 {
  font-size: 24px;
  margin-bottom: 10px;
}

  
 
  h1 {
    font-size: 1.2rem;
    margin: 0;
  }
  .content-section {
    text-align: left;
    display: flex;
    flex-direction: column;
    
  }
  .link-container {
    display: flex;
    justify-content: center;
  }
.a {
    font-size: 12px;
    font-family: 'Oswald', sans-serif;
    color: #fff;
    text-decoration: none;
    margin-left: 25px;
    text-align: left;
  }
  .content {
  text-align: left;
  font-family: 'Oswald', sans-serif;
}
p {
  font-size: 12px;
  font-family: 'Oswald', sans-serif;
  margin-right: 310px;
}
#mains {
  overflow: auto;
  margin-top: 50px;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
#content{
  min-height: 100%;
  
}

#logo2 {
  position: relative;
  left: 50px;
  width: 8%;
  height: 8%; 
  transform: rotate(40deg);
              transform: rotate(-0.25turn);

}
#logo3 {
  position: relative;
  left: 10px;
 bottom: 10px;
 width: 8%;
  height: 8%; 
  transform: rotate(20deg);
              transform: rotate(-0.5turn);
}
#logo4 {
  position: relative;
  width: 30%;
  height: 30%; 
left: 50px;
 

}
#logobottom {
  position: relative;

  width: 35%;
  height: 35%; 

  left: 20px;

}
.dice-container {
  display: flex;
}
.backgroundclass {
min-height:calc(100vh);
        background:#3b3b47;
        background:-moz-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);
        background:-webkit-gradient(left top,left bottom,color-stop(0,#202027),color-stop(19%,#202027),color-stop(50%,#3e3e4a),color-stop(80%,#202027),color-stop(100%,#202027));
        background:-webkit-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-o-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-ms-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%)}@media (max-width:767px){body{-webkit-user-select:none;
        -webkit-tap-highlight-color:transparent;-webkit-touch-callout:none}}img{max-width:100%
        }

        .community img{
          width: 50px
        }

</style>
   
<script async src="https://www.googletagmanager.com/gtag/js?id=G-868DP62C77"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-868DP62C77');
</script>
     
</head>
<body>
  @stack('modals')

  @livewireScripts

  <div id="app">
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
            <div class="dice-container">

            <img src="{{ asset('icons/dice.png') }}"   alt="Ethdice Logo" id="logo2">
            <img src="{{ asset('icons/dice.png') }}"   alt="Ethdice Logo" id="logo3">
            <img src="{{ asset('icons/ethdice13.png') }}"   alt="Ethdice2 Logo" id="logo4">

          </div>
            </a>
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                 
                </ul>              
           

                <ul class="navbar-nav ml-auto">
                              <li class="nav-item">
                        <a href="{{ url('withdraw') }}" class="btn">Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('deposit') }}" class="btn">Deposit</a>
                    </li>
                    <li class="nav-item">
                        @auth
                        <div class="coin-box">
  <img src="{{ asset('img/coins.png') }}" alt="Coin Icon" height="20px" width="20px">
  <p class="coin-balance">{{ auth()->user()->coins }}</p>
</div>


<div class="dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ Auth::user()->name }}
  </a>
  <div class="dropdown-menu" aria-labelledby="user-dropdown">
    <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a> 
    <a class="dropdown-item" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
    </form>
  </div>
</div>


@endauth
                    @guest
                    <a class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endguest
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>        
<div id="content">
     <div id="mains">
      @yield('content')
      <br><br><br><br><br><br>
</div>
</div>
        
<footer class="flex text-white flex-col md:flex-row md:px-4 lg:px-48 xl:px-64 items-center md:items-start">
  <div class="flex flex-1 flex-column mt-4">
    <div class="dice-container">
      <img src="{{ asset('icons/ethdice13.png') }}" alt="Cahoot Logo" style="max-width: 220px">
    </div>
    <p class="m-0 ml-1 mt-4">Copyright© 2022 - 2023 ethdice.com - All rights reserved.
      <br>Contact: support@ethdice.com
    </p>
  </div>
  <div class="flex flex-1 mt-8">
    <div class="md:flex-1"></div>
    <div class="flex flex-1 flex-column font-bold">
      <h3 class="text-2xl">About</h3>
      <ul>
        <li><a href="#" class="text-xs hover:text-white">About</a></li>
        <li><a href="#" class="text-xs hover:text-white">Roadmap</a></li>
        <li><a href="/whitepaper" class="text-xs hover:text-white">Whitepaper</a></li>
        <li><a href="#" class="text-xs hover:text-white">Terms of Service</a></li>
      </ul>
    </div>
  </div>
  <div class="flex flex-1 mt-8">
    <div class="md:flex-1"></div>
    <div class="flex flex-1 flex-column">
      <h3 class="text-2xl font-bold">Community</h3>
      <div class="flex community gap-6">
        <a href="#"><img src="{{ asset('icons/twitter.png') }}" alt="Twitterlogo"></a>
        <a href="#"><img src="{{ asset('icons/telegram.png') }}" alt="Telegramlogo"></a>
        <br><br><br><br><br><br>
      </div>
    </div>
  </div>
</footer>
    </div>

   
    </div>
</div>
</body>
</html>