<x-app-layout>
    <div class="layout-fluid">

        {{-- Page header --}}
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-6">
                        <div class="text-muted mb-1">
                            <div class="d-flex">
                                <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                    <li class="breadcrumb-item">
                                        <a wire:navigate href="{{ route('area.data-input.dasawisma.index') }}">
                                            Anggota Dasawisma
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="javascript:void(0);">List</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <h2 class="page-title">Anggota Dasawisma</h2>
                    </div>
                    <!-- Page title actions -->
                    @if (auth()->user()->role_id != 3)
                        <div class="col-auto ms-auto d-print-none">
                            <a wire:navigate href="{{ route('area.data-input.member.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Tambah
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Page body --}}
        <div class="page-body pb-2">
            <div class="container-xl">
                <div class="card"x-data="{ currentTabMember: $persist('tabsFamily') }">
                    <div class="card-header">
                        <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                            <li @click.prevent="currentTabMember = 'tabsFamily'" class="nav-item">
                                <a href="#tabsFamily" class="nav-link" :class="currentTabMember == 'tabsFamily' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Data Kepala Keluarga
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyBuilding'" class="nav-item">
                                <a href="#tabsFamilyBuilding" class="nav-link" :class="currentTabMember == 'tabsFamilyBuilding' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Data Bangunan
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyNumber'" class="nav-item">
                                <a href="#tabsFamilyNumber" class="nav-link" :class="currentTabMember == 'tabsFamilyNumber' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Data Jumlah Anggota Keluarga
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyMember'" class="nav-item">
                                <a href="#tabsFamilyMember" class="nav-link" :class="currentTabMember == 'tabsFamilyMember' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Data Anggota Keluarga
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyActivity'" class="nav-item">
                                <a href="#tabsFamilyActivity" class="nav-link" :class="currentTabMember == 'tabsFamilyActivity' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Data Aktifitas Keluarga
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamily' ? 'active' : ''"
                                id="tabsFamily">
                                <livewire:app.backend.data-input.members.family-heads.table lazy />
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyBuilding' ? 'active' : ''"
                                id="tabsFamilyBuilding">
                                <livewire:app.backend.data-input.members.family-buildings.table lazy />
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyNumber' ? 'active' : ''"
                                id="tabsFamilyNumber">
                                <livewire:app.backend.data-input.members.family-size-members.table lazy />
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyMember' ? 'active' : ''"
                                id="tabsFamilyMember">
                                <livewire:app.backend.data-input.members.family-members.table lazy />
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyActivity' ? 'active' : ''"
                                id="tabsFamilyActivity">
                                <livewire:app.backend.data-input.members.family-activities.table lazy />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
