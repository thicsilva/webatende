<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\ScheduleCreated;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $users = User::all();
        view()->share('users', $users);
    }

    public function index()
    {
        $schedules = Schedule::whereRaw('date(initial_date)<=date(now())')
            ->whereRaw('date(final_date)>=date(now())')
            ->orderBy('initial_date')
            ->orderBy('final_date')
            ->get();
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
        $request->validate([
            'customer_id' => 'required',
            'description' => 'required',
            'dates' => 'required'
        ]);
        $data = [];
        $dates = explode(' - ', $request->get('dates'));
        $data['customer_id'] = $request->get('customer_id');
        $data['from_user_id'] = auth()->user()->id;
        $data['to_user_id'] = $request->get('to_user_id');
        $data['description'] = $request->get('description');
        $data['initial_date'] = $this->convertDate($dates[0]);
        $data['final_date'] = $this->convertDate($dates[1]);
        $schedule = Schedule::create($data);
        event(new ScheduleCreated($schedule));
        session()->flash('alert', ['type' => 'success', 'message' => 'Sucesso ao adicionar agendamento']);
        return redirect()->route('schedule.index');
    }

    public function edit(Schedule $schedule)
    {
        $schedule = Schedule::findOrfail($schedule->id);
        return view('schedule.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'customer_id' => 'required',
            'description' => 'required',
            'dates' => 'required'
        ]);
        $data = [];
        $dates = explode(' - ', $request->get('dates'));
        $data['customer_id'] = $request->get('customer_id');
        $data['from_user_id'] = auth()->user()->id;
        $data['to_user_id'] = $request->get('to_user_id');
        $data['description'] = $request->get('description');
        $data['initial_date'] = $this->convertDate($dates[0]);
        $data['final_date'] = $this->convertDate($dates[1]);
        $schedule->fill($data);
        $schedule->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Sucesso ao alterar agendamento']);
        return redirect()->back();
    }

    public function show(Schedule $schedule)
    {
        $schedule = Schedule::findOrFail($schedule->id);
        return view('schedule.show', compact('schedule'));
    }

    public function delete(Schedule $schedule)
    {
        $schedule = Schedule::findOrFail($schedule->id);
        $schedule->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Agendamento excluído']);
        return redirect()->route('schedule.index');
    }

    protected function convertDate($date)
    {
        $newDate = Carbon::createFromFormat('d/m/Y H:i:s', $date);
        return $newDate->format('Y-m-d H:i:s');
    }
}
