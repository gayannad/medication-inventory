<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MedicationRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:255', 'unique:medications'],
                'description' => ['nullable', 'string'],
                'qty' => ['required', 'numeric'],
                'manufactured_date' => ['required', 'date_format:Y-m-d'],
                'expired_date' => ['required', 'date_format:Y-m-d'],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('medications', 'name')
                    ->ignore(request()->route('medications'), 'id')],
                'description' => ['nullable', 'string'],
                'qty' => ['required', 'numeric'],
                'manufactured_date' => ['required', 'date_format:Y-m-d'],
                'expired_date' => ['required', 'date_format:Y-m-d'],
            ];
        }
    }
}
