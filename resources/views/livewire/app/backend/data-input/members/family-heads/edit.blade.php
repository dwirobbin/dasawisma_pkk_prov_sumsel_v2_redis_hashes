<div wire:ignore.self x-data="modalFamilyHeadEdit()" x-on:open-modal-family-head-edit.window="open($event)"
    x-on:close-modal-family-head-edit.window="close" x-on:keydown.escape.window="close" class="modal modal-blur fade" id="modal-family-head-edit"
    tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Kepala Keluarga</h5>
                <button type="button" class="btn-close" x-on:click="$dispatch('close-modal-family-head-edit')" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="dasawisma_id" class="form-label">Dasawisma</label>
                    <select id="dasawisma_id" wire:model='dasawisma_id'
                        class="form-select {{ $errors->has('dasawisma_id') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                        <option value=''>---Pilih Dasawisma---</option>
                        @isset($dasawismas)
                            @foreach ($dasawismas as $dasawisma)
                                <option id='dasawisma-{{ $dasawisma->id }}' value="{{ $dasawisma->id }}" @selected($dasawisma_id == $dasawisma->id)>
                                    {{ $dasawisma->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    @error('dasawisma_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kk_number" class="form-label required">No. KK</label>
                    <input type="number" id="kk_number" wire:model='kk_number'
                        class="form-control {{ $errors->has('kk_number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('kk_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="family_head" class="form-label required">Nama Kepala keluarga</label>
                    <input type="text" id="family_head" wire:model='family_head'
                        class="form-control {{ $errors->has('family_head') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('family_head')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" x-on:click="$dispatch('close-modal-family-head-edit')">Batal</button>
                <button type="submit" wire:click='saveChange' class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('modalFamilyHeadEdit', () => {
            return {
                modalEl: document.getElementById('modal-family-head-edit'),
                open(e) {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).show();
                },
                close() {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).hide();
                    $wire.resetForm();
                },
            }
        })
    </script>
@endscript
