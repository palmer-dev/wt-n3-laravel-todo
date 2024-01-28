<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 mb-8 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                 x-data="{ open: {{count($errors->all()) > 0 ? "true" : "false"}} }">
                <div @click="open = ! open"
                     class="flex justify-between items-center text-gray-900 dark:text-gray-100 text-xl text-bold">
                    <span>{{ __("Create task") }}</span>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white transition-transform"
                         :class="{'rotate-180':  open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 14 8">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
                    </svg>
                </div>
                <form x-show="open" action="{{route("task.store")}}" class="pt-6 grid gap-6 md:grid-cols-2"
                      method="post">
                    @method("POST")
                    @csrf
                    <x-input name="name" placeholder="Nom de la tâche" :label="__('Task')"
                             :messages="$errors->first('name')" :default-value="old('name')"/>

                    <x-input name="date" type="datetime-local" :label="__('Date')"
                             :messages="$errors->first('date')" :default-value="old('date')"/>

                    <div class="mb-6">
                        <label for="categories"
                            @class(["text-red-700 dark:text-red-500" => $errors->first("categories"), "block mb-2 text-sm font-medium text-gray-900 dark:text-white"=>true])>{{__("Categories")}}</label>
                        @if(!$errors->first("categories"))
                            <select multiple id="categories" name="categories[]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @else
                                    <select multiple id="categories" name="categories[]"
                                            class="bg-red-50 border-red-500 border text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @endif
                                        @for($i = 0; $i < count($categories); $i++)
                                            @php
                                                $category = $categories[$i];
                                            @endphp
                                            <option
                                                value="{{ $category->id }}" {{in_array($category->id , old("categories",[])) ? "selected" : ""}}>{{$category->name}}</option>
                                        @endfor
                                    </select>
                                    @error('categories.*')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{$message}}</p>
                            @enderror
                    </div>

                    <x-input name="comment" type="text" :multiline="true" :label="__('Details')"
                             :messages="$errors->first('comment')" :default-value="old('comment')"/>
                    <div class="flex justify-end col-span-2">
                        <x-primary-button>{{__("Save")}}</x-primary-button>
                    </div>
                </form>
            </div>
            <div class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg">
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
                    @forelse($tasks->items() as $task)
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
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" colspan="4"
                                class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{__("No task")}}
                            </th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{$tasks->links()}}
        </div>
    </div>
</x-app-layout>
