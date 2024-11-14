<?php

namespace Modules\Contacts\App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'name' => 'required|unique:contacts,name,'.$this->get('id'),
            'email' => 'nullable|email',
            'mobile_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'fax_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'nullable|string',
            'note' => 'nullable|string',
            'sales_person_name' => 'nullable|string',
            'sales_person_email' => 'nullable|email',
            'sales_person_mobile_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'sales_person_note' => 'nullable|string',
            'purchase_person_name' => 'nullable|string',
            'purchase_person_email' => 'nullable|email',
            'purchase_person_mobile_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'purchase_person_note' => 'nullable|string',
            'default_on_sales' => 'nullable|numeric',
            'default_on_purchases' => 'nullable|numeric',
        ];
    }
}
