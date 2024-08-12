<x-app-layout>
    <x-slot name="styles">
        <link href="{{ asset('src/css/carousel.css') }}" rel="stylesheet">
    </x-slot>

    <div class="layout-fluid">
        <div class="page-body">
            <div class="container-xl px-3 px-lg-4">
                <div class="row featurette p-4 rounded-3 border shadow-lg">
                    <div class="col-md-7 order-md-1">
                        <h2 class="featurette-heading fw-bold lh-1">
                            Tentang Kami
                        </h2>
                        <p class="lead fs-3 mb-0 opacity-85">
                            Dasawisma PKK adalah kelompok ibu yang berasal dari 10 kepala keluarga (KK) rumah yang bertetangga untuk
                            mempermudah jalannya suatu program.
                            Sedangkan, kelompok dasawisma PKK adalah kelompok yang terdiri dari 10 hingga 20 kepala keluarga (KK) dalam
                            satu RT. Setelah terbentuk kelompok,
                            nantinya salah satu orang akan ditunjuk sebagai ketua. Tujuan Dasawisma PKK adalah membantu kelancaran
                            tugas-tugas pokok dan program PKK kelurahan.
                        </p>
                    </div>
                    <div class="col-md-5 order-md-2">
                        <img src="{{ asset('src/img/hero/banner_pkk.jpeg') }}" alt="Banner Dasawisma PKK Prov. Sumsel"
                            class="bd-placeholder-img card-img-top rounded-3">
                    </div>
                </div>

                <div class="row featurette p-4 mt-5 rounded-3 border shadow-lg">
                    <div class="col-lg-12">
                        <div class="justify-content-center border-bottom mb-2 pt-0">
                            <h2 class="text-center">Team</h2>
                        </div>
                        <div class="row my-auto justify-content-center">
                            <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar avatar-xl"
                                                                style="background-image: url('{{ asset('src/img/dasawisma-team/febrita.png') }}')">
                                                            </span>
                                                        </div>
                                                        <div class="col-auto pt-0">
                                                            <h4 class="card-title m-0 ps-0">
                                                                Hj. Febrita Lustia
                                                            </h4>
                                                            <div class="text-muted">
                                                                Ketua TP PKK
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar avatar-xl"
                                                                style="background-image: url('{{ asset('src/img/dasawisma-team/fauziah.png') }}')">
                                                            </span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <h4 class="card-title m-0">
                                                                Hj. Fauziah
                                                            </h4>
                                                            <div class="text-muted">
                                                                Wakil Ketua TP PKK
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar avatar-xl"
                                                                style="background-image: url('{{ asset('src/img/dasawisma-team/endang-pratiwi.png') }}')">
                                                            </span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <h4 class="card-title m-0">
                                                                Ir. Hj. Endang Pratiwi
                                                            </h4>
                                                            <div class="text-muted">
                                                                Sekretaris
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar avatar-xl"
                                                                style="background-image: url('{{ asset('src/img/dasawisma-team/yuhilda.png') }}')">
                                                            </span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <h4 class="card-title m-0">
                                                                Hj. Yuhida, SE, MM
                                                            </h4>
                                                            <div class="text-muted">
                                                                Bendahara
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#recipeCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#recipeCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            let items = document.querySelectorAll(".carousel .carousel-item");

            items.forEach((el) => {
                const minPerSlide = 4;
                let next = el.nextElementSibling;
                for (var i = 1; i < minPerSlide; i++) {
                    if (!next) {
                        // wrap carousel by using first child
                        next = items[0];
                    }
                    let cloneChild = next.cloneNode(true);
                    el.appendChild(cloneChild.children[0]);
                    next = next.nextElementSibling;
                }
            });
        </script>
    </x-slot>
</x-app-layout>
