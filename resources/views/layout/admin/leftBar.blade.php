<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div class="user-box text-center">
            <img src="" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-bs-toggle="dropdown">Admin</a>
                <div class="dropdown-menu user-pro-dropdown">
                    <a href="#" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <img src="{{ asset('web_assets/admin/images/dashboard.png') }}" alt="">
                        <span> Dashboard </span>
                    </a>
                </li>
                @can('super_admin')
                    <li>
                        <a href="#users" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">
                            <img src="{{ asset('web_assets/admin/images/admin.png') }}" alt="">
                            <span> Admins </span>
                            <span class="menu-arrow"> </span>
                        </a>
                        <div class="collapse" id="users" style="">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.users_list') }}">
                                        List
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users.create') }}">
                                        Add
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.trash_list') }}">
                                        Trash
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="#blog" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">
                        <img src="{{ asset('web_assets/admin/images/blogger.png') }}" alt="">
                        <span> Blog </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="blog" style="">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('blog.index') }}">List</a>
                            </li>
                            <li>
                                <a href="{{ route('blog.add') }}">Add</a>
                            </li>
                            @can('super_admin')
                                <li>
                                    <a href="{{ route('blog.trash_list') }}">Trash</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    </a>
                </li>
                <li>
                    <a href="#tools" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">
                        <img src="{{ asset('web_assets/admin/images/coding.png') }}" alt="">
                        <span> Tools </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="tools">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('tool.index') }}">List</a>
                            </li>
                            <li>
                                <a href="{{ route('tool.add') }}">Add</a>
                            </li>
                            @can('super_admin')
                                <li>
                                    <a href="{{ route('tool.trash_list') }}">Trash</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    </a>
                </li>
                <li>
                    <a href="#media" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">
                        <img src="{{ asset('web_assets/admin/images/gallery.png') }}" alt="">
                        <span> Media </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="media">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('media.add') }}">Add</a>
                            </li>
                            @can('super_admin')
                                <li>
                                    <a href="{{ route('media.trash_list') }}">Trash</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    </a>
                </li>
                <li>
                    <a href="#contacts" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">
                        <img src="{{ asset('web_assets/admin/images/gallery.png') }}" alt="">
                        <span> Contacts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="contacts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('dashboard.contacts.list') }}">Index</a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.contacts.trash') }}">Trash</a>
                            </li>
                        </ul>
                    </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.settings') }}" class="active">
                        <img src="{{ asset('web_assets/admin/images/settings.png') }}" alt="">
                        <span> Settings </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.components') }}" class="active">
                        <img src="{{ asset('web_assets/admin/images/tech.png') }}" alt="">
                        <span> Modals </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
