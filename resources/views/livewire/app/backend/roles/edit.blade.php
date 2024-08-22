<div class="card">
    <div class="card-body pt-4">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="name" class="form-label required">Nama Role</label>
                    <input type="text" id="name" wire:model='form.name'
                        class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        placeholder="Nama Role...">
                    @error('form.name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="button" wire:click='saveChange' class="btn btn-primary">Simpan Perubahan</button>
    </div>
</div>
