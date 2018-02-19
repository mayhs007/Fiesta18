<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'staff_incharge' => 'required',
            'venue'=>'required',
            'description' => 'required',
            'rules' => 'required',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',            
            'min_members' => 'required',
            'max_members' => 'required',
            'max_limit' => 'required',
            'event_image' => 'mimetypes:image/jpeg, images/png',
            'organizers' => 'required|adminExists'
        ];
    }
    public function messages(){
        return [
            'venue.required' => 'The venue field is required',
            'staff_incharge.required' => 'The Staff incharge field is required',
            'event_date.required' => 'The date field is required',
            'min_members.required' => 'The minimum participants field is required',
            'max_members.required' => 'The maximum participants field is required',
            'max_limit.required' => 'The maximum participations field is required',
            'event_image.mimetypes' => 'The event image must be of formats jpeg or png only',
            'organizers.required' => 'There must be atleast one organizer for an event'
        ];
    }
}
