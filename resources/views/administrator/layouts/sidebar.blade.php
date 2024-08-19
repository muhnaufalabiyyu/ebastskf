<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('userskf') || request()->routeIs('usersupplier') || request()->routeIs('adduserskf') || request()->routeIs('addusersupplier') ? '' : 'collapsed' }}"
                data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User Access</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav"
                class="nav-content collapse {{ request()->routeIs('userskf') || request()->routeIs('usersupplier') || request()->routeIs('adduserskf') || request()->routeIs('addusersupplier') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('userskf') }}" class="{{ request()->routeIs('userskf') || request()->routeIs('adduserskf') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>SKF</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('usersupplier') }}"
                        class="{{ request()->routeIs('usersupplier') || request()->routeIs('addusersupplier') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Supplier</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bastdata') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('bastdata') }}">
                <i class="bi bi-file-earmark-check"></i>
                <span>BAST Data</span>
            </a>
        </li>
    </ul>
</aside><!-- End Sidebar-->
