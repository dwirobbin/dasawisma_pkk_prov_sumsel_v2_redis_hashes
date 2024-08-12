<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center justify-content-center justify-content-md-between">
                <div class="col-12 col-sm-10 col-md-8 col-xl-9 d-flex justify-content-center justify-content-md-start">
                    <h2 class="page-title d-block text-center">
                        Artikel Berita Sumsel

                        @if ($author)
                            by {{ ucfirst($author) }}
                        @endif
                    </h2>

                    @if ($author)
                        <button type="button" wire:click='clearFilters' class="btn btn-red btn-icon ms-2" style="min-height: 0; min-width: 1.8rem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
                <div class="col-12 col-sm-10 col-md-4 col-xl-3">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                        <input type="text" wire:model.live='search' class="form-control" placeholder="Cari…">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <svg class="d-none" xmlns="http://www.w3.org/2000/svg">
            <symbol id="chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                </path>
            </symbol>
        </svg>

        <div class="container-xl">
            <div class="card shadow-lg">
                <div class="card-header py-2 d-flex flex-wrap justify-content-center justify-content-sm-between justify-content-md-between">
                    <div class="text-muted my-1 my-lg-0">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <button class="nav-link {{ $sortDirection === 'desc' ? 'active' : '' }}" wire:click="setSort('desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon nav-link-icon icon-tabler icon-tabler-sort-ascending"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 6l7 0"></path>
                                        <path d="M4 12l7 0"></path>
                                        <path d="M4 18l9 0"></path>
                                        <path d="M15 9l3 -3l3 3"></path>
                                        <path d="M18 6l0 12"></path>
                                    </svg>
                                    Latest
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link {{ $sortDirection === 'asc' ? 'active' : '' }}" wire:click="setSort('asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon nav-link-icon icon-tabler icon-tabler-sort-descending"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 6l9 0"></path>
                                        <path d="M4 12l7 0"></path>
                                        <path d="M4 18l7 0"></path>
                                        <path d="M15 15l3 3l3 -3"></path>
                                        <path d="M18 6l0 12"></path>
                                    </svg>
                                    Oldest
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="text-muted my-1 my-lg-0">
                        <label>
                            Tampil
                            <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                                <option value="3">3</option>
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="45">45</option>
                                <option value="69">69</option>
                                <option value="87">87</option>
                                @if (count($this->sumselNews))
                                    <option value="{{ $this->sumselNews->total() }}">Semua</option>
                                @endif
                            </select>
                        </label>
                    </div>
                </div>
                <div class="card-body px-3">
                    <div class="row g-3">
                        @forelse ($this->sumselNews as $sumselNews)
                            <div class="col-12 col-md-6 col-lg-4" wire:key='{{ $sumselNews->id }}'>
                                <div class="card shadow-sm">
                                    <img src="{{ asset($sumselNews->image) }}" alt="Berita {{ $sumselNews->slug }}"
                                        class="bd-placeholder-img card-img-top object-fit-cover">
                                    <div class="card-body p-3">
                                        <h3 class="fs-2 text-body-emphasis mb-1">{{ $sumselNews->title }}</h3>
                                        <p class="blog-post-meta text-secondary">
                                            {{ $sumselNews->created_at->format('d M Y') }}, by
                                            <a wire:navigate href="{{ url('sumsel-news?author=' . $sumselNews->username) }}">
                                                {{ $sumselNews->author }}
                                            </a>
                                        </p>

                                        <p class="card-text">{{ Str::words(strip_tags($sumselNews->body), 7, '...') }}</p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <a wire:navigate href="{{ route('sumsel_news.show', $sumselNews->slug) }}" class="icon-link">
                                                Selengkapnya
                                                <svg class="bi">
                                                    <use xlink:href="#chevron-right"></use>
                                                </svg>
                                            </a>
                                            @livewire('app.bootstraps.like-button', ['model' => $sumselNews], key($sumselNews->id))
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <div class="alert alert-important alert-info alert-dismissible d-flex align-items-center mb-0" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle-filled me-2"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
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

                @if (method_exists($this->sumselNews, 'hasPages'))
                    @if ($this->sumselNews->hasPages())
                        <div class="card-footer pt-1 pb-2 px-3">
                            {{ $this->sumselNews->links() }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
