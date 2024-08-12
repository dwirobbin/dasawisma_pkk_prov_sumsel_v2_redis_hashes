<div>
    <form class="card card-md" method="post" wire:submit='sendResetPasswordLink' autocomplete="off">
        <div class="card-body">
            <h2 class="text-center mb-4">Lupa Kata Sandi</h2>
            <p class="text-muted mb-4">
                Untuk mereset kata sandi, Masukkan email anda dan kami akan mengirim pesan lewat email anda.
            </p>
            <div class="mb-3">
                <label class="form-label required" for='email'>Email</label>
                <input type="text" wire:model='email' id="email" class="form-control" placeholder="Email..." tabindex="1" autofocus />
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" tabindex="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                        <path d="M3 7l9 6l9 -6"></path>
                    </svg>
                    Kirim
                </button>
            </div>
        </div>
    </form>
</div>
