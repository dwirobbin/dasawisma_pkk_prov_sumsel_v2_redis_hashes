<div>
    <div class="card-header py-2 d-flex flex-wrap justify-content-center justify-content-md-between gap-2">
        <div class="text-muted">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                </select>
                data
            </label>
        </div>
        <div class="text-muted">
            <div class="input-icon">
                <input type="text" wire:model.live.debounce.300ms='search' class="form-control" placeholder="Cari...">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-2">
        <div class="row g-2">
            <div class="col-md-3 form-group">
                <label class="text-muted">Provinsi:</label>
                <select wire:model.live='provinceId' class="form-select">
                    <option value='' selected>---Pilih Provinsi---</option>
                    @isset($provinces)
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">
                                {{ $province->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label class="text-muted">Kabupaten/Kota:</label>
                <select wire:model.live='regencyId' class="form-select">
                    <option value='' selected>---Pilih Kabupaten/Kota---</option>
                    @isset($regencies)
                        @foreach ($regencies as $regency)
                            <option value="{{ $regency->id }}">
                                {{ $regency->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label class="text-muted">Kecamatan:</label>
                <select wire:model.live='districtId' class="form-select">
                    <option value='' selected>---Pilih Kecamatan---</option>
                    @isset($districts)
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">
                                {{ $district->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label class="text-muted">Kelurahan/Desa:</label>
                <select wire:model.live='villageId' class="form-select">
                    <option value='' selected>---Pilih Kelurahan/Desa---</option>
                    @isset($villages)
                        @foreach ($villages as $village)
                            <option value="{{ $village->id }}">
                                {{ $village->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div wire:loading.delay class="container">
        <div class="text-center mt-2">
            <span wire:loading role="status" class="spinner-border spinner-border-sm"></span>&ensp;
            <span wire:loading role="status">Memuat..</span>
        </div>
    </div>

    <div wire:loading.class='invisible' class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>
                        <span class="d-inline-block py-1">Dasawisma</span>
                    </th>
                    <th>
                        <span class="d-inline-block py-1">Wilayah</span>
                    </th>
                    <th>
                        <span class="d-inline-block py-1">RT</span>
                    </th>
                    <th>
                        <span class="d-inline-block py-1">RW</span>
                    </th>
                    @if (auth()->user()->role->id !== 3)
                        <th class="w-1">
                            Aksi
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($this->dasawismas as $dasawisma)
                    <tr wire:key='{{ $dasawisma->id }}'>
                        <th class="text-muted">
                            {{ ($this->dasawismas->currentPage() - 1) * $this->dasawismas->perPage() + $loop->iteration }}
                        </th>
                        <td>{{ $dasawisma->name }}</td>
                        <td class="text-muted">{{ $dasawisma->area }}</td>
                        <td class="text-muted">{{ $dasawisma->rt }}</td>
                        <td class="text-muted">{{ $dasawisma->rw }}</td>
                        @if (auth()->user()->role->id !== 3)
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <button x-on:click="$dispatch('set-data', { id: {{ $dasawisma->id }} })"
                                        class="form-selectgroup-label bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit text-white"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                    </button>
                                    <button
                                        wire:click="$dispatchTo('app.backend.data-input.dasawismas.delete', 'delete-confirm', { id: {{ $dasawisma->id }}, name: '{{ $dasawisma->name }}' })"
                                        class="form-selectgroup-label bg-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash text-white"
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
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-info">
                            {{ empty($this->dasawismas) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div wire:loading.class='invisible'>
        @if (method_exists($this->dasawismas, 'hasPages'))
            @if ($this->dasawismas->hasPages())
                <div class="card-footer py-2 d-flex justify-content-center align-items-center">
                    {{ $this->dasawismas->links('paginations.custom-simple-pagination-links') }}
                </div>
            @endif
        @endif
    </div>
</div>
