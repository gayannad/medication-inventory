<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        if (request()->isMethod('POST')) {
            return [
                'name' => ['required', 'string', 'max:255', 'unique:customers'],
                'address' => ['nullable', 'string'],
                'phone' => ['nullable', new PhoneValidate(), 'unique:customers'],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('customers', 'name')
                    ->ignore(request()->route('customer'), 'id')],
                'address' => ['nullable', 'string'],
                'phone' => ['nullable', new PhoneValidate(), Rule::unique('customers', 'phone')
                    ->ignore(request()->route('customer'), 'id')],
            ];
        }
    }
}
