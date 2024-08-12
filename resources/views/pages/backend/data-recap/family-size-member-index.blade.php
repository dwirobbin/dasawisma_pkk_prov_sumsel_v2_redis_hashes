<x-app-layout>
    <div class="layout-fluid">

        {{-- Page header --}}
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-6">
                        <div class="text-muted mb-1">
                            <div class="d-flex">
                                <ol class="breadcrumb breadcrumb-arrows">
                                    <li class="breadcrumb-item">
                                        <a wire:navigate href="{{ route('area.data-recap.family-size-members.index') }}">
                                            Rekap Data Jumlah Anggota
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="javascript:void(0);">List</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <h2 class="page-title">Rekap Data Jumlah Anggota</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        @if (str_contains(url()->current(), '/area-code') && strlen($param) == 4)
                            <a wire:navigate href="{{ route('area.data-recap.family-size-members.index') }}" class="btn btn-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Kembali
                            </a>
                        @elseif (str_contains(url()->current(), '/area-code') && strlen($param) == 7)
                            <a wire:navigate href="{{ route('area.data-recap.family-size-members.show-area', str($param)->substr(0, 4)) }}"
                                class="btn btn-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Kembali
                            </a>
                        @elseif (str_contains(url()->current(), '/area-code') && strlen($param) == 10)
                            <a wire:navigate href="{{ route('area.data-recap.family-size-members.show-area', str($param)->substr(0, 7)) }}"
                                class="btn btn-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Kembali
                            </a>
                        @elseif (!is_numeric($param) && !is_null($param))
                            <a wire:navigate href="{{ url()->previous() }}" class="btn btn-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Kembali
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Page body --}}
        <div class="page-body pb-2">
            <div class="container-xl">
                <div class="card">
                    <livewire:app.backend.data-recap.family-size-member-index :$param lazy />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
