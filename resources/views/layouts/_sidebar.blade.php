<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ব্যাপারী</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
              <i class="nav-icon fa fa-dashboard text-blue"></i>
              <p>
                ড্যাশবোর্ড
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </router-link>
          </li>
          @permission('admin-menu')
            <li class="nav-item has-treeview @if(Request::url() == url('/users') | Request::url() == url('/roles')) menu-open @endif">
              <a href="#" class="nav-link {{-- active --}}">
                <i class="nav-icon fa fa-wrench"></i>
                <p>
                  অ্যাডমিন কার্যক্রম
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @permission('user-crud')
                  <li class="nav-item">
                    <router-link to="users" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-users nav-icon"></i>
                      <p>ব্যবহারকারীগণ</p>
                    </router-link>
                  </li>
                @endpermission
                @permission('role-crud')
                  <li class="nav-item">
                    <router-link to="roles" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-tags nav-icon"></i>
                      <p>ব্যবহারকারী ধরন</p>
                    </router-link>
                  </li>
                @endpermission
                @permission('shop-crud')
                  <li class="nav-item">
                    <router-link to="roles" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-list nav-icon"></i>
                      <p>দোকানের তালিকা</p>
                    </router-link>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission
          <li class="nav-item">
            <router-link to="/profile" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
              <i class="nav-icon fa fa-user"></i>
              <p>
                Profile
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
              <i class="nav-icon fa fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="nav-icon fa fa-power-off"></i>
                <p>
                  {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>