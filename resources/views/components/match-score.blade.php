@props(['matchData', 'size' => 'sm'])

@php
    $score = $matchData['total_score'] ?? 0;
    $recommendation = $matchData['recommendation'] ?? 'unknown';

    $badgeClasses = match($recommendation) {
        'excellent' => 'bg-green-100 text-green-800 border-green-200',
        'good' => 'bg-blue-100 text-blue-800 border-blue-200',
        'fair' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'poor' => 'bg-red-100 text-red-800 border-red-200',
        default => 'bg-gray-100 text-gray-800 border-gray-200'
    };

    $iconClasses = match($recommendation) {
        'excellent' => 'text-green-600',
        'good' => 'text-blue-600',
        'fair' => 'text-yellow-600',
        'poor' => 'text-red-600',
        default => 'text-gray-600'
    };

    $sizeClasses = match($size) {
        'lg' => 'px-3 py-1 text-sm',
        'sm' => 'px-2 py-0.5 text-xs',
        default => 'px-2 py-0.5 text-xs'
    };
@endphp

<span class="inline-flex items-center {{ $sizeClasses }} rounded-full font-medium border {{ $badgeClasses }}">
    <svg class="w-3 h-3 mr-1 {{ $iconClasses }}" fill="currentColor" viewBox="0 0 20 20">
        @if($recommendation === 'excellent')
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        @elseif($recommendation === 'good')
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
        @elseif($recommendation === 'fair')
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        @else
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        @endif
    </svg>
    {{ number_format($score, 0) }}% Match
</span>
