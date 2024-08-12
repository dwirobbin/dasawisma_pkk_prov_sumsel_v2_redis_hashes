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

            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped table-hover">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <button type="button" class="btn btn-outline-primary w-100 btn-icon" x-on:click="$wire.addFamilyMember()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                </button>
                            </th>
                            <th rowspan="2">No. NIK</th>
                            <th rowspan="2">Nama Lengkap <label class="text-danger">*</label></th>
                            <th rowspan="2">Tgl Lahir <label class="text-danger">*</label></th>
                            <th colspan="2" class="text-center">Status <label class="text-danger">*</label></th>
                            <th rowspan="2">Jenis Kelamin <label class="text-danger">*</label></th>
                            <th rowspan="2">Pendidikan Terakhir <label class="text-danger">*</label></th>
                            <th rowspan="2">Pekerjaan</th>
                        </tr>
                        <tr>
                            <th>Di Keluarga</th>
                            <th>Pernikahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($family_members as $index => $familyMember)
                            <tr>
                                <td>
                                    @if (count($family_members) > count($current_family_members) && $index > count($current_family_members) - 1)
                                        <button type="button" class="btn btn-outline-danger w-100 btn-icon"
                                            x-on:click="$wire.removeFamilyMember({{ $index }})">
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
                                <td>
                                    <input type="text" wire:model='family_members.{{ $index }}.nik_number'
                                        class="form-control {{ $errors->has('family_members.' . $index . '.nik_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        placeholder="No. NIK..." style="width: 10rem">
                                    @error('family_members.' . $index . '.nik_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" wire:model='family_members.{{ $index }}.name'
                                        class="form-control {{ $errors->has('family_members.' . $index . '.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        placeholder="Nama Lengkap..." style="width: 12rem" @readonly($loop->first)>
                                    @error('family_members.' . $index . '.name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="date" wire:model='family_members.{{ $index }}.birth_date'
                                        class="form-control {{ $errors->has('family_members.' . $index . '.birth_date') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        placeholder="Tgl. Lahir" style="width: 11rem">
                                    @error('family_members.' . $index . '.birth_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select wire:model='family_members.{{ $index }}.status'
                                        class="form-select {{ $errors->has('family_members.' . $index . '.status') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        style="width: 12rem" @disabled($loop->first)>
                                        <option value="">Status di Keluarga</option>
                                        <option value="Kepala Keluarga" @selected(!empty('family_members.0.name'))>Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Keluarga">Keluarga</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                    </select>
                                    @error('family_members.' . $index . '.status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select wire:model='family_members.{{ $index }}.marital_status'
                                        class="form-select {{ $errors->has('family_members.' . $index . '.marital_status') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        style="width: 12rem">
                                        <option value="">Status Pernikahan</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Janda">Janda</option>
                                        <option value="Duda">Duda</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                    </select>
                                    @error('family_members.' . $index . '.marital_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select wire:model='family_members.{{ $index }}.gender'
                                        class="form-select {{ $errors->has('family_members.' . $index . '.gender') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        style="width: 11rem">
                                        <option value="">Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('family_members.' . $index . '.gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select wire:model='family_members.{{ $index }}.last_education'
                                        class="form-select {{ $errors->has('family_members.' . $index . '.last_education') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        style="width: 12rem">
                                        <option value="">Pendidikan Terakhir</option>
                                        <option value="TK/PAUD">TK/PAUD</option>
                                        <option value="SD/MI">SD/MI</option>
                                        <option value="SLTP/SMP/MTS">SLTP/SMP/MTS</option>
                                        <option value="SLTA/SMA/MA/SMK">SLTA/SMA/MA/SMK</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="Belum/Tidak Sekolah">Belum/Tidak Sekolah</option>
                                    </select>
                                    @error('family_members.' . $index . '.last_education')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" wire:model='family_members.{{ $index }}.profession'
                                        class="form-control {{ $errors->has('family_members.' . $index . '.profession') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        placeholder="Pekerjaan..." style="width: 12rem">
                                    @error('family_members.' . $index . '.profession')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
