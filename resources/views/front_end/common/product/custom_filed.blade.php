@if (!empty($product->custom_field))
@php
    $customFieldData = json_decode($product->custom_field, true);
    $customFieldData = is_array($customFieldData) ? $customFieldData : [];
@endphp

@foreach ($customFieldData as $item)
    @if (!is_null($item['custom_field']) && !is_null($item['custom_value']))
        <div class="pdp-detail d-flex  align-items-center">
            <b>{{ $item['custom_field'] }} :</b>
            <span class="lbl">{{ $item['custom_value'] }}</span>
        </div>
    @endif
@endforeach
@endif
