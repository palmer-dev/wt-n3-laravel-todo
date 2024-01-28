<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="mb-6 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                <span style="">{{$task->name}}</span><span
                    class="font-medium text-base">{{$task->deadline}}</span>
            </h3>
            <div class="mb-6 flex flex-wrap gap-3">
                {!! $task->categories_names !!}
            </div>
            <p class="text-gray-700 dark:text-gray-300">
                {{nl2br($task->comment)}}
            </p>
        </div>
    </div>
</x-app-layout>
