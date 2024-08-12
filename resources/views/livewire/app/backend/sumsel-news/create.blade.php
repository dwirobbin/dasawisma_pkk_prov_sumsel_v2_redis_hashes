<div class="card" x-data="form()">
    <form>
        <div class="card-body py-4">
            <div class="row">
                <div class="col-sm-5 col-md-4 col-lg-3 mb-3">
                    <template x-if="imageUrl">
                        <img class="img-fluid object-fit-cover rounded-3" x-bind:src="imageUrl" width="100%" style="max-height: 155px">
                    </template>

                    <template x-if="!imageUrl">
                        <img class="img-fluid object-fit-cover rounded-3" src="{{ asset('src/img/default-img.png') }}" width="100%"
                            style="max-height: 155px">
                    </template>
                </div>
                <div class="col-sm-7 col-md-8 col-lg-9">
                    <div class="mb-3">
                        <label for="title" class="form-label required">Judul</label>
                        <input type="text" id="title" wire:model='form.title'
                            class="form-control {{ $errors->has('form.title') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Judul...">
                        @error('form.title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="imgCover" class="form-label">Sampul</label>
                        <input type="file" id="imgCover" wire:model="form.image" x-on:change="fileChosen($event)"
                            class="form-control {{ $errors->has('form.image') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            accept="image/png,image/jpg,image/jpeg,image/svg,image/gif" />
                        @error('form.image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <div wire:ignore>
                        <div id="text-editor" x-data x-ref="quillEditor" x-init="const quill = new Quill($refs.quillEditor, {
                            placeholder: 'Deskripsi...',
                            theme: 'snow'
                        });
                        quill.on('text-change', function() {
                            $wire.set('form.body', quill.root.innerHTML);
                        });">
                            {!! $form->body !!}
                        </div>
                    </div>
                    @error('form.body')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Dipublish ?</label>
                    <div class="d-flex align-items-center">
                        <span class="text-muted">No</span>
                        <label class="form-check form-switch mb-0 px-1" style="min-height: 0; ">
                            <input class="form-check-input ms-0" type="checkbox" wire:model='form.is_published' />
                        </label>
                        <span class="text-muted">Yes</span>
                    </div>
                    @error('form.is_published')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" wire:click='save' class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

@script
    <script>
        Alpine.data('form', () => {
            return {
                imageUrl: '',

                fileChosen(event) {
                    let file = event.target.files[0];

                    if (!file || file.type.indexOf('image/') === -1) return;
                    if (file.size > 2 * 1024 * 1024) return;

                    let reader = new FileReader();
                    reader.readAsDataURL(file);

                    reader.onload = e => {
                        this.imageUrl = e.target.result;
                    }
                },
            }
        });
    </script>
@endscript
