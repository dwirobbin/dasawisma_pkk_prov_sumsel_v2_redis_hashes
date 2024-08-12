<x-app-layout>
    <x-slot name="styles">
        <style>
            /*----------------genealogy-scroll----------*/
            .genealogy-scroll::-webkit-scrollbar {
                width: 5px;
                height: 8px;
            }

            .genealogy-scroll::-webkit-scrollbar-track {
                border-radius: 10px;
                background-color: #e4e4e4;
            }

            .genealogy-scroll::-webkit-scrollbar-thumb {
                background: #212121;
                border-radius: 10px;
                transition: 0.5s;
            }

            .genealogy-scroll::-webkit-scrollbar-thumb:hover {
                background: #d5b14c;
                transition: 0.5s;
            }

            /*----------------genealogy-tree----------*/
            .genealogy-body {
                white-space: nowrap;
                overflow-y: hidden;
                padding: 50px;
                padding-top: 10px;
                display: flex;
                justify-content: left;
            }

            .genealogy-tree ul {
                margin-top: 0px;
                padding-top: 20px;
                position: relative;
                padding-left: 0px;
                display: flex;
                justify-content: center;
            }

            .genealogy-tree li {
                float: left;
                text-align: center;
                list-style-type: none;
                position: relative;
                padding: 20px 5px 0 5px;
            }

            .genealogy-tree li::before,
            .genealogy-tree li::after {
                content: '';
                position: absolute;
                top: 0;
                right: 50%;
                border-top: 2px solid #0080ff;
                width: 50%;
                height: 18px;
            }

            .genealogy-tree li::after {
                right: auto;
                left: 50%;
                border-left: 2px solid #0080ff;
            }

            .genealogy-tree li:only-child::after,
            .genealogy-tree li:only-child::before {
                display: none;
            }

            .genealogy-tree li:only-child {
                padding-top: 0;
            }

            .genealogy-tree li:first-child::before,
            .genealogy-tree li:last-child::after {
                border: 0 none;
            }

            .genealogy-tree li:last-child::before {
                border-right: 2px solid #0080ff;
                border-radius: 0 5px 0 0;
                -webkit-border-radius: 0 5px 0 0;
                -moz-border-radius: 0 5px 0 0;
            }

            .genealogy-tree li:first-child::after {
                border-radius: 5px 0 0 0;
                -webkit-border-radius: 5px 0 0 0;
                -moz-border-radius: 5px 0 0 0;
            }

            .genealogy-tree ul ul::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                border-left: 2px solid #0080ff;
                width: 0;
                height: 20px;
            }

            .genealogy-tree li a {
                text-decoration: none;
                color: #666;
                font-family: arial, verdana, tahoma;
                font-size: 11px;
                display: inline-block;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
            }

            .genealogy-tree li a:hover+ul li::after,
            .genealogy-tree li a:hover+ul li::before,
            .genealogy-tree li a:hover+ul::before,
            .genealogy-tree li a:hover+ul ul::before {
                border-color: #fbba00;
            }

            /*--------------memeber-card-design----------*/
            .member-view-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 5px 5px;
                border-radius: 4px;
                width: 160px;
            }

            .member-image {
                width: 146px;
                position: relative;
            }

            .member-image img {
                width: 146px;
                height: 180px;
                border-radius: 6px;
                background-color: #000;
                z-index: 1;
            }

            .member-details h3 {
                margin-bottom: 0px;
            }

            .member-details h5 {
                margin-bottom: 0px;
                white-space: normal !important;
            }

            @media (max-width: 576px) {
                .org-img {
                    width: 3rem;
                    height: 3rem;
                }
            }
        </style>
    </x-slot>

    <div class="layout-fluid">
        <div class="page-body">
            <div class="container-xl px-3 px-lg-4">
                <div class="row featurette p-3 rounded-3 border shadow-lg">
                    <div class="col-lg-12">
                        <div class="d-flex flex-row justify-content-around border-bottom mb-2 pt-0">
                            <img src="{{ asset('src/img/logo-favicon/prov-sumsel.png') }}" alt="Dasawisma Logo"
                                class="org-img avatar avatar-lg shadow-none" />
                            <div class="card-title mb-0">
                                <h2 class="text-center fw-bolder">SUSUNAN DAN KEANGGOTAAN PENGURUS</h2>
                                <h3 class="text-center fw-bolder">
                                    TIM PENGGERAK PEMBERDAYAAN DAN KESEJAHTERAAN KELUARGA
                                    <br />
                                    PROVINSI SUMATERA SELATAN MASA BHAKTI 2019/2024
                                </h3>
                            </div>
                            <img src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" alt="Dasawisma Logo"
                                class="org-img avatar avatar-lg shadow-none" />
                        </div>

                        <div class="genealogy-body p-0">
                            <div class="genealogy-tree">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box card shadow-sm">
                                                <div class="member-image">
                                                    <img src="{{ asset('src/img/dasawisma-team/herman-deru.png') }}" alt="Member">
                                                </div>
                                                <div class="member-details">
                                                    <h3>Pembina TP PKK</h3>
                                                    <h5>H. Herman Deru</h5>
                                                </div>
                                            </div>
                                        </a>
                                        <ul class="active">
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="member-view-box card shadow-sm">
                                                        <div class="member-image">
                                                            <img src="{{ asset('src/img/dasawisma-team/febrita.png') }}" alt="Member">
                                                        </div>
                                                        <div class="member-details">
                                                            <h3>Ketua TP PKK</h3>
                                                            <h5>Hj. Febrita Lustia</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                                <ul class="active">
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box card shadow-sm">
                                                                <div class="member-image">
                                                                    <img src="{{ asset('src/img/dasawisma-team/yuhilda.png') }}" alt="Member">
                                                                </div>
                                                                <div class="member-details">
                                                                    <h3>Bendahara</h3>
                                                                    <h5>Hj. Yuhilda, SE, MM</h5>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/mushamina.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Bendahara</h3>
                                                                            <h5>Mushamina, S,Ap</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box card shadow-sm">
                                                                <div class="member-image">
                                                                    <img src="{{ asset('src/img/dasawisma-team/fauziah.png') }}" alt="Member">
                                                                </div>
                                                                <div class="member-details">
                                                                    <h3>Wakil Ketua TP PKK</h3>
                                                                    <h5>Hj. Fauziah</h5>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active justify-content-center">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/ekowati.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Ketua II</h3>
                                                                            <h5>Hj. Dr. Ekowati, SKM, M. Kes</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="active d-flex justify-content-center">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/fien-poerwadi.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Ketua III</h3>
                                                                            <h5>Hj. Fien Poerwadi</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="active justify-content-center">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/sahilul-hulwan.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Ketua IV</h3>
                                                                            <h5>Dr. Hj. Sahilul Hulwan Mochtar</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/telly.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Ketua Pokja I</h3>
                                                                            <h5>DR. Dra. Hj. Telly P. Ulvina Siwi,
                                                                                M.Si, Psi</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box card shadow-sm">
                                                                                <div class="member-image">
                                                                                    <img src="{{ asset('src/img/dasawisma-team/zasfaimasuri.png') }}"
                                                                                        alt="Member">
                                                                                </div>
                                                                                <div class="member-details">
                                                                                    <h3>Sekretaris Pokja I</h3>
                                                                                    <h5>Hj. Zasfamaisuri</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        <ul class="active">
                                                                            <li>
                                                                                <a href="javascript:void(0);">
                                                                                    <div class="member-view-box card shadow-sm">
                                                                                        <div class="member-image">
                                                                                            <img src="{{ asset('src/img/dasawisma-team/cynthia.png') }}"
                                                                                                alt="Member">
                                                                                        </div>
                                                                                        <div class="member-details">
                                                                                            <h3>Anggota Pokja I</h3>
                                                                                            <h5>Dra. Cynthia N. Faisal</h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/dedeh.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Ketua Pokja II</h3>
                                                                            <h5>Hj. Dedeh Daswillah Ade, S.Pd</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box card shadow-sm">
                                                                                <div class="member-image">
                                                                                    <img src="{{ asset('src/img/dasawisma-team/nurmalia.png') }}"
                                                                                        alt="Member">
                                                                                </div>
                                                                                <div class="member-details">
                                                                                    <h3>Sekretaris Pokja II</h3>
                                                                                    <h5>Hj. Nurmalia, S H</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/shinta.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Ketua Pokja III</h3>
                                                                            <h5>Dra. Shinta Irasnawati</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box card shadow-sm">
                                                                                <div class="member-image">
                                                                                    <img src="{{ asset('src/img/dasawisma-team/ema.png') }}"
                                                                                        alt="Member">
                                                                                </div>
                                                                                <div class="member-details">
                                                                                    <h3>Sekretaris Pokja III</h3>
                                                                                    <h5>Ema Deruliah, SP</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/erly.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Ketua Pokja IV</h3>
                                                                            <h5>Dr. Hj. Erly Yarli, M.Kes</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <ul class="active">
                                                                    <li>
                                                                        <a href="javascript:void(0);">
                                                                            <div class="member-view-box card shadow-sm">
                                                                                <div class="member-image">
                                                                                    <img src="{{ asset('src/img/dasawisma-team/yusniwati.png') }}"
                                                                                        alt="Member">
                                                                                </div>
                                                                                <div class="member-details">
                                                                                    <h3>Sekretaris Pokja IV</h3>
                                                                                    <h5>Hj. Yusniwati Thohir</h5>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box card shadow-sm">
                                                                <div class="member-image">
                                                                    <img src="{{ asset('src/img/dasawisma-team/endang-pratiwi.png') }}"
                                                                        alt="Member">
                                                                </div>
                                                                <div class="member-details">
                                                                    <h3>Sekretaris</h3>
                                                                    <h5>Ir. Hj. Endang Pratiwi</h5>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/aminah.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Sekretaris 1</h3>
                                                                            <h5>Hj. Aminah, SE, MM</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <div class="member-view-box card shadow-sm">
                                                                        <div class="member-image">
                                                                            <img src="{{ asset('src/img/dasawisma-team/hartati-hikmainni.png') }}"
                                                                                alt="Member">
                                                                        </div>
                                                                        <div class="member-details">
                                                                            <h3>Wakil Sekretaris 2</h3>
                                                                            <h5>Hartati Hikmairuni, S. Sos</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                $('.genealogy-tree ul').hide();
                $('.genealogy-tree>ul').show();
                $('.genealogy-tree ul.active').show();
                $('.genealogy-tree li').on('click', function(e) {
                    var children = $(this).find('> ul');
                    if (children.is(":visible")) children.hide('fast').removeClass('active');
                    else children.show('fast').addClass('active');
                    e.stopPropagation();
                });
            });
        </script>
    </x-slot>
</x-app-layout>
