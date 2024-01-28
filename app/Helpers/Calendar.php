<?php

namespace App\Helpers;

use App\Models\Task;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class Calendar
{
    public static DateTime $start_date;
    public static DateTime $end_date;
    public static string $current_month;
    public static string $current_year;
    public static Collection $tasks;
    public static array $calendar_header;

    public function __construct(string $year, string $month)
    {
        self::$current_month = $month;
        self::$current_year = $year;
        $min_max = self::getMinMaxDatesOfMonth();
        self::$start_date = new DateTime($min_max["minDate"]);
        self::$end_date = new DateTime($min_max["maxDate"]);
        self::generateHeader();
    }

    private static function generateHeader(): void
    {
        self::$calendar_header = array(
            self::getDayName(date('Y-m-d', strtotime('Monday'))),
            self::getDayName(date('Y-m-d', strtotime('Tuesday'))),
            self::getDayName(date('Y-m-d', strtotime('Wednesday'))),
            self::getDayName(date('Y-m-d', strtotime('Thursday'))),
            self::getDayName(date('Y-m-d', strtotime('Friday'))),
            self::getDayName(date('Y-m-d', strtotime('Saturday'))),
            self::getDayName(date('Y-m-d', strtotime('Sunday'))),
        );
    }

    public static function setTasks(Collection $tasks): void
    {
        self::$tasks = $tasks;
    }

    public static function getEventOfDay(string $date): string
    {
        $tasksInDay = [];

        foreach (self::$tasks as $object) {
            // Assuming each object has a 'date' property
            if (isset($object->date) && $object->date->format("Y-m-d") == $date) {
                $tasksInDay[] = self::generateTask($object);
            }
        }

//        print_r(self::$tasks->pluck("date"));

        return join("", $tasksInDay);
    }

    public static function getMinMaxDatesOfMonth(): false|array
    {
        // Ensure valid month and year
        if (self::$current_month < 1 || self::$current_month > 12 || !is_numeric(self::$current_year) || !is_numeric(self::$current_month)) {
            return false;
        }

        // Get the first day of the month
        $firstDayOfMonth = new DateTime(self::$current_year . "-" . self::$current_month . "-01");

        // Get the last day of the month
        $lastDayOfMonth = new DateTime($firstDayOfMonth->format('Y-m-t'));

        // Format the dates as strings
        $minDate = $firstDayOfMonth->format('Y-m-d');
        $maxDate = $lastDayOfMonth->format('Y-m-d');

        return array('minDate' => $minDate, 'maxDate' => $maxDate);
    }

    public static function generateMonthArray(): array
    {
        $monthArray = array();

        // Loop through each week
        while (self::$start_date <= self::$end_date) {
            // Add the week to the month array
            $monthArray[] = self::getWeekFromDate(self::$start_date->format("Y-m-d"));

            // Move to the next week
            self::$start_date->modify('+7 days');
        }

        return $monthArray;
    }

    public static function getWeekFromDate($date): array
    {
        $currentDate = new DateTime($date);

        // Find the Monday of the week
        while ($currentDate->format('N') != 1) {
            $currentDate->modify('-1 day');
        }

        $week = array();

        // Get dates for the entire week
        for ($i = 0; $i < 7; $i++) {
            $week[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
        }

        return $week;
    }

    public static function isDateInMonth(string $date): bool
    {
        // Create DateTime objects for the given date and the first day of the month
        $inputDate = new DateTime($date);

        $min_max_date = self::getMinMaxDatesOfMonth();

        return $inputDate >= new DateTime($min_max_date["minDate"]) && $inputDate <= new DateTime($min_max_date["maxDate"]);
    }

    private static function generateTask(Task $task): string
    {
        $redirect = route("task.show", compact("task"));
        return <<<HTML
            <a href="{$redirect}"><div class="bg-gray-200 py-1 px-2 rounded dark:bg-gray-700 dark:text-white">{$task->name}</div></a>
        HTML;
    }

    public static function getMonthName(): string
    {
        return ucwords((new Carbon())->createFromFormat('!m', self::$current_month)->translatedFormat("F"));
    }

    public static function getDayName(string $day): string
    {
        return ucwords((new Carbon())->createFromFormat('Y-m-d', $day)->translatedFormat("l"));
    }
}
