<div wire:ignore>
    <textarea id="text-area" rows="7" class="form-control" placeholder="Deskripsi..." x-data x-ref="quillEditor" x-init="quill = new Quill($refs.quillEditor, { theme: 'snow' });
    quill.on('text-change', function() {
        $dispatch('input', quill.root.innerHTML);
    });"
        {{ $attributes }}>
    </textarea>
</div>
