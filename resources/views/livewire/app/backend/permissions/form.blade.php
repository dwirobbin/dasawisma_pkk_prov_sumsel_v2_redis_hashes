<form wire:submit='save' class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $isUpdate ? 'Edit' : 'Tambah' }} Permission</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label required">Nama Permission</label>
            <div>
                <input type="text" id="name" wire:model='form.name'
                    class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="Nama Permission...">
                @error('form.name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <button type="button" id="reset" wire:click='resetForm' class="btn btn-secondary" wire:loading.attr="disabled"
            @disabled(!$isUpdate)>
            <span wire:loading.remove wire:target="resetForm">{{ $isUpdate ? 'Reset' : 'Clear' }}</span>

            <span wire:loading wire:target="resetForm" class="spinner-border spinner-border-sm me-2"></span>
            <span wire:loading wire:target="resetForm" role="status">Loading..</span>
        </button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" @disabled(!$isUpdate)>
            <span wire:loading.remove wire:target="save">{{ $isUpdate ? 'Simpan Perubahan' : 'Simpan' }}</span>

            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
            <span wire:loading wire:target="save" role="status">Loading..</span>
        </button>
    </div>
</form>

@script
    <script>
        const toggleReset = function() {
            const resetBtn = document.getElementById("reset");
            if ($wire.form.name !== '' || $wire.isUpdate) {
                resetBtn.removeAttribute("disabled");
            } else {
                resetBtn.setAttribute("disabled", "disabled");
            }
        };
        document.querySelector("form").addEventListener("input", toggleReset, false);

        const toggleSubmit = function() {
            const el = document.querySelectorAll("input[type=text]");
            let isDisabled = ![].some.call($el, (input) => input.value.length);

            const submitBtn = document.querySelector("button[type=submit]");
            if ($wire.form.name === '') {
                submitBtn.setAttribute("disabled", "disabled");
            } else {
                submitBtn.removeAttribute("disabled");
            }
        }
        document.querySelector("form").addEventListener("input", toggleSubmit, false);
    </script>
@endscript
