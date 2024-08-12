<div class="card-body">
    <form wire:submit="save" method="post" autocomplete="off">

        <ul class="steps steps-green steps-counter mb-4">
            <li class="step-item" x-bind:class="{ 'active': $wire.currentStep == 1 }"></li>
            <li class="step-item" x-bind:class="{ 'active': $wire.currentStep == 2 }"></li>
            <li class="step-item" x-bind:class="{ 'active': $wire.currentStep == 3 }"></li>
            <li class="step-item" x-bind:class="{ 'active': $wire.currentStep == 4 }"></li>
            <li class="step-item" x-bind:class="{ 'active': $wire.currentStep == 5 }"></li>
        </ul>

        {{-- Step 1 --}}
        <div x-bind:class="$wire.currentStep == 1 ? '' : 'd-none'">
            <div class="row mb-3">
                <label class="col-md-3 form-label required">Dasawisma</label>
                <div class="col-md-9">
                    <select wire:model='dasawisma_id'
                        class="form-select {{ $errors->has('dasawisma_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                        <option value='' selected>---Pilih Dasawisma---</option>
                        @isset($dasawismas)
                            @foreach ($dasawismas as $dasawisma)
                                <option id="dasawisma-{{ $dasawisma->id }}" value="{{ $dasawisma->id }}">
                                    {{ $dasawisma->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    @error('dasawisma_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-3 form-label required">No. KK</label>
                <div class="col-md-9">
                    <input type="text" wire:model='kk_number'
                        class="form-control {{ $errors->has('kk_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="No. KK...">
                    @error('kk_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-3 form-label required">Nama Kepala Keluarga</label>
                <div class="col-md-9">
                    <input type="text" wire:model.live='family_head'
                        class="form-control {{ $errors->has('family_head') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="Nama Kepala Keluarga...">
                    @error('family_head')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-footer d-flex justify-content-between">
                <a wire:navigate href="{{ route('area.data-input.member.index') }}" class="btn btn-danger me-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M10 10l4 4m0 -4l-4 4" />
                    </svg>
                    Batal
                </a>
                <button type="button" wire:click="firstStepSubmit" class="btn btn-primary" wire:loading.attr='disabled'>
                    <span wire:loading.remove wire:target='firstStepSubmit'>Lanjut</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='firstStepSubmit'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>

                    <span wire:loading wire:target="firstStepSubmit" role="status">Loading..</span>
                    <span wire:loading wire:target="firstStepSubmit" class="spinner-border spinner-border-sm ms-2"></span>
                </button>
            </div>
        </div>

        {{-- Step 2 --}}
        <div x-bind:class="$wire.currentStep == 2 ? '' : 'd-none'">
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
                            <input type="checkbox" id="sungai" wire:model='water_src' class="form-check-input" value="Sungai"
                                role="button">
                            <span class="form-check-label text-muted">Sungai</span>
                        </label>
                        <label class="form-check" role="button" for="lainnya">
                            <input type="checkbox" id="lainnya" wire:model='water_src' class="form-check-input" value="Lainnya"
                                role="button">
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
                                <input type="radio" name="staple_food" wire:model.blur="staple_food" class="form-check-input"
                                    value="Beras" role="button">
                                <span class="form-check-label text-muted">Beras</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="staple_food" wire:model.blur="staple_food" class="form-check-input"
                                    value="Non Beras" role="button">
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
            <div class="form-footer d-flex justify-content-between">
                <button type="button" x-on:click="$wire.back(1)" class="btn btn-secondary me-auto" wire:loading.attr='disabled'
                    wire:target='back(1)'>
                    <span wire:loading wire:target="back(1)" class="spinner-border spinner-border-sm me-2"></span>
                    <span wire:loading wire:target="back(1)" role="status">Loading..</span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='back(1)'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>
                    <span wire:loading.remove wire:target='back(1)'>Sebelumnya</span>
                </button>
                <button type="button" x-on:click="$wire.secondStepSubmit()" class="btn btn-primary" wire:loading.attr='disabled'
                    wire:target='secondStepSubmit'>
                    <span wire:loading.remove wire:target='secondStepSubmit'>Lanjut</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='secondStepSubmit'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>

                    <span wire:loading wire:target="secondStepSubmit" role="status">Loading..</span>
                    <span wire:loading wire:target="secondStepSubmit" class="spinner-border spinner-border-sm ms-2"></span>
                </button>
            </div>
        </div>

        {{-- Step 3 --}}
        <div x-bind:class="$wire.currentStep == 3 ? '' : 'd-none'">
            <div class="table-responsive">
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

            <div class="form-footer d-flex justify-content-between">
                <button type="button" x-on:click="$wire.back(2)" class="btn btn-secondary" wire:loading.attr='disabled'
                    wire:target='back(2)'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='back(2)'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>
                    <span wire:loading.remove wire:target='back(2)'>Sebelumnya</span>

                    <span wire:loading wire:target="back(2)" class="spinner-border spinner-border-sm me-2"></span>
                    <span wire:loading wire:target="back(2)" role="status">Loading..</span>
                </button>
                <button type="button" x-on:click="$wire.thirdStepSubmit()" class="btn btn-primary" wire:loading.attr='disabled'
                    wire:target='thirdStepSubmit'>
                    <span wire:loading.remove wire:target='thirdStepSubmit'>Lanjut</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='thirdStepSubmit'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>

                    <span wire:loading wire:target="thirdStepSubmit" role="status">Loading..</span>
                    <span wire:loading wire:target="thirdStepSubmit" class="spinner-border spinner-border-sm ms-2"></span>
                </button>
            </div>
        </div>

        {{-- Step 4 --}}
        <div x-bind:class="$wire.currentStep == 4 ? '' : 'd-none'">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped table-hover">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <button type="button" class="btn btn-outline-primary w-100 btn-icon" x-on:click="$wire.addFamilyMember()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
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
                                    @if (!$loop->first)
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

            <div class="form-footer d-flex justify-content-between">
                <button type="button" x-on:click="$wire.back(3)" class="btn btn-secondary" wire:loading.attr='disabled'
                    wire:target='back(3)'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='back(3)'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>
                    <span wire:loading.remove wire:target='back(3)'>Sebelumnya</span>

                    <span wire:loading wire:target="back(3)" class="spinner-border spinner-border-sm me-2"></span>
                    <span wire:loading wire:target="back(3)" role="status">Loading..</span>
                </button>
                <button type="button" x-on:click="$wire.forthStepSubmit()" class="btn btn-primary" wire:loading.attr='disabled'
                    wire:target='forthStepSubmit'>
                    <span wire:loading.remove wire:target='forthStepSubmit'>Lanjut</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='forthStepSubmit'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>

                    <span wire:loading wire:target="forthStepSubmit" role="status">Loading..</span>
                    <span wire:loading wire:target="forthStepSubmit" class="spinner-border spinner-border-sm ms-2"></span>
                </button>
            </div>
        </div>

        {{-- Step 5 --}}
        <div x-bind:class="$wire.currentStep == 5 ? '' : 'd-none'">
            <div class="row row-gap-4 mb-2">
                <div class="col-12 col-md-6">
                    <table class="table table-vcenter card-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="ps-3">
                                    <button type="button" class="btn btn-outline-primary btn-icon" x-on:click="$wire.addUp2kActivity()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                                        @if (!$loop->first)
                                            <button type="button" class="btn btn-outline-danger btn-icon"
                                                x-on:click="$wire.removeUp2kActivity({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                                        @if (!$loop->first)
                                            <button type="button" class="btn btn-outline-danger btn-icon"
                                                x-on:click="$wire.removeEnvHealthActivity({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
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

            <div class="form-footer d-flex justify-content-between">
                <button type="button" x-on:click="$wire.back(4)" class="btn btn-secondary" wire:loading.attr='disabled'
                    wire:target='back(4)'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='back(4)'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>
                    <span wire:loading.remove wire:target='back(4)'>Sebelumnya</span>

                    <span wire:loading wire:target="back(4)" class="spinner-border spinner-border-sm me-2"></span>
                    <span wire:loading wire:target="back(4)" role="status">Loading..</span>
                </button>
                <button type="submit" class="btn btn-primary" wire:loading.attr='disabled' wire:target='save'>
                    <span wire:loading.remove wire:target='save'>Simpan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy ms-2 me-0" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" wire:loading.remove wire:target='save'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M14 4l0 4l-6 0l0 -4" />
                    </svg>

                    <span wire:loading wire:target="save" role="status">Loading..</span>
                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm ms-2"></span>
                </button>
            </div>
        </div>
    </form>
</div>
