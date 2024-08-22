<div class="row row-deck row-cards">
    <div class="col-12">
        <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ format_number($dataCount['users']->users_count) }}
                                </div>
                                <div class="text-muted">
                                    Users
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stack-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 4l-8 4l8 4l8 -4l-8 -4"></path>
                                        <path d="M4 12l8 4l8 -4"></path>
                                        <path d="M4 16l8 4l8 -4"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ format_number($dataCount['dasawismas']->dasawismas_count) }}
                                </div>
                                <div class="text-muted">
                                    Dasawisma
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-twitter text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ format_number($dataCount['families']->families_count) }}
                                </div>
                                <div class="text-muted">
                                    Kepala Keluarga
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-facebook text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ format_number($dataCount['family_members']->family_members_count) }}
                                </div>
                                <div class="text-muted">
                                    Anggota Keluarga
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
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
    </div> --}}
</div>

<x-slot name="scripts">
    {{-- <script src="{{ asset('src/libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}
</x-slot>
