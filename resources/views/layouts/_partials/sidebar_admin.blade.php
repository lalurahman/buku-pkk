<aside
    id="layout-menu"
    class="layout-menu menu-vertical menu"
    data-bs-theme="dark"
>

    <div class="app-brand demo mb-3">
        <a
            href="{{ route('admin.dashboard') }}"
            class="app-brand-link"
        >
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img
                        src="{{ asset('admin/img/logo.png') }}"
                        alt="logo"
                        width="50"
                    >
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                <img
                    src="{{ asset('admin/img/logo-takalar.png') }}"
                    alt="Logo Takalar"
                    width="40"
                >
            </span>
        </a>

        <a
            href="javascript:void(0);"
            class="layout-menu-toggle menu-link text-large ms-auto"
        >
            <i class="icon-base bx bx-chevron-left"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item @if (request()->is('administrator')) active open @endif">
            <a
                href="{{ route('admin.dashboard') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-home-smile"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Data Master -->
        <li class="menu-header small">
            <span class="menu-header-text">
                {{ Auth::user()->roles->pluck('name')->first() }}
            </span>
        </li>

        <li class="menu-item @if (request()->is('administrator/members*') || request()->is('administrator/main-members*')) active open @endif">
            <a
                href="javascript:void(0);"
                class="menu-link menu-toggle"
            >
                <i class="menu-icon icon-base bx bx-group"></i>
                <div>Data Anggota</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if (request()->is('administrator/members*')) active @endif">
                    <a
                        href="{{ route('admin.members.index') }}"
                        class="menu-link"
                    >
                        <div>Kader</div>
                    </a>
                </li>
                <li class="menu-item @if (request()->is('administrator/main-members*')) active @endif">
                    <a
                        href="{{ route('admin.members.main.index') }}"
                        class="menu-link"
                    >
                        <div>Tim Penggerak</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if (request()->is('administrator/*-letters*')) active open @endif">
            <a
                href="javascript:void(0);"
                class="menu-link menu-toggle"
            >
                <i class="menu-icon icon-base bx bx-file"></i>
                <div>Data Persuratan</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if (request()->is('administrator/incoming-letters*')) active @endif">
                    <a
                        href="{{ route('admin.incoming-letters.index') }}"
                        class="menu-link"
                    >
                        <div>Surat Masuk</div>
                    </a>
                </li>
                <li class="menu-item @if (request()->is('administrator/outgoing-letters*')) active @endif">
                    <a
                        href="{{ route('admin.outgoing-letters.index') }}"
                        class="menu-link"
                    >
                        <div>Surat Keluar</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if (request()->is('administrator/activities*')) active @endif">
            <a
                href="{{ route('admin.activities.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-calendar"></i>
                <div data-i18n="Profile">Data Kegiatan</div>
            </a>
        </li>
        <li class="menu-item @if (request()->is('administrator/cash-flows*')) active @endif">
            <a
                href="{{ route('admin.cash-flows.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-wallet"></i>
                <div data-i18n="Profile">Data Keuangan</div>
            </a>
        </li>
        <li class="menu-item @if (request()->is('administrator/meeting-minutes*')) active @endif">
            <a
                href="{{ route('admin.meeting-minutes.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-note"></i>
                <div data-i18n="Profile">Data Notulensi</div>
            </a>
        </li>
        <li class="menu-item @if (request()->is('administrator/guest-books*')) active @endif">
            <a
                href="{{ route('admin.guest-books.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-book"></i>
                <div data-i18n="Profile">Buku Tamu</div>
            </a>
        </li>

        <!-- Account -->
        <li class="menu-header small">
            <span
                class="menu-header-text"
                data-i18n="Account"
            >Account</span>
        </li>

        <li class="menu-item @if (request()->is('administrator/profile')) active @endif">
            <a
                href="#"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-user"></i>
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>
    </ul>


</aside>
