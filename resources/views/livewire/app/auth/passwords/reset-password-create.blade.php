<form class="card card-md" method="post" wire:submit='update' autocomplete="off">
    <div class="card-body">
        <h2 class="text-center mb-4">Atur Ulang Kata Sandi</h2>
        <p class="text-center text-muted mb-4">
            Silahkan buat kata sandi baru untuk akun anda.
        </p>
        <div class="mb-3">
            <label class="form-label required" for='email'>Email</label>
            <input type="email" wire:model='email' id="email" class="form-control" placeholder="Email..." tabindex="1" disabled />
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label required" for='password'>Password Baru</label>
            <div class="input-group input-group-flat" x-data="{ isVisible: false }">
                <input x-bind:type="isVisible ? 'text' : 'password'" wire:model="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Password..." tabindex="2">
                <span class="input-group-text">
                    <a href="javascript:void(0)" x-on:click="$dispatch('visibility'); isVisible = !isVisible;" class="link-secondary"
                        data-bs-toggle="tooltip">
                        <div x-show='!isVisible'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>

                        <div x-show='isVisible'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828"></path>
                                <path
                                    d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87">
                                </path>
                                <path d="M3 3l18 18"></path>
                            </svg>
                        </div>
                    </a>
                </span>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label required" for='password_confirmation'>Konfirmasi Password Baru</label>
            <div class="input-group input-group-flat" x-data="{ isVisible: false }">
                <input x-bind:type="isVisible ? 'text' : 'password'" wire:model="password_confirmation"
                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Konfirmasi Password..." tabindex="3">
                <span class="input-group-text">
                    <a href="javascript:void(0)" x-on:click="$dispatch('visibility'); isVisible = !isVisible;" class="link-secondary"
                        data-bs-toggle="tooltip">
                        <div x-show='!isVisible'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>

                        <div x-show='isVisible'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828"></path>
                                <path
                                    d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87">
                                </path>
                                <path d="M3 3l18 18"></path>
                            </svg>
                        </div>
                    </a>
                </span>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100" tabindex="4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                    <path d="M3 7l9 6l9 -6"></path>
                </svg>
                Simpan Perubahan
            </button>
            </a>
        </div>
    </div>
</form>
