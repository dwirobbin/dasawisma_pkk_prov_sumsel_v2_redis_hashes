<div>
    @if (session()->has('message'))
        <div class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible" role="alert">
            <div class="d-flex gap-1">
                @if (session('message')['type'] == 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M9 12l2 2l4 -4"></path>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24"
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

    <form wire:submit='registerHandler' class="card card-md" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="text-center mt-0 mb-4">Buat Akun Baru Anda</h2>

            <div class="row row-cards">
                <div class="col-12">
                    <label class="form-label required">Nama</label>
                    <input type="text" wire:model="name"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="Nama..." autofocus tabindex="1">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label required">Username</label>
                    <input type="text" wire:model="username"
                        class="form-control {{ $errors->has('username') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="Username..." tabindex="2">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label required">Email</label>
                    <input type="email" wire:model="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="Email..." tabindex="3">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label required">Password</label>
                    <div class="input-group input-group-flat" x-data="{ isVisible: false }">
                        <input x-bind:type="isVisible ? 'text' : 'password'" wire:model="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Password..." tabindex="4">
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
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="form-label required">Konfirmasi Password</label>
                    <div class="input-group input-group-flat" x-data="{ isVisible: false }">
                        <input x-bind:type="isVisible ? 'text' : 'password'" wire:model="password_confirmation"
                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Konfirmasi Password..." tabindex="5">
                        <span class="input-group-text">
                            <a href="javascript:void(0)" x-on:click="$dispatch('visibility'); isVisible = !isVisible;" class="link-secondary"
                                data-bs-toggle="tooltip">
                                <div x-show='!isVisible'>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </div>

                                <div x-show='isVisible'>
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
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" tabindex="6" wire:loading.attr='disabled'>
                    <span wire:loading.remove wire:target='registerHandler'>
                        Daftar
                    </span>

                    <span wire:loading wire:target="registerHandler" role="status" class="spinner-border spinner-border-sm"></span>&ensp;
                    <span wire:loading wire:target="registerHandler" role="status">Loading..</span>
                </button>
            </div>
        </div>
    </form>
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
