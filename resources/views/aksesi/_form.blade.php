{{--
    Partial form dipakai create & edit.
    Variabel: $aksesi (null saat create), $kelompoks, $perlakuans, $selectedPerlakuan (opsional)
--}}
@php
    $asal = $aksesi?->asalPengumpulan;
    $selectedPerlakuan = $selectedPerlakuan ?? [];
@endphp

<x-card title="1. Identitas Aksesi">
    <div class="form-grid">
        <x-form-field name="kode_aksesi" label="Kode Aksesi" :value="$aksesi?->kode_aksesi" :required="true" hint="Contoh: PDI-004" />
        <x-form-field name="nama_aksesi" label="Nama Aksesi" :value="$aksesi?->nama_aksesi" :required="true" />
        <x-form-field name="nama_ilmiah" label="Nama Ilmiah" :value="$aksesi?->nama_ilmiah" />

        <x-form-field name="kelompok_tanaman_id" label="Kelompok Tanaman" type="select" :required="true">
            <option value="">-- pilih --</option>
            @foreach ($kelompoks as $k)
                <option value="{{ $k->id }}" @selected(old('kelompok_tanaman_id', $aksesi?->kelompok_tanaman_id) == $k->id)>{{ $k->nama }}</option>
            @endforeach
        </x-form-field>

        <x-form-field name="stok_gram" label="Stok (gram)" type="number" step="0.01" min="0" :value="$aksesi?->stok_gram ?? 0" :required="true" />

        <x-form-field name="status" label="Status" type="select" :required="true">
            @foreach (\App\Models\AksesiBenih::STATUS as $key => $label)
                <option value="{{ $key }}" @selected(old('status', $aksesi?->status ?? 'tersimpan') === $key)>{{ $label }}</option>
            @endforeach
        </x-form-field>
    </div>
</x-card>

<x-card title="2. Detail Asal Pengumpulan (1 aksesi : 1 detail)">
    <div class="form-grid">
        <x-form-field name="asal.desa" label="Desa" :value="$asal?->desa" :required="true" />
        <x-form-field name="asal.kecamatan" label="Kecamatan" :value="$asal?->kecamatan" :required="true" />
        <x-form-field name="asal.kabupaten" label="Kabupaten/Kota" :value="$asal?->kabupaten" :required="true" />
        <x-form-field name="asal.provinsi" label="Provinsi" :value="$asal?->provinsi" :required="true" />
        <x-form-field name="asal.tanggal_koleksi" label="Tanggal Koleksi" type="date" :value="$asal?->tanggal_koleksi?->format('Y-m-d')" :required="true" />
        <x-form-field name="asal.kolektor" label="Kolektor" :value="$asal?->kolektor" :required="true" />
        <x-form-field name="asal.ketinggian_mdpl" label="Ketinggian (mdpl)" type="number" min="0" :value="$asal?->ketinggian_mdpl" />
    </div>
    <x-form-field name="asal.catatan" label="Catatan" type="textarea" :value="$asal?->catatan" />
</x-card>

<x-card title="3. Perlakuan Penyimpanan (pilihan jamak)">
    <div class="checks">
        @foreach ($perlakuans as $p)
            <label class="check">
                <input type="checkbox" name="perlakuan_ids[]" value="{{ $p->id }}"
                    @checked(in_array($p->id, old('perlakuan_ids', $selectedPerlakuan)))>
                <span>
                    <strong>{{ $p->nama }}</strong><br>
                    <small class="muted">{{ $p->deskripsi }}</small>
                </span>
            </label>
        @endforeach
    </div>
    @error('perlakuan_ids') <small class="error">{{ $message }}</small> @enderror
    @error('perlakuan_ids.*') <small class="error">{{ $message }}</small> @enderror
</x-card>
