<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\WaliMurid;

class RegisterRequest extends FormRequest
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
            'role'       => ['required', Rule::in(['siswa', 'guru', 'walimurid'])],
            'identifier' => ['required', 'string', ...$this->identifierRule()],
            'username'   => ['required', 'alpha_dash', 'unique:user,username'],
            'password'   => ['required', 'confirmed', 'min:8'],
        ];
    }

    /** Aturan dinamis bergantung role */
    protected function identifierRule(): array
    {
        return match ($this->input('role')) {
            'siswa' => [Rule::exists('siswa', 'nis')],

            'guru'  => [Rule::exists('guru', 'nip')],

            'walimurid' => [ // closure custom dibungkus array
                function ($attr, $value, $fail) {
                    $exists = WaliMurid::where('telpon_walimurid', $value)
                        ->orWhere('reg_code', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Nomor telepon atau kode undangan tidak valid.');
                    }
                }
            ],

            default => [Rule::in(['∅'])], // pasti gagal
        };
    }
}
