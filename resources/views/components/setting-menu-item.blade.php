<li {{ $isActive($menu) ? 'class=active' : '' }} {{ $attributes }} >
    <a class="d-block f-16 text-secondary text-capitalize border-bottom-grey" href="{{ $href }}">{{ $text }}</a>
</li>
