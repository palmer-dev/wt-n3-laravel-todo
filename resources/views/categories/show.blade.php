<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') . " - " . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{__("Task name")}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__("Deadline")}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__("Categories")}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{__("Edit")}}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{route("task.show", compact("task"))}}">
                                    {{$task->name}}
                                </a>
                            </th>
                            <td class="px-6 py-4">
                                {{$task->date->format("d/m/Y H:i")}}
                            </td>
                            <td class="px-6 py-4 flex flex-wrap gap-3">
                                {!! $task->categories_names !!}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{route("task.edit", compact("task"))}}"
                                   class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{__("Edit")}}</a>
                                <form action="{{route("task.delete", compact("task"))}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit"
                                           class="cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                                           value="{{__("Delete")}}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
