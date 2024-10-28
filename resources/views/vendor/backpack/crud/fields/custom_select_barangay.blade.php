@php
    // Use the options passed from the controller
    $options = isset($field['options']) ? $field['options'] : [];
@endphp

<style>
    select {
        padding-right: 30px;
        /* Adjust according to icon size */
    }

    select option {
        display: flex;
        align-items: center;
    }
</style>

<div class="form-group">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <select name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}">
        <option value="">Select Barangay</option>
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}">
                {!! $option['icon'] !!} {{ $option['text'] }}
            </option>
        @endforeach
    </select>
</div>
