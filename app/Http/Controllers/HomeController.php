<?php

namespace App\Http\Controllers;

use App\Call;
use App\Customer;
use App\User;

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
            ->limit(5)
            ->get();

        $callsMonth = Call::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();
        if (date('m') == 1) {
            $callsMonthBefore = Call::whereYear('created_at', date('Y', strtotime('-1 year')))
                ->whereMonth('created_at', date('m', strtotime('-1 month')))
                ->count();
        } else {
            $callsMonthBefore = Call::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m', strtotime('-1 month')))
                ->count();
        }

        $compareMonth = (($callsMonth - $callsMonthBefore) / $callsMonthBefore) * 100;

        $callsWeek = Call::whereYear('created_at', date('Y'))
            ->whereRaw("WEEK('created_at')= WEEK(now())")
            ->count();

        $callsForYou = Call::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('to_user_id', auth()->user()->id)
            ->count();

        $customers = Customer::all()->count();

        return view('home', compact('calls', 'callsMonth', 'compareMonth', 'customers', 'callsWeek', 'callsForYou'));
    }
}
