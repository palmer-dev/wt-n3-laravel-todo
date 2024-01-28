<?php

namespace App\Http\Controllers;

use App\Helpers\Calendar;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index(Request $request)
    {
        $selectedYear = $request->get("year") ?? date("Y");
        $selectedMonth = $request->get("month") ?? date("m");
        $calendar = new Calendar($selectedYear, $selectedMonth);
        $dates = $calendar::getMinMaxDatesOfMonth();
        $minDate = $calendar::getWeekFromDate($dates["minDate"])[0];
        $maxDate = $calendar::getWeekFromDate($dates["maxDate"])[6];
        $tasks = Task::where("date", ">=", $minDate)
            ->where("date", "<=", $maxDate)
            ->get();
        $calendar::setTasks($tasks);
        return view("dashboard", compact("calendar", "tasks", "selectedYear", "selectedMonth"));
    }
}
