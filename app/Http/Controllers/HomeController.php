<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Call;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $users = User::all();
        view()->share('users', $users);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calls = Call::where('to_user_id', auth()->user()->id)
            ->where('status', false)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        return view('home', compact('calls'));
    }
}
