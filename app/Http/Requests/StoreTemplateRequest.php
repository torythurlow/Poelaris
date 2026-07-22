<?php

namespace App\Http\Requests;

use App\Enums\BanditChoice;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTemplateRequest extends FormRequest
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
            'tree_version_id' => ['required', 'integer', 'exists:tree_versions,id'],
            'class_id' => ['required', 'integer', 'between:0,6'],
            'ascendancy_name' => ['nullable', 'string', 'max:255'],
            'bandit_choice' => ['sometimes', Rule::enum(BanditChoice::class)],
        ];
    }
}
