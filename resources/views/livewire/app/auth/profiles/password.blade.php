<form wire:submit='saveChangePassword' method="post">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label required">Kata Sandi Saat Ini</label>
            <div class="input-group input-group-flat" x-data="{ isVisibleCurrentPassword: false }">
                <input :type="isVisibleCurrentPassword ? 'text' : 'password'" wire:model='current_password'
                    class="form-control {{ $errors->has('current_password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Kata sandi saat ini..." tabindex="1" autofocus />
                <span class="input-group-text">
                    <a x-on:click="isVisibleCurrentPassword = !isVisibleCurrentPassword" href="#" class="link-secondary"
                        data-bs-toggle="tooltip">
                        <div x-show='!isVisibleCurrentPassword'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>

                        <div x-show='isVisibleCurrentPassword'>
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
            </div>
            @error('current_password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label required">Kata Sandi Baru</label>
            <div class="input-group input-group-flat" x-data="{ isVisiblePassword: false }">
                <input :type="isVisiblePassword ? 'text' : 'password'" wire:model='password'
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Kata sandi baru..." tabindex="2" />
                <span class="input-group-text">
                    <a x-on:click="isVisiblePassword = !isVisiblePassword" href="#" class="link-secondary" data-bs-toggle="tooltip">
                        <div x-show='!isVisiblePassword'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>

                        <div x-show='isVisiblePassword'>
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
            </div>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label required">Konfirmasi Kata Sandi</label>
            <div class="input-group input-group-flat" x-data="{ isVisiblePasswordConfirmation: false }">
                <input :type="isVisiblePasswordConfirmation ? 'text' : 'password'" wire:model='password_confirmation'
                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Konfirmasi kata sandi baru..." tabindex="3" />
                <span class="input-group-text">
                    <a x-on:click="isVisiblePasswordConfirmation = !isVisiblePasswordConfirmation" href="#" class="link-secondary"
                        data-bs-toggle="tooltip">
                        <div x-show='!isVisiblePasswordConfirmation'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </div>

                        <div x-show='isVisiblePasswordConfirmation'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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
            </div>
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
