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
                                            Dasawisma
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="javascript:void(0);">List</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <h2 class="page-title">Dasawisma</h2>
                    </div>
                    <!-- Page title actions -->
                    @if (auth()->user()->role->id !== 3)
                        <div class="col-auto ms-auto d-print-none">
                            <livewire:app.backend.data-input.dasawismas.create />
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Page body --}}
        <div class="page-body pb-2">
            <div class="container-xl">
                <div class="card">
                    <livewire:app.backend.data-input.dasawismas.table lazy />
                </div>
            </div>
        </div>

        <livewire:app.backend.data-input.dasawismas.edit />

        <livewire:app.backend.data-input.dasawismas.delete />

        <livewire:app.backend.data-input.dasawismas.bulk-delete />
    </div>
</x-app-layout>
