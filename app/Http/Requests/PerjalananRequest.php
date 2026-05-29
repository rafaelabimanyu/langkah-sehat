<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerjalananRequest extends FormRequest
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
            'tanggal' => ['required', 'date'],
            'jam' => ['required'],
            'lokasi' => ['required', 'string', 'max:255'],
            'suhu_tubuh' => ['required', 'numeric', 'between:35.0,42.0'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal perjalanan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam.required' => 'Jam perjalanan wajib diisi.',
            'lokasi.required' => 'Lokasi perjalanan wajib diisi.',
            'suhu_tubuh.required' => 'Suhu tubuh wajib diisi.',
            'suhu_tubuh.numeric' => 'Suhu tubuh harus berupa angka.',
            'suhu_tubuh.between' => 'Suhu tubuh harus berada di antara 35.0°C dan 42.0°C.',
        ];
    }
}
