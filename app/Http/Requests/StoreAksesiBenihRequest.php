<?php

namespace App\Http\Requests;

use App\Models\AksesiBenih;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAksesiBenihRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelompok_tanaman_id' => ['required', 'exists:kelompok_tanamans,id'],
            'kode_aksesi'         => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:aksesi_benihs,kode_aksesi'],
            'nama_aksesi'         => ['required', 'string', 'max:120'],
            'nama_ilmiah'         => ['nullable', 'string', 'max:150'],
            'stok_gram'           => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'status'              => ['required', Rule::in(array_keys(AksesiBenih::STATUS))],

            // Detail asal pengumpulan (one-to-one)
            'asal.desa'            => ['required', 'string', 'max:100'],
            'asal.kecamatan'       => ['required', 'string', 'max:100'],
            'asal.kabupaten'       => ['required', 'string', 'max:100'],
            'asal.provinsi'        => ['required', 'string', 'max:100'],
            'asal.tanggal_koleksi' => ['required', 'date', 'before_or_equal:today'],
            'asal.kolektor'        => ['required', 'string', 'max:100'],
            'asal.ketinggian_mdpl' => ['nullable', 'integer', 'min:0', 'max:6000'],
            'asal.catatan'         => ['nullable', 'string', 'max:500'],

            // Pilihan jamak perlakuan penyimpanan (many-to-many)
            'perlakuan_ids'   => ['nullable', 'array'],
            'perlakuan_ids.*' => ['integer', 'exists:perlakuan_penyimpanans,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'kelompok_tanaman_id'  => 'kelompok tanaman',
            'kode_aksesi'          => 'kode aksesi',
            'nama_aksesi'          => 'nama aksesi',
            'nama_ilmiah'          => 'nama ilmiah',
            'stok_gram'            => 'stok (gram)',
            'asal.desa'            => 'desa',
            'asal.kecamatan'       => 'kecamatan',
            'asal.kabupaten'       => 'kabupaten/kota',
            'asal.provinsi'        => 'provinsi',
            'asal.tanggal_koleksi' => 'tanggal koleksi',
            'asal.kolektor'        => 'kolektor',
            'asal.ketinggian_mdpl' => 'ketinggian (mdpl)',
            'asal.catatan'         => 'catatan',
            'perlakuan_ids'        => 'perlakuan penyimpanan',
        ];
    }

    public function messages(): array
    {
        return [
            'required'              => ':attribute wajib diisi.',
            'unique'                => ':attribute sudah digunakan.',
            'max'                   => ':attribute maksimal :max karakter.',
            'exists'                => ':attribute tidak valid.',
            'numeric'               => ':attribute harus berupa angka.',
            'kode_aksesi.regex'     => 'Kode aksesi hanya boleh huruf, angka, dan tanda minus.',
            'before_or_equal'       => ':attribute tidak boleh di masa depan.',
        ];
    }
}
