<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 mb-8 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center text-gray-900 dark:text-gray-100 text-xl text-bold">
                    <span>{{ __("Edit task") }}</span>
                </div>
                <form action="{{route("task.edit", compact("task"))}}" class="pt-6 grid gap-6 md:grid-cols-2"
                      method="post">
                    @method("PUT")
                    @csrf
                    <x-input name="name" placeholder="Nom de la tâche" :label="__('Task')"
                             :messages="$errors->first('name')" :default-value="old('name', $task->name)"/>

                    <x-input name="date" type="datetime-local" :label="__('Date')"
                             :messages="$errors->first('date')" :default-value="old('date', $task->date)"/>

                    <div class="mb-6 col-span-2">
                        <label for="categories"
                            @class(["text-red-700 dark:text-red-500" => $errors->first("categories"), "block mb-2 text-sm font-medium text-gray-900 dark:text-white"=>true])>Catégories</label>
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
                                                value="{{ $category->id }}" {{in_array($category->id , old("categories", $task->categories()->pluck("id")->toArray())) ? "selected" : ""}}>{{$category->name}}</option>
                                        @endfor
                                    </select>
                                    @error('categories.*')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{$message}}</p>
                            @enderror
                    </div>

                    <x-input class="col-span-2" name="comment" type="text" :multiline="true" :label="__('Details')"
                             :messages="$errors->first('comment')" :default-value="old('comment', $task->comment)"/>
                    <div class="flex justify-end col-span-2">
                        <x-primary-button>{{__('Save')}}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
