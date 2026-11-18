<x-card>
    <x-form-field name="nama" label="Nama Perlakuan" :value="$perlakuan?->nama" :required="true" />
    <x-form-field name="deskripsi" label="Deskripsi" type="textarea" :value="$perlakuan?->deskripsi" />
</x-card>
