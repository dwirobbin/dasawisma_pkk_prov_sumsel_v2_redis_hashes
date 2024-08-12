<div>
    <div class="card">
        <div class="card-header d-flex flex-wrap gap-2">
            <h3 class="card-title">Grafik Rekap Data</h3>
            <div class="ms-auto">
                <div class="input-group">
                    <label class="col-form-label pe-2">Dasawisma:</label>
                    <select class="form-select" wire:model.live='dasawismaSelected'>
                        <option value="" selected>Pilih Dasawisma</option>
                        @foreach ($dataDropdown['dasawismas'] as $dasawisma)
                            <option value="{{ $dasawisma->name }}">{{ $dasawisma->name }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M21 21l-6 -6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div wire:loading.delay class="container">
            <div class="text-center mt-2">
                <span wire:loading role="status" class="spinner-border spinner-border-sm"></span>&ensp;
                <span wire:loading role="status">Memuat..</span>
            </div>
        </div>

        <div wire:loading.class='invisible' class="card-body">
            <div class="row row-cards gap-3">
                <div class="col-md">
                    <div class="row gap-3">
                        <div class="card" style="height: 24rem">
                            <div class="card-status-top bg-red"></div>
                            <div class="card-header">
                                <h3 class="card-title">Grafik Rekap Info Bangunan</h3>
                            </div>
                            <div class="card-body p-0">
                                <livewire:livewire-column-chart key="{{ $familyBuildingChart->reactiveKey() }}" :column-chart-model="$familyBuildingChart" />
                            </div>
                        </div>

                        <div class="card" style="height: 24rem">
                            <div class="card-status-top bg-warning"></div>
                            <div class="card-header">
                                <h3 class="card-title">Grafik Rekap Anggota Keluarga</h3>
                            </div>
                            <div class="card-body p-0">
                                <livewire:livewire-column-chart key="{{ $familyMemberChart->reactiveKey() }}" :column-chart-model="$familyMemberChart" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row gap-3">
                        <div class="card" style="height: 24rem">
                            <div class="card-status-top bg-success"></div>
                            <div class="card-header">
                                <h3 class="card-title">Grafik Rekap Jumlah Anggota</h3>
                            </div>
                            <div class="card-body p-0">
                                <livewire:livewire-pie-chart key="{{ $familyNumberChart->reactiveKey() }}" :pie-chart-model="$familyNumberChart" />
                            </div>
                        </div>
                        <div class="card" style="height: 24rem">
                            <div class="card-status-top bg-blue"></div>
                            <div class="card-header">
                                <h3 class="card-title">Grafik Rekap Kegiatan Warga</h3>
                            </div>
                            <div class="card-body p-0">
                                <livewire:livewire-pie-chart key="{{ $familyActivityChart->reactiveKey() }}" :pie-chart-model="$familyActivityChart" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-slot name="scripts">
    <script src="{{ asset('src/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
</x-slot>
