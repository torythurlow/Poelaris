<?php

namespace App\Http\Requests;

use App\Enums\GemColour;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_support' => ['sometimes', 'boolean'],
            'colour' => ['required', Rule::enum(GemColour::class)],
            'position' => ['required', 'integer', 'between:1,6'],
        ];
    }
}
