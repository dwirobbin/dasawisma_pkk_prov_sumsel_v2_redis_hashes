<div class="navbar-nav flex-row order-md-last">
    <div class="d-flex">
        <a class="nav-link px-0 hide-theme-dark" href="?theme=dark" data-bs-placement="bottom" data-bs-toggle="tooltip" title="Enable dark mode">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
            </svg>
        </a>
        <a class="nav-link px-0 hide-theme-light" href="?theme=light" data-bs-placement="bottom" data-bs-toggle="tooltip"
            title="Enable light mode">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                </path>
            </svg>
        </a>
    </div>

    @auth
        <div class="nav-item dropdown me-2 me-lg-0" x-data="{ open: false }" x-on:click.outside="open = false">
            <a class="nav-link d-flex lh-1 text-reset p-0 cursor-pointer" x-on:click="open = !open" :class="{ 'show': open == true }">
                <img id="profileImage" class="avatar avatar-sm object-cover" src="{{ auth()->user()->photo }}">
                <div class="d-none d-xl-block ps-2">
                    <div>{{ auth()->user()->name }}</div>
                    <div class="mt-1 small text-muted">{{ auth()->user()->role->name }}</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" x-show="open" :class="{ 'show': open == true }" x-transition
                :data-bs-popper="{ 'static': open == true }">
                @if (request()->routeIs('area.*') || request()->routeIs('auth.profile'))
                    @can(['show-profile'])
                        <a wire:navigate href="{{ route('auth.profile') }}" x-ref="profileLink"
                            class="dropdown-item @if (request()->routeIs('auth.profile')) active @endif">
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                    @endcan
                    <a wire:navigate href="{{ route('home') }}" class="dropdown-item @if (request()->routeIs('home')) active @endif">
                        Kembali ke utama
                    </a>
                @else
                    <a wire:navigate href="{{ route('area.dashboard') }}" class="dropdown-item @if (request()->routeIs('area.dashboard')) active @endif">
                        Beranda
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a wire:click='logoutHandler' class="dropdown-item" role="button">Logout</a>
            </div>
        </div>
    @else
        <div class="nav-item d-md-flex me-2 me-lg-0">
            <div class="btn-list">
                <a class="btn @if (request()->routeIs('auth.login')) btn-outline-primary @endif" wire:navigate href="{{ route('auth.login') }}"
                    rel="noreferrer"> Login </a>
            </div>
        </div>
    @endauth
</div>
