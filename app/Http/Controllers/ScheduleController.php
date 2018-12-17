<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $users = User::all();
        view()->share('users', $users);
    }

    public function index()
    {
        $schedules = Schedule::whereRaw('date(initial_date)', '>=', 'date(now())')
            ->whereRaw('date(final_date)', '<=', 'date(now())')->get();
        return view('schedule.index', compact('schedules'));
    }

    public function fetchAll()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    public function create()
    {
        return view('schedule.create');
    }

    public function store(Request $request)
    {
        $dates = explode(' - ', $request->get('dates'));
        $schedule = new Schedule();
        $schedule->customer_id = $request->get('customer_id');
        $schedule->from_user_id = auth()->user()->id;
        $schedule->to_user_id = $request->get('to_user_id');
        $schedule->description = $request->get('description');
        $schedule->initial_date = $this->convertDate($dates[0]);
        $schedule->final_date = $this->convertDate($dates[1]);
        $schedule->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Sucesso ao adicionar agendamento']);
        return redirect()->route('schedule.index');
    }

    protected function convertDate($date)
    {
        $newDate = Carbon::createFromFormat('d/m/Y H:i:s', $date);
        return $newDate->format('Y-m-d H:i:s');
    }
}
