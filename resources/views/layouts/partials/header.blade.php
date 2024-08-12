<div class="sticky-top layout-fluid">
    <header class="navbar navbar-expand-md sticky-top d-print-none">
        <div class="container-xl px-0 px-lg-3 d-flex">
            <!-- top left -->
            <div class="d-flex align-items-center">
                <button class="navbar-toggler ms-1" type="button" data-bs-target="#navbar-menu" data-bs-toggle="collapse"
                    aria-controls="navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3 ms-2 ms-lg-0">
                    <a wire:navigate href="{{ str_contains(request()->fullUrl(), '/area') ? route('area.dashboard') : route('home') }}"
                        class="text-decoration-none d-flex gap-1">
                        <img class="navbar-brand-image" src="{{ asset('src/img/logo-favicon/prov-sumsel.png') }}" alt="Prov. Sumsel Logo">
                        <img class="navbar-brand-image" src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" alt="Dasawisma Logo">
                    </a>
                    <span class="d-none d-lg-flex align-items-lg-center">
                        {{ config('app.name') }}
                    </span>
                </h1>
            </div>

            <!-- top right -->
            <livewire:app.partials.top-right />

            <!-- navigation -->
            <div id="navbar-menu" class="collapse navbar-collapse">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        @if (request()->routeIs('area.*') || request()->routeIs('auth.profile'))
                            @can('show-dashboard')
                                <li class="nav-item @if (request()->routeIs('area.dashboard')) active @endif">
                                    <a class="nav-link" wire:navigate href="{{ route('area.dashboard') }}">
                                        <span class="nav-link-title">Beranda</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item @if (request()->routeIs('area.data-input.*')) active @endif dropdown" x-data="{ open: false }"
                                x-on:click.outside="open = false">
                                <a class="nav-link dropdown-toggle" x-on:click="open = !open" :class="{ 'show': open == true }" role="button">
                                    <span class="nav-link-title">Input Data</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                                    :data-bs-popper="{ 'static': open == true }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @can('show-dasawisma')
                                                <a wire:navigate href="{{ route('area.data-input.dasawisma.index') }}" @class([
                                                    'dropdown-item',
                                                    'active' => request()->routeIs('area.data-input.dasawisma.*'),
                                                ])>
                                                    Dasawisma
                                                </a>
                                            @endcan
                                            <a wire:navigate href="{{ route('area.data-input.member.index') }}" @class([
                                                'dropdown-item',
                                                'active' => request()->routeIs('area.data-input.member.*'),
                                            ])>
                                                Anggota
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item @if (request()->routeIs('area.data-recap.*')) active @endif dropdown" x-data="{ open: false }"
                                x-on:click.outside="open = false">
                                <a class="nav-link dropdown-toggle" x-on:click="open = !open" :class="{ 'show': open == true }" role="button">
                                    <span class="nav-link-title">Rekap Data</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                                    :data-bs-popper="{ 'static': open == true }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a wire:navigate href="{{ route('area.data-recap.family-buildings.index') }}"
                                                @class([
                                                    'dropdown-item',
                                                    'active' => request()->routeIs('area.data-recap.family-buildings.*'),
                                                ])>
                                                Bangunan
                                            </a>
                                            <a wire:navigate href="{{ route('area.data-recap.family-size-members.index') }}"
                                                @class([
                                                    'dropdown-item',
                                                    'active' => request()->routeIs('area.data-recap.family-size-members.*'),
                                                ])>
                                                Jumlah Anggota Keluarga
                                            </a>
                                            <a wire:navigate href="{{ route('area.data-recap.family-members.index') }}"
                                                @class([
                                                    'dropdown-item',
                                                    'active' => request()->routeIs('area.data-recap.family-members.*'),
                                                ])>
                                                Anggota Keluarga
                                            </a>
                                            <a wire:navigate href="{{ route('area.data-recap.family-activities.index') }}"
                                                @class([
                                                    'dropdown-item',
                                                    'active' => request()->routeIs('area.data-recap.family-activities.*'),
                                                ])>
                                                Aktivitas Keluarga
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item @if (request()->routeIs('area.dasawisma_activity.*') || request()->routeIs('area.sumsel_news.*')) active @endif dropdown" x-data="{ open: false }"
                                x-on:click.outside="open = false">
                                <a class="nav-link dropdown-toggle" x-on:click="open = !open" :class="{ 'show': open == true }" role="button">
                                    <span class="nav-link-title">Artikel</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                                    :data-bs-popper="{ 'static': open == true }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @can('show-dasawisma-activity')
                                                <a wire:navigate href="{{ route('area.dasawisma_activity.index') }}"
                                                    class="dropdown-item @if (request()->routeIs('area.dasawisma_activity.*')) active @endif">
                                                    Kegiatan Dasawisma
                                                </a>
                                            @endcan
                                            @can('show-sumsel-news')
                                                <a wire:navigate href="{{ route('area.sumsel_news.index') }}"
                                                    class="dropdown-item @if (request()->routeIs('area.sumsel_news.*')) active @endif">
                                                    Berita Sumsel
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item @if (request()->routeIs('area.users.*') || request()->routeIs('area.roles.*') || request()->routeIs('area.permissions.*')) active @endif dropdown" x-data="{ open: false }"
                                x-on:click.outside="open = false">
                                <a class="nav-link dropdown-toggle" x-on:click="open = !open" :class="{ 'show': open == true }" role="button">
                                    <span class="nav-link-title">Manajemen</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                                    :data-bs-popper="{ 'static': open == true }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @can('show-user')
                                                <a wire:navigate href="{{ route('area.users.index') }}"
                                                    class="dropdown-item @if (request()->routeIs('area.users.*')) active @endif">
                                                    User
                                                </a>
                                            @endcan
                                            @if (isset(auth()->user()->admin->province_id) || auth()->user()->role_id === 1)
                                                @if (
                                                    (auth()->user()->admin?->province_id === null || auth()->user()->admin?->province_id !== null) &&
                                                        auth()->user()?->admin->regency_id === null)
                                                    <a wire:navigate href="{{ route('area.roles.index') }}"
                                                        class="dropdown-item @if (request()->routeIs('area.roles.*')) active @endif">
                                                        Role
                                                    </a>
                                                    <a wire:navigate href="{{ route('area.permissions.index') }}"
                                                        class="dropdown-item @if (request()->routeIs('area.permissions.*')) active @endif">
                                                        Permission
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="nav-item @if (request()->routeIs('home')) active @endif">
                                <a class="nav-link" wire:navigate href="{{ route('home') }}">
                                    <span class="nav-link-title">Home</span>
                                </a>
                            </li>
                            <li class="nav-item @if (request()->routeIs('dasawisma_activity.*') || request()->routeIs('sumsel_news.*')) active @endif dropdown" x-data="{ open: false }"
                                x-on:click.outside="open = false">
                                <a class="nav-link dropdown-toggle" x-on:click="open = !open" :class="{ 'show': open == true }" role="button">
                                    <span class="nav-link-title">Artikel</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                                    :data-bs-popper="{ 'static': open == true }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a wire:navigate href="{{ route('dasawisma_activity.index') }}"
                                                class="dropdown-item @if (request()->routeIs('dasawisma_activity.*')) active @endif">
                                                Kegiatan Dasawisma
                                            </a>
                                            <a wire:navigate href="{{ route('sumsel_news.index') }}"
                                                class="dropdown-item @if (request()->routeIs('sumsel_news.*')) active @endif">
                                                Berita Sumsel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item @if (request()->routeIs('org_structure')) active @endif">
                                <a class="nav-link" wire:navigate href="{{ route('org_structure') }}">
                                    <span class="nav-link-title">Struktur Organisasi</span>
                                </a>
                            </li>
                            <li class="nav-item @if (request()->routeIs('about_us')) active @endif">
                                <a class="nav-link" wire:navigate href="{{ route('about_us') }}">
                                    <span class="nav-link-title">Tentang Kami</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>
