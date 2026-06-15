@props([
    'class' => 'w-20 h-20',
])

<x-ruto-logo {{ $attributes->merge(['class' => $class]) }} />
