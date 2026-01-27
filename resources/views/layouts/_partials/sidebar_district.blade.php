<aside
    id="layout-menu"
    class="layout-menu menu-vertical menu"
    data-bs-theme="dark"
>

    <div class="app-brand demo mb-3">
        <a
            href="{{ route('district.dashboard') }}"
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
        <li class="menu-item @if (request()->is('kecamatan')) active open @endif">
            <a
                href="{{ route('district.dashboard') }}"
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

        <li class="menu-item @if (request()->is('kecamatan/activities*')) active @endif">
            <a
                href="{{ route('district.activities.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-user"></i>
                <div data-i18n="Profile">Kegiatan Desa</div>
            </a>
        </li>

        <!-- Account -->
        <li class="menu-header small">
            <span
                class="menu-header-text"
                data-i18n="Account"
            >Account</span>
        </li>

        <li class="menu-item @if (request()->is('profile')) active @endif">
            <a
                href="{{ route('profile.index') }}"
                class="menu-link"
            >
                <i class="menu-icon icon-base bx bx-user"></i>
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>
    </ul>


</aside>
