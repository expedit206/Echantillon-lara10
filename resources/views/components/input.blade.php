
    
@props(['name', 'disabled' => false])

<input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-white-300  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
<p class="text-red-500">

    @error($name)
    {{ $message }}
    @enderror
</p> 