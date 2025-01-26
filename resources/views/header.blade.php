<script type='text/javascript'> 
    var urljs = '@php echo URL('/').'/'; @endphp'
    var uso_area = '@php echo Session::get('SESS_AREA_CODIGO'); @endphp'
    var uso_perfil = '@php echo Session::get('SESS_PERF_CODIGO'); @endphp'

</script>

<style>
    .brand{
        /* background-color: #ffffff!important; */
    }
    @media (max-width: 1024px){
        .topbar .brand {
         width: 127px !important;
        }
    }
</style>
<div class="topbar bg-blue">            
    <!-- Navbar -->
    <div class="brand bg-blue">
        <a href="#" class="logo">
            <span>
                <img src="{{ asset('assets/images/muni.png') }}" alt="logo-small" class="logo-sm" style="height: 70%;border-radius:5px;">
            </span>
            
        </a>
    </div>

    <nav class="navbar-custom px-2 bg-blue " >    
        <ul class="list-unstyled topbar-nav float-end mb-0">  
                               
 
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i data-feather="bell" class="align-self-center topbar-icon"></i>
                    <span class="badge bg-danger rounded-pill noti-icon-badge">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Notifications <span class="badge bg-primary rounded-pill">0</span>
                    </h6> 
                    <div class="notification-menu" data-simplebar>
                    </div>
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        Ver todos <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user_M.png') }}" alt="profile-user" class="rounded-circle thumb-xs" />
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text text-white">{{ Session::get('SESS_NOMBRE_COMPLETO') }} <i
                                            class="mdi mdi-chevron-down"></i></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-white user-name-sub-text">{{ Session::get('SESS_PERF_NOMBRE') }}</span>
                            </span>
                        </span>
                    </button> 

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:verPerfil()"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Perfil</a>
                    <a class="dropdown-item" href="javascript:cambiarClave()"><i data-feather="settings" class="align-self-center icon-xs icon-dual me-1"></i> Cambiar contraseña</a>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item text-success" href="{{ route('logout') }}"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1 text-success"></i> Cerrar sesión</a>
                </div>
            </li>
            
            <li class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link" id="mobileToggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a><!-- End mobile menu toggle-->
            </li>
            
        </ul>

        @include('navbar')
        
    </nav>
</div>