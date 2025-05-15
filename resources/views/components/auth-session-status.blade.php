@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-success bg-success bg-opacity-10 p-3 rounded-md']) }}>
        {{ $status }}
    </div>
@endif
