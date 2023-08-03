@foreach ($track as $trackName => $trackColor)
    <li class="glide__slide">
        <div class="glide__slide--container" style="background-color: var(--{{ $trackColor }});">
            <div>
                <h2>{{ __("welcome.glide.title.$trackName") }}</h2>
                <p>{{ __("welcome.glide.description.$trackName") }}</p>
            </div>
            <div>
                <img src="{{ asset("img/$trackName.png") }}" alt="{{ $trackName }}">
            </div>
        </div>
    </li>
@endforeach