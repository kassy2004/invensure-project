@props([
    'glowColor' => 'orange',
    'size' => 'md',
    'width' => null,
    'height' => null,
    'customSize' => false,
    'class' => ''
])

@php
    $glowColorMap = [
        'blue' => ['base' => 220, 'spread' => 200],
        'purple' => ['base' => 280, 'spread' => 300],
        'green' => ['base' => 120, 'spread' => 200],
        'red' => ['base' => 0, 'spread' => 200],
        'orange' => ['base' => 30, 'spread' => 200],
    ];

    $sizeMap = [
        'sm' => 'w-48 h-64',
        'md' => 'w-64 h-80',
        'lg' => 'w-80 h-96',
    ];

    $sizeClass = $customSize ? '' : ($sizeMap[$size] ?? $sizeMap['md']);
    $base = $glowColorMap[$glowColor]['base'];
    $spread = $glowColorMap[$glowColor]['spread'];
@endphp

<style>
    [data-glow]::before,
    [data-glow]::after {
        pointer-events: none;
        content: "";
        position: absolute;
        inset: calc(var(--border-size) * -1);
        border: var(--border-size) solid transparent;
        border-radius: calc(var(--radius) * 1px);
        background-attachment: fixed;
        background-size: calc(100% + (2 * var(--border-size))) calc(100% + (2 * var(--border-size)));
        background-repeat: no-repeat;
        background-position: 50% 50%;
        mask: linear-gradient(transparent, transparent), linear-gradient(white, white);
        mask-clip: padding-box, border-box;
        mask-composite: intersect;
    }

    [data-glow]::before {
        background-image: radial-gradient(
            calc(var(--spotlight-size) * 0.75) calc(var(--spotlight-size) * 0.75) at
            calc(var(--x, 0) * 1px)
            calc(var(--y, 0) * 1px),
            hsl(var(--hue, 210) 100% 50% / var(--border-spot-opacity, 1)), transparent 100%
        );
        filter: brightness(2);
    }

    [data-glow]::after {
        background-image: radial-gradient(
            calc(var(--spotlight-size) * 0.5) calc(var(--spotlight-size) * 0.5) at
            calc(var(--x, 0) * 1px)
            calc(var(--y, 0) * 1px),
            hsl(0 100% 100% / var(--border-light-opacity, 1)), transparent 100%
        );
    }

    [data-glow] [data-glow] {
        position: absolute;
        inset: 0;
        will-change: filter;
        opacity: var(--outer, 1);
        border-radius: calc(var(--radius) * 1px);
        border-width: calc(var(--border-size) * 20);
        filter: blur(calc(var(--border-size) * 10));
        pointer-events: none;
        border: none;
    }
</style>

<div
    x-data
    x-init="
        document.addEventListener('pointermove', e => {
            const x = e.clientX;
            const y = e.clientY;
            const el = $el.querySelector('[data-glow]');
            if (el) {
                el.style.setProperty('--x', x.toFixed(2));
                el.style.setProperty('--xp', (x / window.innerWidth).toFixed(2));
                el.style.setProperty('--y', y.toFixed(2));
                el.style.setProperty('--yp', (y / window.innerHeight).toFixed(2));
            }
        });
    "
>
    <div
        data-glow
        style="
            --base: {{ $base }};
            --spread: {{ $spread }};
            --radius: 14;
            --border: 3;
            --backdrop: hsl(0 0% 60% / 0.12);
            --backup-border: var(--backdrop);
            --size: 200;
            --outer: 1;
            --border-size: calc(var(--border, 2) * 1px);
            --spotlight-size: calc(var(--size, 150) * 1px);
            background-image: radial-gradient(
                var(--spotlight-size) var(--spotlight-size) at
                calc(var(--x, 0) * 1px)
                calc(var(--y, 0) * 1px),
                hsl(var(--hue, 210) 100% 70% / var(--bg-spot-opacity, 0.1)), transparent
            );
            background-color: var(--backdrop, transparent);
            background-size: calc(100% + (2 * var(--border-size))) calc(100% + (2 * var(--border-size)));
            background-position: 50% 50%;
            background-attachment: fixed;
            border: var(--border-size) solid var(--backup-border);
            {{ $width ? 'width:' . (is_numeric($width) ? $width . 'px' : $width) . ';' : '' }}
            {{ $height ? 'height:' . (is_numeric($height) ? $height . 'px' : $height) . ';' : '' }}
        "
        class="relative grid grid-rows-[1fr_auto] shadow-[0_1rem_2rem_-1rem_black] p-4 gap-4 backdrop-blur-[5px] rounded-2xl {{ $sizeClass }} {{ $class }}"
    >
        <div data-glow></div>
        {{ $slot }}
    </div>
</div>
