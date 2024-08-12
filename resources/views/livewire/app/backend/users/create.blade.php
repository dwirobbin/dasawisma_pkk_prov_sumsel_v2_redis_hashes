<div class="card">
    <form wire:submit="save" method="post" autocomplete="off" x-data="form">
        <div class="card-body">
            <div class="row">
                <div x-bind:class="$wire.role_id == 1 || $wire.role_id == 2 ? 'col-md-4' : 'col-md-6'">
                    <div class="row">
                        <div x-bind:class="$wire.role_id == 1 || $wire.role_id == 2 ? 'col-12 col-lg-48' : 'col-12 col-lg-24 col-xl-24'"
                            class="mb-3 text-center">
                            <template x-if="imageUrl">
                                <img class="pt-0 rounded-3 object-cover" x-bind:src="imageUrl" style="height: 145px; width: 120px">
                            </template>
                            <template x-if="!imageUrl">
                                <img class="pt-0 rounded-3 object-cover" src="{{ asset('src/img/auth/profile_default.png') }}"
                                    style="height: 145px; width: 120px">
                            </template>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="photo">Foto Profil</label>
                                    <input type="file" id="photo" wire:model='photo'
                                        class="form-control {{ $errors->has('photo') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        accept="image/png,image/jpg,image/jpeg,image/svg,image/gif" x-on:change="fileChosen($event)" />
                                    @error('photo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label required">Nama</label>
                                    <input type="text" wire:model='name'
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                        placeholder="Nama...">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Username</label>
                        <input type="text" wire:model='username'
                            class="form-control {{ $errors->has('username') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Username...">
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="form-label required">Email</label>
                        <input type="text" wire:model='email'
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Email...">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div x-bind:class="$wire.role_id == 1 || $wire.role_id == 2 ? 'col-md-4' : 'col-md-6'">
                    <div class="mb-3">
                        <label class="form-label required">Password</label>
                        <input type="password" wire:model='password'
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Password...">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Konfirmasi Password</label>
                        <input type="password" wire:model='password_confirmation'
                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Konfirmasi Password...">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Role</label>
                        <select wire:model.live='role_id'
                            class="form-select {{ $errors->has('role_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                            <option value='' selected>Pilih Role...</option>
                            @if (!is_null($roles))
                                @foreach ($roles as $role)
                                    <option wire:key='role-{{ $role->id }}' value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('role_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <template x-if="$wire.role_id == 1 || $wire.role_id == 2">
                        <div class="mb-1">
                            <label class="form-label required">No. Telepon</label>
                            <input type="tel" wire:model='phone_number'
                                class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="No. Telepon...">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </template>
                </div>

                <template x-if="$wire.role_id == 1 || $wire.role_id == 2">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <select wire:model.live='province_id'
                                class="form-select {{ $errors->has('province_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>Pilih provinsi...</option>
                                @if (!is_null($provinces))
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kabupaten/Kota</label>
                            <select wire:model.live='regency_id'
                                class="form-select {{ $errors->has('regency_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>Pilih kabupaten/kota...</option>
                                @if (!is_null($regencies))
                                    @foreach ($regencies as $regency)
                                        <option value="{{ $regency->id }}">
                                            {{ $regency->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kecamatan</label>
                            <select wire:model.live='district_id'
                                class="form-select {{ $errors->has('district_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>Pilih kecamatan...</option>
                                @if (!is_null($districts))
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelurahan/Desa</label>
                            <select wire:model.live='village_id'
                                class="form-select {{ $errors->has('village_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                                <option value='' selected>Pilih kel./Desa...</option>
                                @if (!is_null($villages))
                                    @foreach ($villages as $village)
                                        <option value="{{ $village->id }}">
                                            {{ $village->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('village_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

@script
    <script>
        Alpine.data('form', () => {
            return {
                imageUrl: '',
                fileChosen(event) {
                    const file = event.target.files[0];

                    if (!file || file.type.indexOf('image/') === -1) return;
                    if (file.size > 2 * 1024 * 1024) return;

                    let reader = new FileReader();
                    reader.onload = e => {
                        this.imageUrl = e.target.result;
                    }

                    reader.readAsDataURL(file);
                },
            }
        })
    </script>
@endscript
