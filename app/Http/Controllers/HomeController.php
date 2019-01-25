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

        if($callsMonthBefore==0){
            $compareMonth=0;
        } else {
            $compareMonth = (($callsMonth - $callsMonthBefore) / $callsMonthBefore) * 100;
        }

        $schedules = Schedule::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();

        $schedulesForYou = Schedule::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('to_user_id', auth()->user()->id)
            ->count();

        $callsForYou = Call::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('to_user_id', auth()->user()->id)
            ->count();

        $customers = Customer::all()->count();

        $weather = $this->weatherStatus();
        // dd($weather, date('d/m/Y H:i:s', $weather->list[0]->dt));


        return view('home', compact('calls', 'callsMonth', 'compareMonth', 'customers', 'schedules', 'schedulesForYou', 'callsForYou', 'weather'));
    }

    public function chart()
    {
        $cache = cache('chart');
        if ($cache){
            return response()->json($cache);
        }

        $return = DB::table('calls')
            ->select(DB::raw('count(*) as total, users.name'))
            ->join('users', 'users.id', '=', 'calls.to_user_id')
            ->whereYear('calls.created_at', date('Y'))
            ->whereMonth('calls.created_at', date('m'))
            ->groupBy('users.name')
            ->get();
        cache(['chart' => $return], now()->addHours(2));
        return response()->json($return);
    }

    protected function weatherStatus()
    {
        if (isset($_COOKIE['lat']) && isset($_COOKIE['long'])){
            $lat = $_COOKIE['lat'];
            $long = $_COOKIE['long'];
        } else {
            $lat = '-22.3287233';
            $long = '-49.0763549';
        }
        $cache = cache('weather');
        if ($cache){
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
        cache(['weather'=> $cache], now()->addMinutes(30));
        return $cache;
    }
}
