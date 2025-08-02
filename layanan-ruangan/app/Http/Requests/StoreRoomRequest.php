<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.string' => 'Nama ruangan harus berupa teks.',
            'name.max' => 'Nama ruangan maksimal 255 karakter.',
            'capacity.required' => 'Kapasitas ruangan wajib diisi.',
            'capacity.integer' => 'Kapasitas ruangan harus berupa angka.',
            'capacity.min' => 'Kapasitas ruangan minimal 1.',
            'facilities.string' => 'Fasilitas harus berupa teks.',
        ];
    }
}
