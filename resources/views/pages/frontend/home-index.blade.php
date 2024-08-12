<x-app-layout>
    <x-slot name='styles'>
        <style type="text/css">
            @media (min-width: 320px) {
                img.card-img-top {
                    max-height: 180px;
                }

                img.card-goal {
                    height: 180px;
                }
            }

            @media (min-width: 356px) {
                img.card-img-top {
                    max-height: 200px;
                }

                img.card-goal {
                    width: 750px;
                    height: 200px;
                }
            }

            @media (min-width: 420px) {
                img.card-img-top {
                    max-height: 250px;
                }

                img.card-goal {
                    height: 250px;
                }
            }

            /* sm */
            @media (min-width: 576px) {
                img.card-img-top {
                    max-height: 280px;
                }

                img.card-goal {
                    height: 280px;
                }
            }

            /* md */
            @media (min-width: 768px) {
                img.card-img-top {
                    max-height: 280px;
                }

                img.card-goal {
                    height: 300px;
                }
            }

            /* lg */
            @media (min-width: 992px) {
                img.card-img-top {
                    max-height: 280px;
                }

                img.card-goal {
                    height: 285px;
                }
            }

            /* xl */
            @media (min-width: 1200px) {
                img.card-img-top {
                    max-height: 280px;
                }

                img.card-goal {
                    width: 500px;
                    height: 265px;
                }
            }

            /* xxl */
            @media (min-width: 1400px) {
                img.card-img-top {
                    max-height: 280px;
                }
            }
        </style>
    </x-slot>

    <div class="layout-fluid">
        <div class="page-body">

            <svg class="d-none" xmlns="http://www.w3.org/2000/svg">
                <symbol id="chevron-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                    </path>
                </symbol>
            </svg>

            {{-- Hero --}}
            <div class="container-xl px-3 px-lg-4">
                <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
                    <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                        <h1 class="fw-bold lh-1 text-body-emphasis" style="font-size: calc(1.475rem + 2.7vw);">
                            Revitalisasi Dasawisma Model Seluang
                        </h1>
                        <p class="lead">
                            "Sapa Keluarga Sumsel agar berdaya dan Unggul"
                            <br>
                            dengan memajukan TIM Penggerak - PKK
                            PROVINSI SUMATERA SELATAN.
                        </p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a class="btn btn-primary btn-lg px-4 me-md-2" href="{{ route('area.dashboard') }}">
                                Pergi ke Beranda
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden">
                        <img class="rounded-lg-3" src="{{ asset('src/img/hero/chairman_and_deputy.png') }}" alt="Hero" width="720">
                    </div>
                </div>
            </div>

            {{-- Kegiatan --}}
            <livewire:app.frontend.homes.dasawisma-activity-list />

            {{-- Tujuan --}}
            <div class="container-xl px-3 px-lg-4 mt-4">
                <div class="row featurette px-2 pt-3 pb-3 pb-md-0 pb-lg-0 rounded-3 border shadow-lg">
                    <div class="col-12 col-sm-auto col-md-7 col-lg-7 order-1 order-md-2">
                        <h2 class="featurette-heading fw-bold lh-1">
                            Tujuan Kegiatan Program Dasawisma
                            <span class="text-body-secondary">:</span>
                        </h2>
                        <p class="lead">
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-center px-0">
                            <div class="list-group-flush">
                                <a class="list-group-item list-group-item-action d-flex gap-3 py-2 py-md-3 mx-0" href="#"
                                    aria-current="true">
                                    <img class="rounded-circle flex-shrink-0" src="{{ asset('src/svg/circle-filled.svg') }}" alt="twbs"
                                        width="25" height="25">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <p class="lead fs-3 mb-0 opacity-85">
                                                Untuk mencapai keluarga yang sehat dan mendapat gizi sesuai kebutuhan.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action d-flex gap-3 py-2 py-md-3 mx-0" href="#"
                                    aria-current="true">
                                    <img class="rounded-circle flex-shrink-0" src="{{ asset('src/svg/circle-filled.svg') }}" alt="twbs"
                                        width="25" height="25">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <p class="lead fs-3 mb-0 opacity-85">
                                                Masyarakat ikut
                                                serta dalam kegiatan
                                                yang dilaksanakan.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action d-flex gap-3 py-2 py-md-3 mx-0" href="#"
                                    aria-current="true">
                                    <img class="rounded-circle flex-shrink-0" src="{{ asset('src/svg/circle-filled.svg') }}" alt="twbs"
                                        width="25" height="25">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <p class="lead fs-3 mb-0 opacity-85">
                                                Menjelaskan tentang perilaku yang mendukung perbaikan gizi.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action d-flex gap-3 py-2 pt-md-3 pb-lg-0 mx-0" href="#"
                                    aria-current="true">
                                    <img class="rounded-circle flex-shrink-0" src="{{ asset('src/svg/circle-filled.svg') }}" alt="twbs"
                                        width="25" height="25">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <p class="lead fs-3 mb-0 opacity-85">
                                                Mencakup semua anggota keluarga baik bumil, bayi, balita dan anggota.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        </p>
                    </div>
                    <div class="col-12 col-sm-auto col-md-5 col-lg-5 order-2 order-md-1 mb-lg-3">
                        <img src="{{ asset('src/img/tujuan.jpg') }}" alt="Program Dasawisma" class="bd-placeholder-img card-goal rounded-3">
                    </div>
                </div>
            </div>

            {{-- Berita --}}
            <livewire:app.frontend.homes.sumsel-news-list />
        </div>
    </div>
</x-app-layout>
