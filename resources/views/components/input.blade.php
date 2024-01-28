@props(["class"=>"", 'messages' => null, "multiline" => false, "type" => "text", "name" => null, "label" => null, "placeholder" => null, "defaultValue" => null])

<div class="mb-6 flex flex-col {{$class ?? ''}}">
    @if($messages)
        @if(!empty($label))
            <label for="{{$name}}"
                   class="block mb-2 text-sm font-medium text-red-700 dark:text-red-500">{{$label}}</label>
        @endif
        @if($multiline === true)
            <textarea id="{{$name}}" name="{{$name}}" rows="10" placeholder="{{$placeholder}}"
                      class="flex-1 bg-red-50 border-red-500 border text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400">{{$defaultValue}}</textarea>
        @else
            <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
                   class="flex-1 bg-red-50 border-red-500 border text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400"
                   placeholder="{{$placeholder}}" value="{{$defaultValue}}">
        @endif
        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                    class="font-medium">{{$messages}}</p>
    @else
        @if(!empty($label))
            <label for="{{$name}}"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$label}}</label>
        @endif
        @if($multiline === true)
            <textarea id="{{$name}}" name="{{$name}}" rows="10" placeholder="{{$placeholder}}"
                      class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$defaultValue}}</textarea>
        @else
            <input type="{{$type}}" id="{{$name}}" name="{{$name}}"
                   class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="{{$placeholder}}" value="{{$defaultValue}}">
        @endif
    @endif
</div>
