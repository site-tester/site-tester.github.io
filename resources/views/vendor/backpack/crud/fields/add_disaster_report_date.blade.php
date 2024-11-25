{{-- html5 date input --}}

<?php
// if the column has been cast to Carbon or Date (using attribute casting)
// get the value as a date string
if (isset($field['value']) && $field['value'] instanceof \Carbon\CarbonInterface) {
    $field['value'] = $field['value']->toDateString();
}
?>

{{-- @include('crud::fields.inc.wrapper_start') --}}
<tr>
<td class="col-2">
    <label class="col-form-label d-flex align-items-center justify-content-end fw-bold">{!! $field['label'] !!}</label>
</td>
@include('crud::fields.inc.translatable_icon')
<td>
    <input type="date" name="{{ $field['name'] }}"
        value="{{ old_empty_or_null($field['name'], '') ?? ($field['value'] ?? ($field['default'] ?? '')) }}"
        @include('crud::fields.inc.attributes')>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</td>
</tr>
{{-- @include('crud::fields.inc.wrapper_end') --}}
