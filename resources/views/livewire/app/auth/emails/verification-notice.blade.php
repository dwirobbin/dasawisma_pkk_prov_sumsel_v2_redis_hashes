<div>

    @if (session()->has('message'))
        <div class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible" role="alert">
            <div class="d-flex">
                @if (session('message')['type'] == 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check me-2" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M9 12l2 2l4 -4"></path>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon me-1" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                @endif
                <div>{{ session('message')['text'] }}</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif

    <div class="card card-md">
        <div class="card-body">
            <h2 class="text-center mb-4">Cek Email Anda</h2>
            <div class="text-center text-muted">
                <p class="fs-h3">
                    Kami telah mengirimkan tautan verifikasi ke email <strong>{{ auth()->user()->email }}</strong>.<br />
                    Silahkan klik tautan tersebut untuk mengkonfirmasi email anda.
                </p>
                <p class="mt-3">
                    Email tidak masuk? Periksa folder spam.<br />
                    Email salah? <a wire:navigate href="{{ route('auth.register') }}">daftar ulang dengan email yang valid</a>.
                </p>
                <p class="mt-3">
                    Jika tautan verifikasi tersebut sudah tidak berlaku, klik tombol biru di bawah ini untuk meminta tautan baru.
                </p>
            </div>
            <div class="form-footer d-flex flex-wrap flex-sm-nowrap gap-3">
                <button type="submit" wire:click="resendNotification" class="btn btn-primary w-100" tabindex="6" wire:loading.attr='disabled'>
                    <span wire:loading.remove wire:target='resendNotification'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-up" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 19h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v5.5" />
                            <path d="M19 22v-6" />
                            <path d="M22 19l-3 -3l-3 3" />
                            <path d="M3 7l9 6l9 -6" />
                        </svg>
                        Kirim Ulang Verifikasi
                    </span>

                    <span wire:loading wire:target="resendNotification" role="status" class="spinner-border spinner-border-sm"></span>&ensp;
                    <span wire:loading wire:target="resendNotification" role="status">Loading..</span>
                </button>
                <button type="button" wire:click="logoutHandler" class="btn w-100" wire:loading.attr='disabled'>
                    <span wire:loading.remove wire:target='logoutHandler'>
                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M9 12h12l-3 -3" />
                            <path d="M18 15l3 -3" />
                        </svg>
                        Logout
                    </span>

                    <span wire:loading wire:target="logoutHandler" role="status" class="spinner-border spinner-border-sm"></span>&ensp;
                    <span wire:loading wire:target="logoutHandler" role="status">Loading..</span>
                </button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            @this.on('remove-alert', () => {
                setTimeout(() => {
                    $(".alert").fadeOut(300);
                }, 5000);
            })
        })
    </script>
@endscript
