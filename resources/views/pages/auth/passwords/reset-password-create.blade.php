<x-app-layout>
    <div class="page-center">
        <div class="page-body">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg">
                        <div class="container container-tight">
                            <div class="text-center mb-4">
                                <img src="{{ asset('src/img/logo-favicon/prov-sumsel.png') }}" height="36" class="avatar avatar-md shadow-none"
                                    alt="">
                                <img src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" height="36" class="avatar avatar-md shadow-none"
                                    alt="">
                            </div>

                            <livewire:app.auth.passwords.reset-password-create :$token :$email />

                            <div class="text-center text-muted mt-3">
                                Lupakan saja, <a wire:navigate href="{{ route('auth.login') }}">Kembali</a> ke halaman masuk.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg d-none d-lg-block">
                        <img src="{{ asset('src/svg/undraw_mail_sent_re_0ofv.svg') }}" height="300" class="d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
