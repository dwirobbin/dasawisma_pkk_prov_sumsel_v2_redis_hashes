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
            <div class="table-responsive mb-2">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center">Jumlah</th>
                        </tr>
                        <tr>
                            <th>Balita</th>
                            <th>Pasangan Usia Subur</th>
                            <th>Wanita Usia Subur</th>
                            <th>Orang Buta</th>
                            <th>Ibu Hamil</th>
                            <th>Ibu Menyusui</th>
                            <th>Lansia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="number" wire:model='toddlers_number'
                                    class="form-control {{ $errors->has('toddlers_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('toddlers_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='pus_number'
                                    class="form-control {{ $errors->has('pus_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('toddlers_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='wus_number'
                                    class="form-control {{ $errors->has('wus_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('wus_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='blind_people_number'
                                    class="form-control {{ $errors->has('blind_people_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('blind_people_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='pregnant_women_number'
                                    class="form-control {{ $errors->has('pregnant_women_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('pregnant_women_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='breastfeeding_mother_number'
                                    class="form-control {{ $errors->has('breastfeeding_mother_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('breastfeeding_mother_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model='elderly_number'
                                    class="form-control {{ $errors->has('elderly_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="0" style="width: 9rem">
                                @error('elderly_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
