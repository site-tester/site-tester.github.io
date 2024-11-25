{{-- text input --}}

{{-- @include('crud::fields.inc.wrapper_start') --}}
<tr>
    <td class="col-2">
        <label
            class="col-form-label d-flex align-items-center justify-content-end fw-bold">{!! $field['label'] !!}</label>
    </td>
    @include('crud::fields.inc.translatable_icon')
    <td>
        <table class="w-100 ps-4">
            <tr>
                <td class="col-1">
                    <label class="col-form-label">Families:</label>
                </td>
                <td>
                    <input type="text" class="form-control" name="affected_family">
                </td>
            </tr>
            <tr>
                <td class="col-1">
                    <label class="col-form-label">Person:</label>
                </td>
                <td>
                    <input type="text" class="form-control" name="affected_person">
                </td>
            </tr>
        </table>

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </td>
</tr>
{{-- @include('crud::fields.inc.wrapper_end') --}}
