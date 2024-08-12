<div class="card shadow-lg">

    <div class="card-header py-2 px-3 d-flex flex-wrap justify-content-center justify-content-sm-between justify-content-md-between gap-2">
        <div class="text-muted">
            <label>
                Tampil
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                </select>
            </label>
        </div>
        <div class="text-muted">
            <div class="input-icon">
                <input type="text" wire:model.live.debounce.300ms='search' class="form-control" placeholder="Cari...">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" wire:loading.remove
                        wire:target='search'>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>

                    <span class="spinner-border spinner-border-sm" wire:loading wire:target='search' role="status"></span>
                </span>
            </div>
        </div>
    </div>

    <div wire:loading.delay class="container">
        <div class="text-center mt-2">
            <span wire:loading role="status" class="spinner-border spinner-border-sm"></span>&ensp;
            <span wire:loading role="status">Memuat..</span>
        </div>
    </div>

    <div wire:loading.class='invisible' class="card-body px-3">
        <div class="row g-3">
            @forelse ($this->users as $user)
                <div class="col-md-4 col-xl-3" wire:key='user-{{ $user->id }}'>
                    <div class="card shadow-sm">
                        <div class="card-body p-4 text-center">
                            <span class="avatar avatar-xl mb-3 rounded" style="background-image: url({{ $user->photo }})"></span>
                            <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                            <div class="text-muted">{{ $user->email }}</div>
                            <div class="mt-3">
                                <span class="badge bg-blue-lt">{{ $user->role->name }}</span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between p-0">
                            @if (auth()->user()->role->id !== 3)
                                <a wire:navigate href="{{ route('area.users.edit', $user->username) }}"
                                    class="d-flex align-items-center justify-content-center mx-auto w-full py-3 bg-warning-lt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                    Edit
                                </a>
                            @endif

                            @if ($user->id != auth()->user()->id && auth()->user()->role->id !== 3)
                                <div class="d-flex align-items-center justify-content-center px-1 bg-secondary-lt text-dark">
                                    <livewire:app.bootstraps.toggle-button :model="$user" field="is_active" :key="'toggle-btn-' . $user->id" />
                                </div>

                                <a x-on:click="$dispatch('delete-confirm', { id: {{ $user->id }}, name: '{{ $user->name }}' })"
                                    class="d-flex align-items-center justify-content-center mx-auto w-full py-3 bg-danger-lt" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                    Hapus
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-important alert-info alert-dismissible d-flex align-items-center mb-0" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle-filled me-2" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z"
                                stroke-width="0" fill="currentColor" />
                        </svg>
                        <div>Data tidak tersedia</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div wire:loading.class='invisible'>
        @if (method_exists($this->users, 'hasPages'))
            @if ($this->users->hasPages())
                <div class="card-footer py-2 d-flex justify-content-center align-items-center">
                    {{ $this->users->links('paginations.custom-simple-pagination-links') }}
                </div>
            @endif
        @endif
    </div>
</div>
