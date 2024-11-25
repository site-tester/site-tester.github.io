{{-- text input --}}

{{-- @include('crud::fields.inc.wrapper_start') --}}
<tr>
    <td class="col-2">
        <label
            class="col-form-label d-flex align-items-center justify-content-end fw-bold">{!! $field['label'] !!}</label>
    </td>
    @include('crud::fields.inc.translatable_icon')
    <td>
            <div class="form-group">
                <p class="col-form-label">Current Needs:</p>
                <div class="ps-4">
                    <div class="mb-3">
                        <label for="food_water_details" class="form-label">Food and Water (please specify):</label>
                        <textarea class="form-control" id="food_water_details" name="immediate_needs_food"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medical_supplies_details" class="form-label">Medical Supplies (please specify):</label>
                        <textarea class="form-control" id="medical_supplies_details" name="immediate_needs_medicine"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="non_food_details" class="form-label">Non-Food (please specify):</label>
                        <textarea class="form-control" id="non_food_details" name="immediate_needs_nonfood"></textarea>
                    </div>
                </div>
            </div>

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </td>
</tr>
{{-- @include('crud::fields.inc.wrapper_end') --}}
