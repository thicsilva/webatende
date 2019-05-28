<?php

namespace App\Http\ViewComposer;
use App\Schedule;
use Illuminate\View\View;

class ScheduleComposer
{
    protected $schedules;

    public function __construct()
    {
        $this->schedules = Schedule::whereRaw('date(initial_date)<=date(now())')->get();
    }

    public function compose(View $view)
    {
        $view->with('schedules', $this->schedules);
    }
}
