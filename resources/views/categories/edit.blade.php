<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 mb-8 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center text-gray-900 dark:text-gray-100 text-xl text-bold">
                    <span>{{ __("Edit category") }}</span>
                </div>
                <form action="{{route("category.update", compact("category"))}}" class="pt-6 grid gap-6 md:grid-cols-2"
                      method="post">
                    @method("PUT")
                    @csrf
                    <x-input name="name" placeholder="Nom" label="Nom" :default-value="old('name', $category->name)"
                             :messages="$errors->first('name')"/>

                    <x-input name="color" placeholder="Couleur" type="color" :default-value="old('color', $category->color)"
                             label="Couleur"
                             :messages="$errors->first('color')"/>

                    <div class="flex justify-end col-span-2">
                        <x-primary-button>{{__("Save")}}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
