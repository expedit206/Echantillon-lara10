    @props(['value'])

    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>

    <!-- When there is no desire, all things are at peace. - Laozi -->
