<div class="card">
    <form wire:submit='saveChange' method="post">
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
                                <option id='dasawisma-{{ $dasawisma['id'] }}' value="{{ $dasawisma['id'] }}" @selected($dasawisma_id == $dasawisma['id'])>
                                    {{ $dasawisma['name'] }}
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
            <div class="row row-gap-4 mb-2">
                <div class="col-12 col-md-6">
                    <table class="table table-vcenter card-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="ps-3">
                                    <button type="button" class="btn btn-outline-primary btn-icon" x-on:click="$wire.addUp2kActivity()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                    </button>
                                </th>
                                <th>Usaha Peningkatan Pendapatan Keluarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($up2k_activities as $index => $up2kActivity)
                                <tr>
                                    <td class="w-6 ps-3">
                                        @if (!empty($up2kActivity['name']) || (count($up2k_activities) > count($current_up2k_activities) && !$loop->first))
                                            <button type="button" class="btn btn-outline-danger btn-icon"
                                                x-on:click="$wire.removeUp2kActivity({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="pe-3">
                                        <input type="text" wire:model='up2k_activities.{{ $index }}.name'
                                            class="form-control {{ $errors->has('up2k_activities.' . $index . '.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                            placeholder="Nama Usaha UP2K...">
                                        @error('up2k_activities.' . $index . '.name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table table-vcenter card-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="ps-3">
                                    <button type="button" class="btn btn-outline-primary btn-icon" x-on:click="$wire.addEnvHealthActivity()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                    </button>
                                </th>
                                <th>Kegiatan Usaha Kesehatan Lingkungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($env_health_activities as $index => $envHealthActivity)
                                <tr>
                                    <td class="w-6 ps-3">
                                        @if (!empty($envHealthActivity['name']) || (count($env_health_activities) > count($current_env_health_activities) && !$loop->first))
                                            <button type="button" class="btn btn-outline-danger btn-icon"
                                                x-on:click="$wire.removeEnvHealthActivity({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="pe-3">
                                        <input type="text" wire:model='env_health_activities.{{ $index }}.name'
                                            class="form-control {{ $errors->has('env_health_activities.' . $index . '.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                            placeholder="Nama Kegiatan Usaha Kesehatan Lingk....">
                                        @error('env_health_activities.' . $index . '.name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
