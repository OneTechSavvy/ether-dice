<?php
namespace App\Http\Controllers;

use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Illuminate\Http\Request as AppRequest;
use App\Http\Controllers\Controller;
use App\Models\User;

class DepositController extends Controller
{
    public function showETHdepositform()
{
    return view('deposit.eth');
}
}


