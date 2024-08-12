<form wire:submit='saveChangeProfileDetail' method="post">
    <div class="row">
        <div class="{{ $user->can(['update-profile']) ? 'col-md-3' : 'col-md-4' }} mb-3">
            <label class="form-label required">Name</label>
            <input type="text" wire:model='name'
                class="form-control {{ $errors->has('name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}" placeholder="Nama..."
                @disabled($user->cannot(['update-profile']))>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="{{ $user->can(['update-profile']) ? 'col-md-3' : 'col-md-4' }} mb-3">
            <label class="form-label required">Username</label>
            <input type="text" wire:model='username'
                class="form-control {{ $errors->has('username') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                placeholder="Username..." @disabled($user->cannot(['update-profile']))>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="{{ $user->can(['update-profile']) ? 'col-md-3' : 'col-md-4' }} mb-3">
            <label class="form-label required">Email</label>
            <input type="email" wire:model='email'
                class="form-control {{ $errors->has('email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                placeholder="Email..." @disabled($user->cannot(['update-profile']))>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        @can(['update-profile'])
            <div class="col-md-3 mb-3">
                <label class="form-label required">No. Telp</label>
                <input type="text" wire:model='phone_number'
                    class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="No. Telp..." @disabled($user->cannot(['update-profile']))>
                @error('phone_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        @endcan
    </div>
    @can(['update-profile'])
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    @endcan
</form>
