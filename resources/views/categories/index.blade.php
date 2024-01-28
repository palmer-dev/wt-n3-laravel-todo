<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 mb-8 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                 x-data="{ open: {{count($errors->all()) > 0 ? "true" : "false"}}  }">
                <div @click="open = ! open"
                     class="flex justify-between items-center text-gray-900 dark:text-gray-100 text-xl text-bold">
                    <span>{{ __("Create category") }}</span>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white transition-transform"
                         :class="{'rotate-180':  open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 14 8">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 5.326 5.7a.909.909 0 0 0 1.348 0L13 1"/>
                    </svg>
                </div>
                <form x-show="open" action="{{route("category.store")}}" class="pt-6 grid gap-6 md:grid-cols-2"
                      method="post">
                    @method("POST")
                    @csrf
                    <x-input name="name" placeholder="Nom" label="Nom" :default-value="old('name')"
                             :messages="$errors->first('name')"/>

                    <x-input name="color" placeholder="Couleur" type="color" :default-value="old('color')"
                             label="Couleur"
                             :messages="$errors->first('color')"/>

                    <div class="flex justify-end col-span-2">
                        <x-primary-button> Enregistrer</x-primary-button>
                    </div>
                </form>
            </div>
            <div class="mb-6 relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{__("Category name")}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__("Color")}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{__("Edit")}}</span>
                            <span class="sr-only">{{__("Delete")}}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{route("category.show", compact("category"))}}">
                                    {{$category->name}}
                                </a>
                            </th>
                            <td class="px-6 py-4">
                                <span
                                    style='border-radius: 0.25rem; padding:.25rem .5rem; background: {{$category->color}}; color: {{App\Helpers\ContrastColor::getContrastColor($category->color) }}'>{{$category->color}}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{route("category.edit", compact("category"))}}"
                                   class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{__("Edit")}}</a>
                                <form action="{{route("category.delete", compact("category"))}}" method="post">
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
                            <th scope="row" colspan="3"
                                class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{__("No category")}}
                            </th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{$categories->links()}}
        </div>
    </div>
</x-app-layout>
