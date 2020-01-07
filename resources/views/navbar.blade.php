<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('/'.Request::segment(1)) }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
  @if(Request::segment(1) == 'mahasiswa')
     <span class="logo-mini"><img src="{{ asset('images/logo/logo-kampus.png') }}" width="30" style="margin: 8px;" class="img-responsive"></span>
  @elseif(Request::segment(1) == 'dosen')
     <span class="logo-mini"><img src="{{ asset('images/logo/logo-kampus.png') }}" width="30" style="margin: 8px;" class="img-responsive"></span>
  @elseif(Request::segment(1) == 'admin')
     <span class="logo-mini"><img src="{{ asset('images/logo/logo-kampus.png') }}" width="30" style="margin: 8px;" class="img-responsive"></span>
  @elseif(Request::segment(1) == 'admin_smk')
     <span class="logo-mini"><img src="{{ asset('images/logo/smk.png') }}" width="30" style="margin: 8px;" class="img-responsive"></span>
   @elseif(Request::segment(1) == 'admin_smp')
     <span class="logo-mini"><img src="{{ asset('images/logo/smp-logo.png') }}" width="30" style="margin: 8px;" class="img-responsive"></span>
  @endif  
   
    <!-- logo for regular state and mobile devices -->
  @if(Request::segment(1) == 'mahasiswa')
    <span class="logo-lg"><b>Mahasiswa</b></span>
  @elseif(Request::segment(1) == 'dosen')
    <span class="logo-lg"><b>Dosen</b></span>
  @elseif(Request::segment(1) == 'admin')
    <span class="logo-lg"><b>Admin</b></span> 
  @elseif(Request::segment(1) == 'admin_smk')
    <span class="logo-lg"><b>Admin</b>_SMK</span> 
  @elseif(Request::segment(1) == 'admin_smp')
    <span class="logo-lg"><b>Admin</b>_SMP</span> 
  @endif  
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
          <li class="pull-left">
              @if(Request::segment(1) == 'mahasiswa')
                <a href="{{ route('mahasiswa.pengumuman') }}" title="Pengumuman"><i class="fa fa-bell"></i></a>
              @elseif(Request::segment(1) == 'dosen')
                <a href="{{ route('dosen.pengumuman') }}" title="Pengumuman"><i class="fa fa-bell"></i></a>
              @elseif(Request::segment(1) == 'admin')
                <a href="{{ route('admin.pengumuman') }}" title="Pengumuman"><i class="fa fa-bell"></i></a>
              @elseif(Request::segment(1) == 'admin_smk')
                <a href="{{ route('admin_smk.pengumuman') }}" title="Pengumuman"><i class="fa fa-bell"></i></a>
              @elseif(Request::segment(1) == 'admin_smp')
                <a href="{{ route('admin_smp.pengumuman') }}" title="Pengumuman"><i class="fa fa-bell"></i></a>
              @endif
            </li>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="pull-left">
          @if(Request::segment(1) == 'mahasiswa')
            <a href="{{ route('mahasiswa.password.ubah') }}" title="Ubah Password"><i class="fa fa-lock"></i></a>
          @elseif(Request::segment(1) == 'dosen')
            <a href="{{ route('dosen.password.ubah') }}" title="Ubah Password"><i class="fa fa-lock"></i></a>
          @elseif(Request::segment(1) == 'admin')
            <a href="{{ route('admin.password') }}" title="Ubah Password"><i class="fa fa-lock"></i></a>
          @elseif(Request::segment(1) == 'admin_smk')
            <a href="{{ route('admin_smk.password') }}" title="Ubah Password"><i class="fa fa-lock"></i></a>
          @elseif(Request::segment(1) == 'admin_smp')
            <a href="{{ route('admin_smp.password') }}" title="Ubah Password"><i class="fa fa-lock"></i></a>
          @endif
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            @if(Request::segment(1) == 'mahasiswa')
              @if(Auth::guard('mahasiswa')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('mahasiswa')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/mahasiswa/'.Auth::guard('mahasiswa')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('mahasiswa')->user()->nama }}</span>
              @endif
            @elseif(Request::segment(1) == 'dosen')
              @if(Auth::guard('dosen')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('dosen')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/dosen/'.Auth::guard('dosen')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('dosen')->user()->nama }}</span>
              @endif
            @elseif(Request::segment(1) == 'admin')
              @if(Auth::guard('admin')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/admin/'.Auth::guard('admin')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin')->user()->nama }}</span>
              @endif
              @elseif(Request::segment(1) == 'admin_smk')
              @if(Auth::guard('admin_smk')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin_smk')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/admin/'.Auth::guard('admin_smk')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin_smk')->user()->nama }}</span>
              @endif
            @elseif(Request::segment(1) == 'admin_smp')
              @if(Auth::guard('admin_smp')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin_smp')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/admin/'.Auth::guard('admin_smp')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('admin_smp')->user()->nama }}</span>
              @endif
            @elseif(Request::segment(1) == 'wali')
              @if(Auth::guard('wali')->user()->foto_profil == '')
                <img src="{{ asset('images/default-avatar.png') }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('wali')->user()->nama }}</span>
              @else
                <img src="{{ asset('images/mahasiswa/'.Auth::guard('wali')->user()->foto_profil) }}" class="user-image">
                <span class="hidden-xs">{{ Auth::guard('wali')->user()->nama }}</span>
              @endif
            @endif
            
            
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              @if(Request::segment(1) == 'mahasiswa')
                @if(Auth::guard('mahasiswa')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('mahasiswa')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/mahasiswa/'.Auth::guard('mahasiswa')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('mahasiswa')->user()->nama }}</p>
                @endif
              @elseif(Request::segment(1) == 'dosen')
                @if(Auth::guard('dosen')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('dosen')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/dosen/'.Auth::guard('dosen')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('dosen')->user()->nama }}</p>
                @endif
              @elseif(Request::segment(1) == 'admin')
                @if(Auth::guard('admin')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/admin/'.Auth::guard('admin')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin')->user()->nama }}</p>
                @endif
              @elseif(Request::segment(1) == 'admin_smk')
                @if(Auth::guard('admin_smk')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin_smk')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/admin/'.Auth::guard('admin_smk')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin_smk')->user()->nama }}</p>
                @endif
               @elseif(Request::segment(1) == 'admin_smp')
                @if(Auth::guard('admin_smp')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin_smp')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/admin/'.Auth::guard('admin_smp')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('admin_smp')->user()->nama }}</p>
                @endif
              @elseif(Request::segment(1) == 'wali')
                @if(Auth::guard('wali')->user()->foto_profil == '')
                  <img src="{{ asset('images/default-avatar.png') }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('wali')->user()->nama }}</p>
                @else
                  <img src="{{ asset('images/mahasiswa/'.Auth::guard('wali')->user()->foto_profil) }}" class="img-circle" style="border: none;">
                  <p>{{ Auth::guard('wali')->user()->nama }}</p>
                @endif
              @endif
              
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                @if(Request::segment(1) == 'mahasiswa')
                  <a href="{{ route('mahasiswa.profil') }}" class="btn btn-primary btn-flat">Profile</a>
                @elseif(Request::segment(1) == 'dosen')
                  <a href="{{ route('dosen.profil') }}" class="btn btn-primary btn-flat">Profile</a>
                @elseif(Request::segment(1) == 'admin')
                  <a href="{{ route('admin.profil') }}" class="btn btn-primary btn-flat">Profile</a>
                @elseif(Request::segment(1) == 'admin_smk')
                  <a href="{{ route('admin_smk.profil') }}" class="btn btn-primary btn-flat">Profile</a>
                 @elseif(Request::segment(1) == 'admin_smp')
                  <a href="{{ route('admin_smp.profil') }}" class="btn btn-primary btn-flat">Profile</a>           
                @endif
              </div>
              <div class="pull-right">
                @if(Request::segment(1) == 'mahasiswa')
                  <a href="{{ route('mahasiswa.logout') }}" class="btn btn-primary btn-flat">Log out</a>
                @elseif(Request::segment(1) == 'dosen')
                  <a href="{{ route('dosen.logout') }}" class="btn btn-primary btn-flat">Log out</a>
                @elseif(Request::segment(1) == 'admin')
                  <a href="{{ route('admin.logout') }}" class="btn btn-primary btn-flat">Log out</a>
                @elseif(Request::segment(1) == 'admin_smk')
                  <a href="{{ route('admin_smk.logout') }}" class="btn btn-primary btn-flat">Log out</a>
                 @elseif(Request::segment(1) == 'admin_smp')
                  <a href="{{ route('admin_smp.logout') }}" class="btn btn-primary btn-flat">Log out</a>
                @elseif(Request::segment(1) == 'wali')
                  <a href="{{ route('wali.logout') }}" class="btn btn-primary btn-flat">Log out</a>             
                @endif
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>