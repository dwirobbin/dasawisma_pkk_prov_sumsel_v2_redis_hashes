<button wire:loading.attr='disabled' class="border-0 bg-transparent d-flex align-items-center" wire:click='toggleLike'>

    <span class="spinner-border spinner-border-sm" wire:loading.delay wire:target='toggleLike' role="status"></span>

    <svg wire:loading.delay.remove wire:target='toggleLike' xmlns="http://www.w3.org/2000/svg"
        class="icon icon-tabler icon-tabler-heart {{ auth()->user()?->hasLikedArticles($model)? 'text-danger': 'text-muted' }}" width="24"
        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
        </path>
    </svg>

    <span class="ms-2 text-muted">
        {{ $model->totalLikedByUsers() }}
    </span>
</button>
