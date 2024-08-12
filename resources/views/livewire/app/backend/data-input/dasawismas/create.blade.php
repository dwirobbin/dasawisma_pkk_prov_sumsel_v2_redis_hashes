<div>
    <button x-on:click="$dispatch('open-modal-create')" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 5l0 14"></path>
            <path d="M5 12l14 0"></path>
        </svg>
        Tambah
    </button>

    <div wire:ignore.self x-data="modalCreate" x-on:open-modal-create.window="open($event)" x-on:close-modal-create.window="close"
        x-on:keydown.escape.window="close" class="modal modal-blur fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Dasawisma</h5>
                    <button type="button" class="btn-close" x-on:click="$dispatch('close-modal-create')" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">Nama Dasawisma</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" wire:model='name'
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="Nama...">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">RT</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" wire:model='rt'
                                class="form-control {{ $errors->has('rt') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="RT...">
                            @error('rt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">RW</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" wire:model='rw'
                                class="form-control {{ $errors->has('rw') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="RW...">
                            @error('rw')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">Provinsi</label>
                        <div class="col-md-8 col-lg-9">
                            <select wire:model.live='province_id'
                                class="form-select {{ $errors->has('province_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>---Pilih provinsi---</option>
                                @isset($provinces)
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">Kabupaten/Kota:</label>
                        <div class="col-md-8 col-lg-9">
                            <select wire:model.live='regency_id'
                                class="form-select {{ $errors->has('regency_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>---Pilih Kabupaten/Kota---</option>
                                @isset($regencies)
                                    @foreach ($regencies as $regency)
                                        <option value="{{ $regency->id }}">
                                            {{ $regency->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">Kecamatan:</label>
                        <div class="col-md-8 col-lg-9">
                            <select wire:model.live='district_id'
                                class="form-select {{ $errors->has('district_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>---Pilih Kecamatan---</option>
                                @isset($districts)
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-4 col-lg-3 col-form-label required">Kelurahan/Desa:</label>
                        <div class="col-md-8 col-lg-9">
                            <select wire:model.live='village_id'
                                class="form-select {{ $errors->has('village_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>---Pilih Kelurahan/Desa---</option>
                                @isset($villages)
                                    @foreach ($villages as $village)
                                        <option value="{{ $village->id }}">
                                            {{ $village->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('village_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" x-on:click="$dispatch('close-modal-create')">Batal</button>
                    <button type="submit" wire:click='save' class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('modalCreate', () => {
            return {
                modalEl: document.getElementById('modal-create'),
                open(e) {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).show();
                },
                close() {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).hide();
                    $wire.resetForm();
                },
            }
        })
    </script>
@endscript
