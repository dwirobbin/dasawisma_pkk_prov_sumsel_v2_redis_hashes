<div class="container-xl px-3 px-lg-4 mt-4">
    <div class="row px-2 pt-3 pb-0 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap w-100 align-items-start justify-content-between border-bottom mb-2 pt-0">
                <h2 class>Kegiatan Dasawisma</h2>
                <a class="icon-link py-1" wire:navigate href="{{ route('dasawisma_activity.index') }}">
                    Lihat Semua
                    <svg class="bi">
                        <use xlink:href="#chevron-right"></use>
                    </svg>
                </a>
            </div>
            <div class="row g-3 pb-3">
                @if (isset($this->dasawismaActivities) && count($this->dasawismaActivities))
                    @foreach ($this->dasawismaActivities as $dasawismaActivity)
                        <div class="col-12 col-md-6 col-lg-4" wire:key='{{ $dasawismaActivity->id }}'>
                            <div class="card shadow-sm">
                                <img src="{{ asset($dasawismaActivity->image) }}" alt="Kegiatan {{ $dasawismaActivity->slug }}"
                                    class="bd-placeholder-img card-img-top card-img-list object-fit-cover">
                                <div class="card-body p-3">
                                    <h3 class="fs-2 text-body-emphasis mb-1">
                                        {{ $dasawismaActivity->title }}
                                    </h3>
                                    <p class="blog-post-meta text-secondary">
                                        {{ $dasawismaActivity->created_at->format('d M Y') }}, by
                                        <a wire:navigate
                                            href="{{ route('dasawisma_activity.index', ['author' => $dasawismaActivity->username]) }}">
                                            {{ $dasawismaActivity->author }}
                                        </a>
                                    </p>
                                    <p class="card-text">{{ Str::words(strip_tags($dasawismaActivity->body), 12, '...') }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a class="icon-link" wire:navigate
                                            href="{{ route('dasawisma_activity.show', $dasawismaActivity->slug) }}">
                                            Selengkapnya
                                            <svg class="bi">
                                                <use xlink:href="#chevron-right"></use>
                                            </svg>
                                        </a>
                                        @livewire('app.bootstraps.like-button', ['model' => $dasawismaActivity], key($dasawismaActivity->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
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
                @endif
            </div>
        </div>
    </div>
</div>
