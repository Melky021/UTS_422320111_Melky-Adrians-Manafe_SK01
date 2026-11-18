<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateAksesiBenihRequest extends StoreAksesiBenihRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        // Saat update, kode boleh sama dengan miliknya sendiri.
        $rules['kode_aksesi'] = [
            'required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/',
            Rule::unique('aksesi_benihs', 'kode_aksesi')->ignore($this->route('aksesi')),
        ];

        return $rules;
    }
}
