<div wire:ignore.self x-data="modalEdit" x-on:open-modal-edit.window="open($event)" x-on:close-modal-edit.window="close"
    x-on:keydown.escape.window="close" class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dasawisma</h5>
                <button type="button" class="btn-close" x-on:click="$dispatch('close-modal-edit')" aria-label="Close"></button>
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
                            <option value=''>---Pilih provinsi---</option>
                            @isset($provinces)
                                @foreach ($provinces as $province)
                                    <option wire:key='province-{{ $province->id }}' value="{{ $province->id }}" @selected($province_id == $province->id)>
                                        {{ $province->name }}
                                    </option>
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
                            <option value=''>---Pilih Kabupaten/Kota---</option>
                            @isset($regencies)
                                @foreach ($regencies as $regency)
                                    <option wire:key='regency-{{ $regency->id }}' value="{{ $regency->id }}" @selected($regency_id == $regency->id)>
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
                            <option value=''>---Pilih Kecamatan---</option>
                            @isset($districts)
                                @foreach ($districts as $district)
                                    <option wire:key='district-{{ $district->id }}' value="{{ $district->id }}" @selected($district_id == $district->id)>
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
                            <option value=''>---Pilih Kelurahan/Desa---</option>
                            @isset($villages)
                                @foreach ($villages as $village)
                                    <option wire:key='village-{{ $village->id }}' value="{{ $village->id }}" @selected($village_id == $village->id)>
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
                <button type="button" class="btn me-auto" x-on:click="$dispatch('close-modal-edit')">Batal</button>
                <button type="submit" wire:click='saveChange' class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('modalEdit', () => {
            return {
                modalEl: document.getElementById('modal-edit'),
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
