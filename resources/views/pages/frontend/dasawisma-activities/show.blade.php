<x-app-layout>
    <div class="layout-fluid">
        <div class="page-body">
            <main class="container">
                <div class="card rounded-3 border shadow-lg">
                    <div class="card-body row p-3">

                        <div class="col-md-8">
                            <img src="{{ asset($dasawismaActivity->image) }}" alt="Kegiatan {{ $dasawismaActivity->title }}"
                                class="bd-placeholder-img card-img-top card-img-detail rounded-3 object-fit-cover">
                            <div class="row g-5 pt-3">
                                <div class="col-md-12">
                                    <article class="blog-post">
                                        <h2 class="display-6 fw-bolder mb-1">
                                            {{ $dasawismaActivity->title }}
                                        </h2>
                                        <p class="blog-post-meta">
                                            {{ $dasawismaActivity->created_at->format('d M Y') }}, by
                                            <a wire:navigate
                                                href="{{ route('dasawisma_activity.index', ['author' => $dasawismaActivity->author->username]) }}">
                                                {{ $dasawismaActivity->author->name }}
                                            </a>
                                        </p>

                                        <p class="fs-4 mb-4">
                                            {{ strip_tags($dasawismaActivity->body) }}
                                        </p>
                                    </article>

                                    <livewire:app.frontend.dasawisma-activities.comment :$dasawismaActivity :key="'comments-' . $dasawismaActivity->id" />
                                </div>
                            </div>
                        </div>

                        <svg class="d-none" xmlns="http://www.w3.org/2000/svg">
                            <symbol id="chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                                </path>
                            </symbol>
                        </svg>

                        <div class="col-md-4">
                            <div class="position-sticky" style="top: 2rem;">
                                <div>
                                    <div class="d-flex flex-wrap w-100 align-items-start justify-content-between pt-0">
                                        <h3 class="fst-normal">Berita Lainnya</h3>
                                        <a class="icon-link" wire:navigate href="{{ route('dasawisma_activity.index') }}">
                                            Lihat Semua
                                            <svg class="bi">
                                                <use xlink:href="#chevron-right"></use>
                                            </svg>
                                        </a>
                                    </div>
                                    <ul class="list-unstyled">
                                        @forelse ($moreArticles as $moreArticle)
                                            <li>
                                                <a class="d-flex flex-sm-row flex-wrap flex-lg-nowrap gap-2 align-items-start py-3 link-body-emphasis text-decoration-none border-top"
                                                    wire:navigate href="{{ route('dasawisma_activity.show', $moreArticle->slug) }}">
                                                    <img src="{{ asset($moreArticle->image) }}" alt="Kegiatan {{ $moreArticle->title }}"
                                                        class="bd-placeholder-img rounded-2 object-fit-cover" width="150" height="96">
                                                    <div class="col-md-12 col-lg-8">
                                                        <h4 class="mb-0">
                                                            {{ Str::words($moreArticle->title, 17, '...') }}
                                                        </h4>
                                                        <small class="text-body-secondary">
                                                            {{ $moreArticle->created_at->format('d M Y') }},
                                                        </small>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                            <li>
                                                <div class="alert alert-important alert-info alert-dismissible d-flex align-items-center mb-0"
                                                    role="alert">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-info-circle-filled me-2" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z"
                                                            stroke-width="0" fill="currentColor" />
                                                    </svg>
                                                    <div>Data tidak tersedia</div>
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div class="p-0">
                                    <h4><span class="fst-italic">Author</span> Lainnya</h4>
                                    <ol class="list-unstyled">
                                        @forelse ($moreAuthors as $moreAuthor)
                                            <li>
                                                <a wire:navigate href="{{ route('sumsel_news.index', ['author' => $moreAuthor->username]) }}">
                                                    {{ $moreAuthor->name }}
                                                </a>
                                            </li>
                                        @empty
                                            <li>
                                                <div class="alert alert-important alert-info alert-dismissible d-flex align-items-center mb-0"
                                                    role="alert">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-info-circle-filled me-2" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z"
                                                            stroke-width="0" fill="currentColor" />
                                                    </svg>
                                                    <div>Data tidak tersedia</div>
                                                </div>
                                            </li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
