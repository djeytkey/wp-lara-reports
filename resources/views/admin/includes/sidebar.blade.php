<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center">
        <img src="{{ asset('assets/admin/dist/img/logo.png') }}" alt="3od Logo" class="brand-image" style="float: inherit;">
        <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link" id="dashboard-item">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            لوحة التحكم
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link" id="users-item">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            المستخدمون
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link" id="orders-item">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>
                            تقرير المبيعات
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>