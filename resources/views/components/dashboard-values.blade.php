@foreach($balanceValues as $valueName => [$value, $color])
<div>
    <h3>{{ __("dashboard.$valueName") }}:</h3>
    <h2 style="color: var(--{{ $color }})">{{ $value }}</h2>
</div>
@endforeach