<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/icons/brands/melawai.png') }}" alt="logo melawai" width="40" height="40" />
            </span>
            <span class="app-brand-text menu-text fw-bolder ms-2 fs-3">&nbsp;Stock Obat</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{ route('home.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-capsule'></i>
                <div data-i18n="Obat">Obat</div>
            </a>
        </li>
    </ul>
</aside>