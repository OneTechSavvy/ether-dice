<!DOCTYPE html>
<html lang="en">
    @php
    $diceHouse = \App\Models\House::where('name', 'DiceHouse')->first();
    $balance = $diceHouse ? $diceHouse->coins : 0;
@endphp
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ethdice Dashboard</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />


    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
       .button {
    display: inline-block;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    border: 1px solid transparent;
    border-radius: 4px;
    text-decoration: none;
}

.confirm {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.confirm:hover {
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
}

.reject {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.reject:hover {
    color: #fff;
    background-color: #c82333;
    border-color: #bd2130;
} 
    </style>    

</head>

<body>

    <section id="menu">
        <div class="logo">
            <img src="img/logo.png" alt="">
            <h2>Dynamic</h2>
        </div>

        <div class="items">
            <li><i class="fas fa-chart-pie-alt"></i><a href="#">Dashboard</a></li>
            <li><i class="fab fa-uikit"></i><a href="#">UI Elements</a></li>
            <li><i class="fas fa-th-large"></i><a href="#">Tabels</a></li>
            <li><i class="fas fa-edit"></i></i><a href="#">Forms</a></li>
            <li><i class="fab fa-cc-visa"></i><a href="#">Cards</a></li>
            <li><i class="fas fa-hamburger"></i><a href="#">Modal</a></li>
            <li><i class="fas fa-chart-line"></i><a href="#">Blank</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fas fa-bars"></i>
                </div>
                <div class="search">
                    <i class="far fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>

            <div class="profile">
                <i class="far fa-bell"></i>
                <img src="img/1.jpg" alt="">
            </div>
        </div>

        <h3 class="i-name">
            Dashboard
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fas fa-users"></i>
                <div>
                    <h3>{{ $total_users }}</h3>
                    <span>Users</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-shopping-cart"></i>
                <div>
                    <h3>{{ $totalGames }}</h3>
                    <span>Total Games</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <h3>215,542</h3>
                    <span>Products Sell</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <h3>${{ $balance }}</h3>
                    <span>Dice Profit</span>
                </div>
            </div>
        </div>

        <section>
            <div class="board">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Type</td>
                            <td>Status</td>
                            <td>Coins</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                        <tr>
                            <td class="people">
                                <div class="people-de">
                                    <h5>{{ $withdrawal->user->name }}</h5>
                                    <p>{{ $withdrawal->user->email }}</p>
                                </div>
                            </td>
                            <td class="people-desig">
                                <h5>{{ $withdrawal->eth_address ? 'ETH' : 'BNB' }}</h5>
                                <p>{{ $withdrawal->eth_address ?? $withdrawal->bnb_address }}</p>
                            </td>
                            <td class="status">
                                <p>{{ $withdrawal->status }}</p>
                            </td>
                            <td class="coins">
                                <p>{{ $withdrawal->coins }}</p>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('withdrawals.approve', $withdrawal->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="button confirm">Confrim</button>
                                </form>
                                <form method="POST" action="{{ route('withdrawals.reject', $withdrawal->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="button reject" >Rejected </button>
                                </form>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>


    <script>
        $('#menu-btn').click(function() {
            $('#menu').toggleClass("active");
        })
    </script>

</body>

</html>