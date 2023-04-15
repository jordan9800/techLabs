<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
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
            'subject'                => 'required|string|max:191',
            'description'            => 'string|nullable',
            'start_date'             => 'required|date_format:Y-m-d|before_or_equal:due_date',
            'due_date'               => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'status'                 => 'required|in:New,Incomplete,Complete',
            'priority'               => 'required|in:High,Medium,Low',
            'notes.*.subject'        => 'required|string|max:191',
            'notes.*.attachments'    => 'nullable',
            'notes.*.attachments.*'  => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:2048',
            'notes.*.note'           => 'required|string'
        ];
    }
}
