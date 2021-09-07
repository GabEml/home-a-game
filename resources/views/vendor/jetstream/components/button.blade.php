<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-info btn']) }}>
    {{ $slot }}
</button>
