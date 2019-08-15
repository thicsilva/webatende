<?php

namespace App\Http\Controllers;

use App\Call;
use App\Customer;
use App\Schedule;
use App\User;
use Illuminate\Support\Facades\DB;

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

        $users = User::active()->orderBy('name')->get();
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

        if ($callsMonthBefore == 0) {
            $compareMonth = 0;
        } else {
            $compareMonth = (($callsMonth - $callsMonthBefore) / $callsMonthBefore) * 100;
        }

        $schedules = Schedule::whereYear('initial_date', date('Y'))
            ->whereMonth('initial_date', date('m'))
            ->count();

        $schedulesForYou = Schedule::whereYear('initial_date', date('Y'))
            ->whereMonth('initial_date', date('m'))
            ->where('to_user_id', auth()->user()->id)
            ->count();

        $callsForYou = Call::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('to_user_id', auth()->user()->id)
            ->count();

        $customers = Customer::all()->count();

        $weather = $this->weatherStatus();

        $lastMonth = \Carbon\Carbon::now()->subMonth()->formatLocalized('%B');

        return view('home', compact('calls', 'callsMonth', 'compareMonth', 'customers', 'schedules', 'schedulesForYou', 'callsForYou', 'weather', 'lastMonth'));
    }

    public function chart()
    {

        $return = DB::table('calls')
            ->select(DB::raw('count(*) as total, users.name'))
            ->join('users', 'users.id', '=', 'calls.to_user_id')
            ->where('users.active', true)
            ->whereYear('calls.created_at', date('Y'))
            ->whereMonth('calls.created_at', date('m'))
            ->groupBy('users.name')
            ->get();
        return response()->json($return);
    }

    protected function weatherStatus()
    {
        if (isset($_COOKIE['lat']) && isset($_COOKIE['long'])) {
            $lat = $_COOKIE['lat'];
            $long = $_COOKIE['long'];
        } else {
            $lat = '-22.3287233';
            $long = '-49.0763549';
        }
        $cache = cache($lat . $long);
        if ($cache) {
            return $cache;
        }
        $url = 'http://api.openweathermap.org/data/2.5/forecast/daily?';
        $data['lat'] = $lat;
        $data['lon'] = $long;
        $data['units'] = 'metric';
        $data['cnt'] = '8';
        $data['lang'] = 'pt';
        $data['appid'] = '47e253310c06b077862a788dd3d168e3';
        $query = http_build_query($data);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . $query,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $exec = curl_exec($curl);
        $cache = json_decode($exec);
        cache([$lat . $long => $cache], now()->addMinutes(30));
        return $cache;
    }
}
