<button
    {{ $attributes->merge([
        'type'=>'submit',
        'class'=>'px-4 py-2 bg-gray-800 text-white rounded-md'
    ]) }}
>
    {{ $slot }}
</button>