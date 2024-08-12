<div>
    <section class="mb-3" id="comment-box">
        <h2>Komentar ({{ $dasawismaActivity->totalCommentedByUsers() }})</h2>

        @if (session()->has('message'))
            <div id="msg-save" class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible d-flex" role="alert">
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
                <span class="ms-2">{{ session('message')['text'] }}</span>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="card rounded-3 bg-gray-400">
            <div class="card-body p-2">
                <!-- first level comment -->
                @forelse ($this->comments as $comment)
                    <div class="d-flex flex-start" id="comment-{{ $comment->id }}">
                        <img class="rounded-circle shadow-1-strong me-2" src="{{ asset($comment->user->photo) }}"
                            alt="profile-{{ $comment->user->username }}" width="45" height="45" />
                        <div class="flex-grow-1 flex-shrink-1">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fw-bold text-primary mb-1">
                                        {{ $comment->user->name }} <small class="text-muted">-
                                            {{ $comment->created_at->translatedFormat('l, d M Y, H:i') }}</small>
                                    </h4>
                                </div>
                                <p class="mb-2">{{ $comment->body }}</p>

                                <div x-data="{
                                    show: false,
                                    deleteConfirm(id, text) {
                                        const confirmModal = document.getElementById('confirm-delete');
                                        const btnDelete = document.getElementById('btn-delete');
                                
                                        btnDelete.dataset.id = id;
                                
                                        bootstrap.Modal.getOrCreateInstance(confirmModal).show();
                                
                                        if (confirmModal) {
                                            confirmModal.addEventListener('shown.bs.modal', event => {
                                
                                                // Update the modal's content.
                                                let modalContent = confirmModal.querySelector('#content');
                                                modalContent.textContent = `Hapus: ${text}`;
                                            })
                                        }
                                    },
                                }">
                                    <div class="small d-flex justify-content-start flex-wrap gap-2">
                                        @auth
                                            <a wire:key="'like-comment-'{{ $comment->id }}" wire:click='toggleLike({{ $comment->id }})'
                                                wire:loading.attr='disabled' class="d-flex align-items-center me-3" role='button'>
                                                <span class="spinner-border spinner-border-sm" wire:loading.delay
                                                    wire:target='toggleLike({{ $comment->id }})' role="status">
                                                </span>
                                                <svg wire:loading.delay.remove wire:target='toggleLike({{ $comment->id }})'
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-heart {{ in_array(auth()->id(), $comment->likeCommentDasawismaActivities->pluck('user_id')->toArray()) ? 'text-danger' : 'text-muted' }}"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                    </path>
                                                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                                    </path>
                                                </svg>
                                                <p class="ms-1 mb-0">{{ $comment->totalLikedCommentByUsers() }}</p>
                                            </a>
                                            <a wire:click='replyComment({{ $comment->id }})' x-on:click="show = !show"
                                                class="d-flex align-items-center me-3" role='button'>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-dots"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                    </path>
                                                    <path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4">
                                                    </path>
                                                    <path d="M12 11l0 .01"></path>
                                                    <path d="M8 11l0 .01"></path>
                                                    <path d="M16 11l0 .01"></path>
                                                </svg>
                                                <p class="ms-1 mb-0">Balas</p>
                                            </a>
                                            @if ($comment->user_id === auth()->id())
                                                <a wire:click='editComment({{ $comment->id }})' x-on:click="show = !show"
                                                    class="d-flex align-items-center me-3" role='button'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                    <p class="ms-1 mb-0">Edit</p>
                                                </a>
                                                <a x-on:click="deleteConfirm({{ $comment->id }}, '{{ $comment->body }}')"
                                                    class="d-flex align-items-center me-3" role='button'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                    <p class="ms-1 mb-0">Hapus</p>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>

                                    @if (isset($userComment->id) && $userComment?->id === $comment->id)
                                        <div wire:key='comment-{{ $comment->id }}-edit' class="mt-3" x-show="show" x-transition>
                                            <h4 class="fw-bold mb-2">{{ !empty($bodyCommentEditOrReply) ? 'Edit' : 'Balas' }} Komentar</h4>
                                            <div class="form-outline">
                                                <textarea wire:model='bodyCommentEditOrReply'
                                                    class="form-control {{ $errors->has('bodyCommentEditOrReply') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                                    rows="5" placeholder="Komentar..."></textarea>
                                                @error('bodyCommentEditOrReply')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="d-flex justify-content-between mt-3">
                                                <button type="button" x-on:click="show = !show" wire:click='clear' class="btn btn-danger">
                                                    Batal
                                                </button>
                                                @if (!empty($bodyCommentEditOrReply))
                                                    <button type="button" wire:click='saveChangeCommentOrReply' class="btn btn-primary">
                                                        Simpan Perubahan
                                                    </button>
                                                @else
                                                    <button type="button" wire:click='saveReply' class="btn btn-primary">
                                                        Kirim
                                                    </button>
                                                @endif
                                            </div>
                                            @if (!$loop->last)
                                                <hr class="mt-3 mb-2" />
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- second level comment -->
                            @if ($comment->childrens)
                                @foreach ($comment->childrens as $firstLvlReply)
                                    <div class="d-flex flex-start" id="first-lvl-reply-{{ $firstLvlReply->id }}">
                                        <img class="rounded-circle shadow-1-strong me-2" src="{{ asset($firstLvlReply->user->photo) }}"
                                            alt="profile-{{ $firstLvlReply->user->username }}" width="45" height="45" />
                                        <div class="flex-grow-1 flex-shrink-1">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="fw-bold text-primary mb-1">
                                                        {{ $firstLvlReply->user->name }}
                                                        <small class="text-muted">
                                                            - {{ $firstLvlReply->created_at->translatedFormat('l, d M Y, H:i') }}
                                                        </small>
                                                    </h4>
                                                </div>
                                                <p class="mb-2">{{ $firstLvlReply->body }}</p>

                                                <div x-data="{
                                                    show: false,
                                                    deleteConfirm(id, text) {
                                                        const confirmModal = document.getElementById('confirm-delete');
                                                        const btnDelete = document.getElementById('btn-delete');
                                                
                                                        btnDelete.dataset.id = id;
                                                
                                                        bootstrap.Modal.getOrCreateInstance(confirmModal).show();
                                                
                                                        if (confirmModal) {
                                                            confirmModal.addEventListener('shown.bs.modal', event => {
                                                
                                                                // Update the modal's content.
                                                                let modalContent = confirmModal.querySelector('#content');
                                                                modalContent.textContent = `Hapus: ${text}`;
                                                            })
                                                        }
                                                    },
                                                }">
                                                    <div class="small d-flex justify-content-start flex-wrap gap-2">
                                                        @auth
                                                            <a wire:key="'like-reply-'{{ $firstLvlReply->id }}"
                                                                wire:click='toggleLike({{ $firstLvlReply->id }})' wire:loading.attr='disabled'
                                                                class="d-flex align-items-center me-3" role='button'>
                                                                <span class="spinner-border spinner-border-sm" wire:loading.delay
                                                                    wire:target='toggleLike({{ $firstLvlReply->id }})' role="status">
                                                                </span>
                                                                <svg wire:loading.delay.remove wire:target='toggleLike({{ $firstLvlReply->id }})'
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-heart {{ in_array(auth()->id(), $firstLvlReply->likeCommentDasawismaActivities->pluck('user_id')->toArray()) ? 'text-danger' : 'text-muted' }}"
                                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path
                                                                        d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                                                    </path>
                                                                </svg>
                                                                <p class="ms-1 mb-0">{{ $firstLvlReply->totalLikedCommentByUsers() }}</p>
                                                            </a>
                                                            @if ($firstLvlReply->user_id === auth()->id())
                                                                <a wire:click='editComment({{ $firstLvlReply->id }})' x-on:click="show = !show"
                                                                    class="d-flex align-items-center me-3" role='button'>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                    <p class="ms-1 mb-0">Edit</p>
                                                                </a>
                                                                <a x-on:click="deleteConfirm({{ $firstLvlReply->id }}, '{{ $firstLvlReply->body }}')"
                                                                    class="d-flex align-items-center me-3" role='button'>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M4 7l16 0" />
                                                                        <path d="M10 11l0 6" />
                                                                        <path d="M14 11l0 6" />
                                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                    </svg>
                                                                    <p class="ms-1 mb-0">Hapus</p>
                                                                </a>
                                                            @endif
                                                        @endauth
                                                    </div>

                                                    @if (isset($userComment->id) && $userComment?->id === $firstLvlReply->id)
                                                        <div wire:key='reply-{{ $firstLvlReply->id }}-edit' class="mt-3" x-show="show"
                                                            x-transition>
                                                            <h4 class="fw-bold mb-2">
                                                                {{ !empty($bodyCommentEditOrReply) ? 'Edit' : 'Balas' }} Balasan
                                                            </h4>
                                                            <div class="form-outline">
                                                                <textarea wire:model='bodyCommentEditOrReply'
                                                                    class="form-control {{ $errors->has('bodyCommentEditOrReply') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                                                    rows="5" placeholder="Komentar Balasan...">
                                                                </textarea>
                                                                @error('bodyCommentEditOrReply')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-3">
                                                                <button type="button" x-on:click="show = !show" wire:click='clear'
                                                                    class="btn btn-danger">
                                                                    Batal
                                                                </button>
                                                                @if (!empty($bodyCommentEditOrReply))
                                                                    <button type="button" wire:click='saveChangeCommentOrReply'
                                                                        class="btn btn-primary">
                                                                        Simpan Perubahan
                                                                    </button>
                                                                @else
                                                                    <button type="button" wire:click='saveReply' class="btn btn-primary">
                                                                        Kirim
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            @if (!$loop->last)
                                                                <hr class="mt-3 mb-2" />
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <hr class="mt-0 mb-3" />
                @empty
                    <div class="w-100 alert alert-important alert-info alert-dismissible d-flex align-items-center mb-3" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle-filled me-2" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z"
                                stroke-width="0" fill="currentColor" />
                        </svg>
                        <p>Belum ada yang berkomentar!!</p>
                    </div>
                @endforelse

                <div class="d-flex flex-start w-100">
                    @auth
                        <img class="rounded-circle shadow-1-strong me-2" src="{{ asset(auth()->user()->photo) }}" alt="avatar" width="40"
                            height="40" />
                        <div class="w-100">
                            <h4 class="fw-bold">Tambah Komentar Baru</h4>
                            <div class="form-outline">
                                <textarea wire:model='bodyComment'
                                    class="form-control {{ $errors->has('bodyComment') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}" rows="5"
                                    placeholder="Komentar..."></textarea>
                                @error('bodyComment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" wire:click='clear' class="btn btn-danger">Reset</button>
                                <button type="button" wire:click='saveComment' class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    @else
                        <div class="w-100 alert alert-important alert-info alert-dismissible d-flex align-items-center mb-0" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle-filled me-2" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z"
                                    stroke-width="0" fill="currentColor" />
                            </svg>
                            <a wire:click='goToLogin' class="text-white" role='button'>
                                Ingin Berkomentar? Silahkan Masuk terlebih dahulu
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <div class="modal modal-blur fade" id="confirm-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <h3>Apakah anda yakin?</h3>
                    <div class="text-muted" id='content'></div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn w-100" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                            <div class="col">
                                <button type="button" id="btn-delete" x-data="{
                                    dataId: 0,
                                    deleteData(e) {
                                        this.dataId = e.currentTarget.dataset.id;
                                        $wire.dispatch('delete', { id: this.dataId })
                                    }
                                }" x-on:click="deleteData($event)"
                                    class="btn btn-danger w-100" data-id data-bs-dismiss="modal">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('remove-alert', () => {
            setTimeout(() => {
                document.getElementById('msg-save').remove();
            }, 5000);
        })

        $wire.on('success-comment', (data) => {
            let el;

            if (document.getElementById('comment-' + data.commentId)) {
                el = document.getElementById('comment-' + data.commentId);
            } else if (document.getElementById('first-lvl-reply-' + data.commentId)) {
                el = document.getElementById('first-lvl-reply-' + data.commentId);
            } else {
                el = document.getElementById('comment-box');
            }

            el.scrollIntoView({
                behavior: 'smooth'
            }, true);
        })
    </script>
@endscript
