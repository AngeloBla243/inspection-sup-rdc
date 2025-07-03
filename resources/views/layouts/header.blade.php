<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- @php
            $AllChatUserCount = App\Models\ChatModel::getAllChatUserCount();
        @endphp --}}
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
        </li>

        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link"
                    style="display: inline; padding: 0; border: none; background: none;">
                    <i class="nav-icon fa fa-sign-out-alt"></i>
                    <p class="d-inline ml-1">Logout</p>
                </button>
            </form>
        </li>


    </ul>
</nav>
<!-- /.navbar -->


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link" style="text-align: center;">

        <span class="brand-text font-weight-light"
            style="font-weight: bold !important;font-size: 20px;">Inspection</span>

    </a>



    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Photo de profil"
                    class="user-image img-circle elevation-2" style="width: 40px; height: 40px; object-fit:cover;">



                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>

                @if (Auth::user()->user_type == 1)
                    {{-- Liens spécifiques Admin --}}
                    <li class="nav-item">
                        <a href="{{ url('admin/admin/list') }}"
                            class="nav-link {{ request()->is('admin/admin*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>Admin</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/inspecteur/list') }}"
                            class="nav-link {{ request()->is('admin/inspecteur*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>Liste Inspecteurs</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.universities.index') }}"
                            class="nav-link {{ request()->is('admin/universities*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-university"></i>
                            <p>Universités / Instituts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.professors.index') }}"
                            class="nav-link {{ request()->is('admin/professors*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Professeurs & Ouvriers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.inspections.index') }}"
                            class="nav-link {{ request()->is('admin/inspections*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Planification des inspections</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.inspection_reports.index') }}"
                            class="nav-link {{ request()->is('admin/inspection_reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Rapports d'inspection</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.student_reports.index') }}"
                            class="nav-link {{ request()->is('admin/student_reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <p>Signalements étudiants</p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.system_settings.index') }}"
                            class="nav-link {{ request()->is('admin/system_settings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Paramètres du système</p>
                        </a>
                    </li>


                    {{-- Autres liens admin... --}}
                @elseif(Auth::user()->user_type == 2)
                    {{-- Liens spécifiques Inspecteur --}}
                    <li class="nav-item">
                        <a href="{{ url('inspecteur/somepage') }}"
                            class="nav-link {{ request()->is('inspecteur/somepage*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>Inspecteur Page</p>
                        </a>
                    </li>
                    {{-- Autres liens inspecteur... --}}
                @endif

            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
