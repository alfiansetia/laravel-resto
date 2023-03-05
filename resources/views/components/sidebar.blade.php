<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">{{ $comp->name }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">AR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Master Data</li>
            <li class="nav-item dropdown {{ $title == 'Data Table' || $title == 'Data Category' || $title == 'Data Menu' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i> <span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'Data Table' ? 'active' : '' }}"><a class="nav-link" href="{{ route('table.index') }}">Table</a></li>
                    <li class="{{ $title == 'Data Category' ? 'active' : '' }}"><a class="nav-link" href="{{ route('catmenu.index') }}">Category</a></li>
                    <li class="{{ $title == 'Data Menu' ? 'active' : '' }}"><a class="nav-link" href="{{ route('menu.index') }}">Menu</a></li>
                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul>
            </li>
            <li class="menu-header">Transaction</li>
            <li class="{{ $title == 'New Order' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-cart-plus"></i> <span>New Order</span></a>
            </li>
            <li class="nav-item dropdown {{ $title == 'Data Order' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link has-dropdown"><i class="fas fa-exchange-alt"></i> <span>Transaction</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'Data Order' ? 'active' : '' }}"><a class="nav-link" href="{{ route('order.index') }}">Order</a></li>
                    <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
                    <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
                </ul>
            </li>
            <li class="menu-header">Pages</li>
            <li class="nav-item dropdown {{ $title == 'Data User' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link has-dropdown"><i class="fas fa-bicycle"></i> <span>Features</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'Data User' ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}">Data User</a></li>
                    <li><a class="nav-link" href="features-post-create.html">Post Create</a></li>
                    <li><a class="nav-link" href="features-setting-detail.html">Setting Detail</a></li>
                    <li><a class="nav-link" href="features-tickets.html">Tickets</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $title == 'User Profile' || $title == 'Change Password' || $title == 'Setting Company' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link has-dropdown"><i class="fas fa-user-cog"></i> <span>Setting</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'User Profile' ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.profile') }}">Profile</a></li>
                    <li class="{{ $title == 'Change Password' ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.password') }}">Password</a></li>
                    <li class="{{ $title == 'Setting Company' ? 'active' : '' }}"><a class="nav-link" href="{{ route('company.index') }}">Company</a></li>
                </ul>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>