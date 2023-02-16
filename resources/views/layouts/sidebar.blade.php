<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    @include('layouts.user_panel')

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" 
                   type="search" 
                   placeholder="Search" 
                   aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    @include('layouts.navigation')
    <!-- /.sidebar-menu -->
</div>