<?php

namespace App\Http\Requests\Api\V1\ConstructionUpdate;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstructionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'author_name' => ['required', 'string', 'max:255'],
            'author_email' => ['nullable', 'email', 'max:255'],
            'author_phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:2000'],
            'image' => ['required', 'image', 'max:8192'],
        ];
    }
}
