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

        <div class="row">
            <label for="permission" class="form-label required">Permission</label>
            <div class="col-12">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @forelse ($permissionTitles as $title => $permissions)
                        <div class="col">
                            <fieldset class="form-fieldset" style="height: 10.7rem">
                                <div class="form-label">{{ $title }}</div>
                                @foreach ($permissions as $permission)
                                    <div wire:key='permission-{{ $permission->slug }}'>
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" wire:model.live='form.permissions'
                                                value='{{ $permission->slug }}' @checked(in_array($permission->slug, $form->permissions)) @disabled($permission->isSuperAdmin($permissionTitles, $form->role))>
                                            <span class="form-check-label">{{ strtok($permission->name, ' ') }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </fieldset>
                        </div>
                    @empty
                        <div class="col-12 w-full">
                            <div class="alert alert-important alert-info alert-dismissible d-flex align-items-center mb-1" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle-filled me-2"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
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
        </div>
    </div>

    <div class="card-footer">
        <button type="button" wire:click='saveChange' class="btn btn-primary">Simpan Perubahan</button>
    </div>
</div>
