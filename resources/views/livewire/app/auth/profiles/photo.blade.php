<div class="row align-items-center" x-data="{
    photo: $wire.photo,
    fileChosen(event) {
        const file = event.target.files[0];

        if (!file || file.type.indexOf('image/') === -1) return;
        if (file.size > 2 * 1024 * 1024) return;

        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = e => {
            this.photo = e.target.result;
        }
    },
}">
    <div class="col-auto">
        <template x-if="photo">
            <img class="avatar avatar-md object-cover" x-bind:src="photo">
        </template>
    </div>
    <div class="col">
        <h2 class="page-title">{{ $user->name }}</h2>
        <div class="page-subtitle">
            <div class="row">
                <div class="col-auto">
                    <span class="text-reset text-decoration-none">
                        {{ $user->username }} | {{ $user->email }} | {{ $user->role->name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @can(['update-profile'])
        <div class="col-auto">
            <input type="file" wire:model='photo' x-ref="image" x-on:change="fileChosen($event)" class="d-none"
                accept="image/png,image/jpg,image/jpeg,image/svg,image/gif">
            <button type="button" x-on:click="$refs.image.click()" class="btn btn-primary">
                Ubah Foto Profil
            </button>
        </div>
        @error('photo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    @endcan
</div>
