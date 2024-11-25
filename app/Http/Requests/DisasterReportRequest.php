<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reported_by' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'incident_time' => 'required|date_format:H:i',
            'barangay_id' => 'required|exists:barangays,id',
            'exact_location' => 'required|string|max:255',
            'disaster_type' => 'required|array',
            // 'disaster_type.*' => 'exists:disaster_types,id',
            'caused_by' => 'nullable|string|max:255',
            'affected_family' => 'nullable|string',
            'affected_person' => 'nullable|string',
            'immediate_needs_food' => 'nullable|string',
            'immediate_needs_medicine' => 'nullable|string',
            'immediate_needs_nonfood' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'reported_by.required' => 'The "Reported By" field is required.',
            'reported_by.min' => 'The "Reported By" field must be at least 3 characters.',
            'reported_by.max' => 'The "Reported By" field cannot exceed 255 characters.',

            'incident_date.required' => 'The "Date of Incident" is required.',
            'incident_date.date' => 'The "Date of Incident" must be a valid date.',
            'incident_date.before_or_equal' => 'The "Date of Incident" cannot be in the future.',

            'incident_time.required' => 'The "Time of Incident" is required.',
            'incident_time.date_format' => 'The "Time of Incident" must be in the format HH:mm.',

            'barangay_id.required' => 'The "Barangay" field is required.',
            'barangay_id.exists' => 'The selected "Barangay" is invalid.',

            'exact_location.required' => 'The "Exact Location" field is required.',
            'exact_location.min' => 'The "Exact Location" must be at least 3 characters.',
            'exact_location.max' => 'The "Exact Location" cannot exceed 255 characters.',

            'disaster_type.required' => 'You must select at least one disaster type.',
            // 'disaster_type.*.exists' => 'One or more selected disaster types are invalid.',

            'caused_by.max' => 'The "Caused By" field cannot exceed 255 characters.',

            'immediate_needs_food.max' => 'The "Immediate Needs" field cannot exceed 1000 characters.',
            'immediate_needs_nonfood.max' => 'The "Immediate Needs" field cannot exceed 1000 characters.',
            'immediate_needs_medicine.max' => 'The "Immediate Needs" field cannot exceed 1000 characters.',

            'attachments.array' => 'The "Attachments" field must be an array of files.',
            'attachments.*.file' => 'Each attachment must be a file.',
            'attachments.*.mimes' => 'Attachments must be of type: jpg, jpeg, png',
            'attachments.*.max' => 'Each attachment must not exceed 2 MB.',
        ];
    }
}
