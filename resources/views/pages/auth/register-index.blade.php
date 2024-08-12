<x-app-layout>
    <div class="page-center">
        <div class="page-body">
            <div class="container px-0">
                <div class="row align-items-center g-4">
                    <div class="col-lg">
                        <div class="container">
                            <div class="text-center mb-4">
                                <img src="{{ asset('src/img/logo-favicon/prov-sumsel.png') }}" height="36" class="avatar avatar-md shadow-none"
                                    alt="">
                                <img src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" height="36" class="avatar avatar-md shadow-none"
                                    alt="">
                            </div>

                            <livewire:app.auth.form-register />

                            <div class="text-center text-muted mt-3">
                                Sudah punya akun? <a wire:navigate href="{{ route('auth.login') }}" tabindex="7">Masuk</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg d-none d-lg-block">
                        <img src="{{ asset('src/svg/undraw_my_password_re_ydq7.svg') }}" height="300" class="d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
