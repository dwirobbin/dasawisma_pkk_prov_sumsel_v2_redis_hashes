<div x-data="modalConfirmDelete" x-on:open-modal.window="open($event)" x-on:close-modal.window="close" x-on:keydown.escape.window="close"
    class="modal modal-blur fade" id="modal-confirm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" x-on:click="$dispatch('close-modal')"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h3>Apakah anda yakin ?</h3>
                <div class="text-muted" id="content"></div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn w-100" x-on:click="$dispatch('close-modal')">
                                Batal
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" wire:click="delete" class="btn btn-danger w-100">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('modalConfirmDelete', () => {
            return {
                modalEl: document.getElementById('modal-confirm'),
                open(e) {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).show();

                    if (this.modalEl) {
                        this.modalEl.addEventListener('shown.bs.modal', event => {
                            const modalContent = this.modalEl.querySelector('#content');
                            modalContent.textContent = `Hapus: ${e.detail.name}`;
                        });
                    }
                },
                close() {
                    bootstrap.Modal.getOrCreateInstance(this.modalEl).hide();
                },
            }
        })
    </script>
@endscript
