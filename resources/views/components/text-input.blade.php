@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary focus:ring-opacity-20 rounded-md shadow-sm']) }}>
