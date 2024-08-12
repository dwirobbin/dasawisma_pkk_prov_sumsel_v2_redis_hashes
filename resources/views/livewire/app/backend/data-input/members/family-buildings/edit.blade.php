<div class="card">
    <form wire:submit="saveChange" method="post">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                <div class="flex-fill mb-2">
                    <label for="dasawisma_id" class="form-label">Dasawisma</label>
                    <select id="dasawisma_id" wire:model='dasawisma_id'
                        class="form-select {{ $errors->has('dasawisma_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        disabled>
                        <option value=''>---Pilih Dasawisma---</option>
                        @isset($dasawismas)
                            @foreach ($dasawismas as $dasawisma)
                                <option id='dasawisma-{{ $dasawisma->id }}' value="{{ $dasawisma->id }}" @selected($dasawisma_id == $dasawisma->id)>
                                    {{ $dasawisma->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    @error('dasawisma_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex-fill mb-2">
                    <label for="kk_number" class="form-label required">No. KK</label>
                    <input type="number" id="kk_number" wire:model='kk_number'
                        class="form-control {{ $errors->has('kk_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}" disabled>
                    @error('kk_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex-fill mb-2">
                    <label for="family_head" class="form-label required">Nama Kepala keluarga</label>
                    <input type="text" id="family_head" wire:model='family_head'
                        class="form-control {{ $errors->has('family_head') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        disabled>
                    @error('family_head')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label pt-0 required">Sumber Air Keluarga</label>
                    <div class="d-flex justify-content-between flex-column flex-sm-row">
                        <label class="form-check" role="button" for="pdam">
                            <input type="checkbox" id="pdam" wire:model='water_src' class="form-check-input" value="PDAM" role="button">
                            <span class="form-check-label text-muted">PDAM</span>
                        </label>
                        <label class="form-check" role="button" for="sumur">
                            <input type="checkbox" id="sumur" wire:model='water_src' class="form-check-input" value="Sumur" role="button">
                            <span class="form-check-label text-muted">Sumur</span>
                        </label>
                        <label class="form-check" role="button" for="sungai">
                            <input type="checkbox" id="sungai" wire:model='water_src' class="form-check-input" value="Sungai" role="button">
                            <span class="form-check-label text-muted">Sungai</span>
                        </label>
                        <label class="form-check" role="button" for="lainnya">
                            <input type="checkbox" id="lainnya" wire:model='water_src' class="form-check-input" value="Lainnya" role="button">
                            <span class="form-check-label text-muted">Lainnya</span>
                        </label>
                    </div>
                    @error('water_src')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 mb-3">
                <div class="col">
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Makanan Pokok</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="staple_food" wire:model.blur="staple_food" class="form-check-input" value="Beras"
                                    role="button">
                                <span class="form-check-label text-muted">Beras</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="staple_food" wire:model.blur="staple_food" class="form-check-input" value="Non Beras"
                                    role="button">
                                <span class="form-check-label text-muted">Non Beras</span>
                            </label>
                        </div>
                        @error('staple_food')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Jamban</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_toilet" wire:model="have_toilet" class="form-check-input" value="yes"
                                    role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_toilet" wire:model="have_toilet" class="form-check-input" value="no"
                                    role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_toilet')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Tempat Pembuangan Sampah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_landfill" wire:model="have_landfill" class="form-check-input"
                                    value="yes" role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_landfill" wire:model="have_landfill" class="form-check-input"
                                    value="no" role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_landfill')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Saluran Pembuangan Air Limbah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_sewerage" wire:model="have_sewerage" class="form-check-input"
                                    value="yes" role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_sewerage" wire:model="have_sewerage" class="form-check-input"
                                    value="no" role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_sewerage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Menempel Stiker P4K</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="pasting_p4k_sticker" wire:model="pasting_p4k_sticker" class="form-check-input"
                                    value="yes" role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="pasting_p4k_sticker" wire:model="pasting_p4k_sticker" class="form-check-input"
                                    value="no" role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('pasting_p4k_sticker')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Kriteria Rumah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="house_criteria" wire:model="house_criteria" class="form-check-input"
                                    value="Sehat" role="button">
                                <span class="form-check-label text-muted">Sehat</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="house_criteria" wire:model="house_criteria" class="form-check-input"
                                    value="Kurang Sehat" role="button">
                                <span class="form-check-label text-muted">Kurang Sehat</span>
                            </label>
                        </div>
                        @error('house_criteria')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
