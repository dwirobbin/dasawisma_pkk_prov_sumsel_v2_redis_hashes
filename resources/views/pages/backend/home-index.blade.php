<x-app-layout>
    <div class="layout-fluid">

        {{-- Page header --}}
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-6">
                        <h2 class="page-title">Beranda</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Page body --}}
        <div class="page-body pb-2">
            <div class="container-xl">
                @livewire('app.backend.home', ['lazy' => true])
            </div>
        </div>
    </div>
</x-app-layout>
