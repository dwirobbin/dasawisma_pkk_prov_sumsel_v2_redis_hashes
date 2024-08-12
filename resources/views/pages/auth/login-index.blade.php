<x-app-layout>
    <div class="page-center">
        <div class="page-body">
            <div class="container px-0">
                <div class="row align-items-center g-4">
                    <div class="col-lg">
                        <div class="container container-tight">
                            <div class="text-center mb-4">
                                <img src="{{ asset('src/img/logo-favicon/prov-sumsel.png') }}" height="36"
                                    class="avatar avatar-md shadow-none bg-transparent" alt="">
                                <img src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" height="36"
                                    class="avatar avatar-md shadow-none bg-transparent" alt="">
                            </div>

                            <livewire:app.auth.form-login />

                            {{-- <div class="text-center text-muted mt-3">
                                Belum punya akun? <a wire:navigate href="{{ route('auth.register') }}" tabindex="4">Daftar</a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg d-none d-lg-block">
                        <img src="{{ asset('src/svg/undraw_sign_in_re_o58h.svg') }}" height="300" class="d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
