<?php
$height = $height ?? '2.5rem';
$width = $width ?? '2.5rem';
?>

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <!-- Nested squares logo -->
    <div class="relative" style="height: {{ $height }}; width: {{ $width }};">
        <!-- Outer square (Gold) -->
        <div class="absolute inset-0 bg-brand-gold rounded-md transform rotate-0"></div>
        
        <!-- Middle square (Orange) -->
        <div class="absolute inset-[15%] bg-brand-orange rounded-md transform rotate-3"></div>
        
        <!-- Inner square (Crimson) -->
        <div class="absolute inset-[30%] bg-brand-crimson rounded-md transform rotate-6"></div>
    </div>
    
    <!-- Logo text -->
    <span class="ml-2 text-xl font-bold {{ isset($textClass) ? $textClass : 'text-gray-900' }}">Invensure</span>
</div> 