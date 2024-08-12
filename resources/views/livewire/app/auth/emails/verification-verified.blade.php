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
            <h2 class="text-center mb-4">Email Anda Telah Terverifikasi</h2>
            <div class="text-muted">
                <p class="fs-h3 text-center">
                    Semua tindakan yang membutuhkan proses verifikasi akun telah bisa anda lakukan. mohon gunakan website ini dengan bijak!!
                </p>
                <p class="mt-3 text-left">
                    Hormat Kami <br />
                    Tim <b>{{ config('app.name') }}</b>
                </p>
            </div>
            <div class="form-footer d-flex flex-wrap flex-sm-nowrap gap-3">
                <a wire:navigate href="{{ route('home') }}" class="btn btn-primary w-100" tabindex="6">
                    <span wire:loading.remove wire:target='resendNotification'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        Ke Halaman Utama
                    </span>

                    <span wire:loading wire:target="resendNotification" role="status" class="spinner-border spinner-border-sm"></span>&ensp;
                    <span wire:loading wire:target="resendNotification" role="status">Loading..</span>
                </a>
                <button type="button" wire:click="logoutHandler" class="btn w-100">
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
