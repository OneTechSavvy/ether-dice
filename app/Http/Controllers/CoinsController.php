<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CoinsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('coins.index', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $coins = $request->input('coins');

        $user->coins = $coins;
        $user->save();

        return redirect()->route('coins.index')->with('success', 'Coins updated successfully.');
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $coins = $request->input('coins');

        $user->coins += $coins;
        $user->save();

        return redirect()->route('coins.index')->with('success', 'Coins added successfully.');
    }

    public function subtract(Request $request)
    {
        $user = Auth::user();
        $coins = $request->input('coins');

        if ($user->coins >= $coins) {
            $user->coins -= $coins;
            $user->save();
            return redirect()->route('coins.index')->with('success', 'Coins subtracted successfully.');
        } else {
            return redirect()->route('coins.index')->with('error', 'Insufficient balance.');
        }
    }
}
