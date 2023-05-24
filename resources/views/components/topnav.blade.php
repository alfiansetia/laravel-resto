<nav class="navbar navbar-expand-lg main-navbar">
    <a href="{{ route('home') }}" class="navbar-brand sidebar-gone-hide">{{ $comp->name }}</a>
    <div class="navbar-nav">
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    </div>
    <!-- <div class="nav-collapse">
        <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item active"><a href="#" class="nav-link">Application</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Report Something</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Server Status</a></li>
        </ul>
    </div>
    <form class="form-inline ml-auto">
        <ul class="navbar-nav">
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form> -->
    <ul class="navbar-nav navbar-right ml-auto">
        <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-success text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Low disk space. Let's clean it!
                            <div class="time">17 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Welcome to Stisla template!
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> -->
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() }}</div>
                <a href="{{ route('user.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                @role('admin')
                <a href="{{ route('company.general') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                @endrole
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0);" onclick="logout_();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown {{ $title == 'Data Table' || $title == 'Data Category' || $title == 'Data Menu' || $title == 'Data User' ? 'active' : '' }}">
                <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ $title == 'Data Table' ? 'active' : '' }}"><a class="nav-link" href="{{ route('table.index') }}">Table</a></li>
                    <li class="nav-item {{ $title == 'Data Category' ? 'active' : '' }}"><a class="nav-link" href="{{ route('catmenu.index') }}">Category</a></li>
                    <li class="nav-item {{ $title == 'Data Menu' ? 'active' : '' }}"><a class="nav-link" href="{{ route('menu.index') }}">Menu</a></li>
                    @role('admin')
                    <li class="nav-item {{ $title == 'Data User' ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}">User</a></li>
                    @endrole
                </ul>
            </li>
            <li class="nav-item {{ $title == 'New Order' ? 'active' : '' }}">
                <a href="{{ route('cart.index') }}" class="nav-link"><i class="fas fa-cart-plus"></i><span>New Order</span></a>
            </li>
            <li class="nav-item dropdown {{ $title == 'Data Order' || $title == 'Request Stock' ? 'active' : '' }}">
                <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-exchange-alt"></i><span>Transaction</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ $title == 'Data Order' ? 'active' : '' }}"><a class="nav-link" href="{{ route('order.index') }}">Order</a></li>
                    <li class="nav-item {{ $title == 'Request Stock' ? 'active' : '' }}"><a class="nav-link" href="{{ route('reqstock.index') }}">Request Stock</a></li>
                    <li class="nav-item {{ $title == 'Cancel Order' ? 'active' : '' }}"><a class="nav-link" href="{{ route('order.index') }}">Cancel Order</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $title == 'Report' || $title == 'Report Kasir' ? 'active' : '' }}">
                <a href="javascript:void(0);" data-toggle="dropdown" class="nav-link has-dropdown"><i class="far fa-clone"></i><span>Report</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ $title == 'Report' ? 'active' : '' }}"><a href="{{ route('report.index') }}" class="nav-link">Sales</a></li>
                    @role('admin')
                    <li class="nav-item {{ $title == 'Report Kasir' ? 'active' : '' }}"><a href="{{ route('report.user') }}" class="nav-link">Kasir</a></li>
                    @endrole
                    <!-- <li class="nav-item"><a href="#" class="nav-link">Sales</a></li>
                    <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown">Hover Me</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                            <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown">Link 2</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">Link 3</a></li>
                        </ul>
                    </li> -->
                </ul>
            </li>
        </ul>
    </div>
</nav>