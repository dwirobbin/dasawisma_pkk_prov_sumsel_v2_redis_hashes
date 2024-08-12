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
                            <div class="card card-md">
                                <div class="card-body">
                                    <h2 class="text-center mb-4">
                                        Tautan Tidak Valid
                                    </h2>
                                    <div class="text-center text-muted">
                                        <p class="fs-h3">
                                            Maaf, tautan reset password tersebut sudah tidak berlaku, klik tombol di bawah ini untuk mengirim
                                            ulang tautan baru.
                                        </p>
                                    </div>
                                    <div class="form-footer">
                                        <a wire:navigate href="{{ route('password.request') }}" class="btn btn-primary w-100">
                                            Kirim Ulang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg d-none d-lg-block">
                        <img src="{{ asset('src/svg/undraw_warning_re_eoyh.svg') }}" height="300" class="d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
