<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pt-6">
                    <form id="calendar-filter" class="flex justify-between px-6 pb-6 items-center">
                        <div class="flex-1 text-xl text-gray-900 dark:text-gray-100">
                            {{ __("My Tasks") }}
                        </div>
                        <div class="flex-1 flex justify-center">
                            <select id="month" name="month"
                                    class="autoSend w-fit pr-10 bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <?php foreach (range(1, 12) as $month) : ?>
                                <option <?= $selectedMonth == $month ? "selected" : "" ?> value="<?=$month?>">
                                        <?= ucwords((new Carbon\Carbon())->createFromFormat('!m', $month)->translatedFormat("F")) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex-1 flex justify-end gap-1.5">
                            <input type="number" name="year" id="year" aria-describedby="helper-text-explanation"
                                   class="autoSend w-fit bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{$selectedYear}}" required>
                        </div>
                    </form>

                    <div class="rounded-xl overflow-hidden">
                        <div class="grid grid-cols-7 bg-gray-300 dark:bg-gray-600">
                            @foreach($calendar::$calendar_header as $day)
                                <div class="p-4 text-center dark:text-white last:border-r-0 border-r ">{{$day}}</div>
                            @endforeach
                        </div>
                        @foreach($calendar::generateMonthArray() as $week)
                            <div class="grid grid-cols-7 border-t">
                                @foreach($week as $day)
                                    <div class="p-4 last:border-r-0 border-r">
                                        <span @class(["opacity-25" => !$calendar::isDateInMonth($day), "dark:text-white" => true])>
                                            {{date($calendar::isDateInMonth($day) ? "d" : "d M", strtotime($day))}}
                                        </span>
                                        <div @class(["opacity-25" => !$calendar::isDateInMonth($day), "pt-2 flex flex-col gap-1.5" => true])>
                                            {!! $calendar::getEventOfDay($day) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Script to send automatically the filter form for the calendar
        document.addEventListener('DOMContentLoaded', function () {
            const inputFields = document.querySelectorAll('.autoSend');

            inputFields.forEach(inputField => {
                inputField.addEventListener('change', function () {
                    document.getElementById('calendar-filter').submit();
                });
            })
        });
    </script>
</x-app-layout>
