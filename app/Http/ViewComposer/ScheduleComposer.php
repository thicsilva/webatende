<?php

namespace App\Http\ViewComposer;
use App\Schedule;
use Illuminate\View\View;

class ScheduleComposer
{
    protected $schedules;

    public function __construct()
    {
        $this->schedules = Schedule::whereRaw('date(initial_date)<=date(now())')
        ->whereRaw('date(final_date)>=date(now())')
        ->orderBy('initial_date')
        ->orderBy('final_date')
        ->get();
    }

    public function compose(View $view)
    {
        $view->with('schedules', $this->schedules);
    }
}
