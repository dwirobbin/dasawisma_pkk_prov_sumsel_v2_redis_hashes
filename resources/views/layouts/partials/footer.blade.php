<footer class="layout-fluid">
    @if (request()->routeIs('auth.*') || request()->routeIs('area.*') || request()->is('auth/*'))
        <div class="container border-top">
            <div class="row text-center align-items-center justify-content-center">
                <div class="col-12 my-3">
                    <p class="text-center text-body-secondary">
                        Copyright &copy; 2024
                        <a class="link-secondary" href="."> {{ config('app.name') }}</a>.
                        All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="container shadow-lg">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-4">
                <div class="col-auto col-md-4 col-lg-4 col-xl-5 order-md-2 ps-xl-7">
                    <h3 class="featurette-heading fw-bold lh-1">
                        Kontak Kami
                    </h3>
                    <p class="lead">
                    <div class="d-flex flex-column flex-md-row gap-4 align-items-center px-0">
                        <div class="list-group-flush">
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-map-pin-share" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    <path d="M12.02 21.485a1.996 1.996 0 0 1 -1.433 -.585l-4.244 -4.243a8 8 0 1 1 13.403 -3.651"></path>
                                    <path d="M16 22l5 -5"></path>
                                    <path d="M21 21.5v-4.5h-4.5"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            Sekretariat : Jalan. Ade Irma Nasution Palembang
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-phone-call" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                    </path>

                                    <path d="M15 7a2 2 0 0 1 2 2"></path>
                                    <path d="M15 3a6 6 0 0 1 6 6"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            Telp. : 0711-371504
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-brand-x" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            @dasawismaprovsumsel
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-brand-instagram" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M16.5 7.5l0 .01"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            dasawismaprovsumsel
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="col-auto col-md-auto col-lg-2 col-xl-3 order-md-3 ps-xl-6">
                    <h3 class="featurette-heading fw-bold lh-1">
                        Link Terkait
                    </h3>
                    <p class="lead">
                    <div class="d-flex flex-column flex-md-row gap-4 align-items-center px-0">
                        <div class="list-group-flush">
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-link" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 15l6 -6"></path>
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            Pemprov. Sumsel
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-link" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 15l6 -6"></path>
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            Kominfo Sumsel
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-link" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 15l6 -6"></path>
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            TP PKK Sumsel
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
                                <svg class="icon icon-tabler icon-tabler-link" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 15l6 -6"></path>
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                </svg>
                                <div class="d-flex gap-2 w-100 justify-content-between">
                                    <div>
                                        <p class="lead fs-4 mb-0 opacity-85">
                                            Beranda
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="col col-md-8 col-lg-6 col-xl-4 order-md-1">
                    <h3 class="featurette-heading fw-bold lh-1">
                        Maps
                    </h3>
                    <div class="map-responsive">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.4412544065904!2d104.72959827416233!3d-2.9749696398019294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75c1077fc533%3A0x44f9a9da443d67ba!2sBadan%20Penelitian%20dan%20Pengembangan%20Daerah%20Provinsi%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1698379618967!5m2!1sid!2sid"
                            style="border:0;" width="600" height="450" allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="row text-center align-items-center justify-content-center border-top">
                <div class="col-12 my-3">
                    <p class="text-center text-body-secondary">
                        Copyright &copy; {{ Carbon\Carbon::now()->year }}
                        <a class="link-secondary" href="."> {{ config('app.name') }}</a>.
                        All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    @endif
</footer>
