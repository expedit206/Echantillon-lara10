
    
@props(['name', 'disabled' => false])

<input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-white-300 dark:border-gray-700  dark:text-black focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
<p class="text-red-500">

    @error($name)
    {{ $message }}
    @enderror
</p> 