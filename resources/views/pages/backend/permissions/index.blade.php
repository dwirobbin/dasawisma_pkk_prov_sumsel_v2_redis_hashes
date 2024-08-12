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
                                        <a wire:navigate href="{{ route('area.permissions.index') }}">
                                            Permission
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="javascript:void(0);">List</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <h2 class="page-title">Permission</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Page body --}}
        <div class="page-body pb-2">
            <div class="container-xl">
                <div class="row">
                    <div class="col-md-4">
                        <livewire:app.backend.permissions.form />
                    </div>
                    <div class="col-md-8">
                        <livewire:app.backend.permissions.table lazy />
                    </div>
                </div>
            </div>
        </div>

        <livewire:app.backend.permissions.delete />

        <livewire:app.backend.permissions.bulk-delete />
    </div>
</x-app-layout>
