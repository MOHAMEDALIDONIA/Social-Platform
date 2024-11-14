<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full rounded']) }}>
    {{ $slot }}
</button>
