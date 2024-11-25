{{-- select --}}
@php
    $current_value = old_empty_or_null($field['name'], '') ?? ($field['value'] ?? ($field['default'] ?? ''));
    $entity_model = $crud->getRelationModel($field['entity'], -1);
    $field['allows_null'] = $field['allows_null'] ?? $entity_model::isColumnNullable($field['name']);

    //if it's part of a relationship here we have the full related model, we want the key.
if (is_object($current_value) && is_subclass_of(get_class($current_value), 'Illuminate\Database\Eloquent\Model')) {
    $current_value = $current_value->getKey();
}

if (!isset($field['options'])) {
    $options = $field['model']::all();
} else {
    $options = call_user_func($field['options'], $field['model']::query());
    }
@endphp
<tr>
    {{-- @include('crud::fields.inc.wrapper_start') --}}
    <td class="col-2">
        <label
            class="col-form-label d-flex align-items-center justify-content-end fw-bold">{!! $field['label'] !!}</label>
    </td>

    <td>
        <select name="{{ $field['name'] }}" @include('crud::fields.inc.attributes', ['default_class' => 'form-control form-select'])>
            @if ($field['allows_null'])
                <option value="">-</option>
            @endif
            @if (count($options))
                @foreach ($options as $connected_entity_entry)
                    @if ($current_value == $connected_entity_entry->getKey())
                        <option value="{{ $connected_entity_entry->getKey() }}" selected>
                            {{ $connected_entity_entry->{$field['attribute']} }}</option>
                    @else
                        <option value="{{ $connected_entity_entry->getKey() }}">
                            {{ $connected_entity_entry->{$field['attribute']} }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </td>
</tr>
{{-- @include('crud::fields.inc.wrapper_end') --}}
