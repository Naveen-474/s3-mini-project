<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            @php
                $username = Auth::user();
                $roles = $username->getRoleNames()->first();
            @endphp
            {{$roles}}
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{url('/dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Application Control
    </div>

    @canany(['role.edit','role.create','role.delete'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#roles"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Role</span>
            </a>
            <div id="roles" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Roles</h6>
                    <a class="collapse-item" href="{{route('role.index')}}">List Role</a>
                </div>
            </div>
        </li>
    @endcan

    @canany(['user.edit','user.create','user.delete'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-user"></i>
                <span>User</span>
            </a>
            <div id="users" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Users</h6>
                    <a class="collapse-item" href="{{route('user.index')}}">List Users</a>
                </div>
            </div>
        </li>
    @endcan

    @canany(['category.edit','category.create','category.delete'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categories"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-th"></i>
                <span>Categories</span>
            </a>
            <div id="categories" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Categories</h6>
                    <a class="collapse-item" href="{{route('category.index')}}">List Categories</a>
                </div>
            </div>
        </li>
    @endcan

    @canany(['sub.category.edit','sub.category.create','sub.category.delete'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#labels"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-bars"></i>
                <span>Sub Category</span>
            </a>
            <div id="labels" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Sub Category</h6>
                    <a class="collapse-item" href="{{route('sub-categories.index')}}">List Sub Category</a>
                </div>
            </div>
        </li>
    @endcan

    @canany(['image.edit','image.create','image.delete'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#priorities"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Images</span>
            </a>
            <div id="priorities" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Images</h6>
                    <a class="collapse-item" href="{{route('image.index')}}">List Images</a>
                </div>
            </div>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
