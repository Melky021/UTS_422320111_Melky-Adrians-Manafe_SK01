<x-card>
    <x-form-field name="kode" label="Kode" :value="$kelompok?->kode" :required="true" hint="Maks. 10 karakter, unik. Contoh: PDI" />
    <x-form-field name="nama" label="Nama Kelompok" :value="$kelompok?->nama" :required="true" />
    <x-form-field name="deskripsi" label="Deskripsi" type="textarea" :value="$kelompok?->deskripsi" />
</x-card>
