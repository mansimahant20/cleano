@php
    $bgClasses = ['widget-bg-1', 'widget-bg-2', 'widget-bg-3', 'widget-bg-4', 'widget-bg-5', 'widget-bg-6', 'widget-bg-7', 'widget-bg-8'];
    $index = session('widget_color_index', 0);
    $fixedClass = $bgClasses[$index % count($bgClasses)];
    $index++;
    session(['widget_color_index' => $index]);
@endphp

<div
    {{ $attributes->merge(['class' => "$fixedClass p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center"]) }}>
    <div class="d-block text-capitalize">
        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">{{ $title }}
            @if (!is_null($info))
                <i class="fa fa-question-circle" data-toggle="popover" data-placement="top" data-content="{{ $info }}" data-html="true" data-trigger="hover"></i>
            @endif
        </h5>
        <div class="d-flex">
            <p class="mb-0 f-15 font-weight-bold text-white d-grid">
                <span id="{{ $widgetId }}">{{ $value }}</span>
            </p>
        </div>
    </div>
    <div class="d-block">
        <i class="fa fa-{{ $icon }} text-lightest f-18"></i>
    </div>
</div>
