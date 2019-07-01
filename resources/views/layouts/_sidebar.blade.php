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
          <img {{-- :src="getUserProfilePhotoOnNav(1)" --}} {{-- @mounted="getUserProfilePhotoOnNav()" --}} :src="profileNavImageLink"  class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><span id="profileNavName">{{ Auth::user()->name }}</span></a>
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
          @permission('product-page')
            <li class="nav-item has-treeview @if(Request::url() == url('/users') | Request::url() == url('/roles') | Request::url() == url('/stores')) menu-open @endif" {{-- :class="{'menu-open':menuselected == 1}" --}}>
              <a href="#" class="nav-link {{-- active --}}" {{-- @click="menuselected = 1" --}}>
                <i class="nav-icon fa fa-wrench"></i>
                <p>
                  অ্যাডমিন কার্যক্রম
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @permission('user-crud')
                  <li class="nav-item">
                    <router-link to="/users" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-users nav-icon"></i>
                      <p>ব্যবহারকারীগণ</p>
                    </router-link>
                  </li>
                @endpermission
                @permission('role-crud')
                  <li class="nav-item">
                    <router-link to="/roles" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-tags nav-icon"></i>
                      <p>ব্যবহারকারী ধরন</p>
                    </router-link>
                  </li>
                @endpermission
                @permission('store-crud')
                  <li class="nav-item">
                    <router-link to="/stores" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                      <i class="fa fa-list nav-icon"></i>
                      <p>দোকানের তালিকা</p>
                    </router-link>
                  </li>
                @endpermission
              </ul>
            </li>
          @endpermission

          <li class="nav-item has-treeview @if(Request::url() == url('/profile')) menu-open @endif" {{-- :class="{'menu-open':menuselected == 2}" --}}>
            <a href="#" class="nav-link {{-- active --}}" {{-- @click="menuselected = 2" --}}>
              <i class="nav-icon fa fa-user"></i>
              <p>
                ব্যবহারকারী
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/profile" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                  <i class="nav-icon fa fa-address-book-o"></i>
                  <p>প্রোফাইল</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item-separator"></li>
          
          @foreach(Auth::user()->stores as $stores_for_nav)
            <li class="nav-item has-treeview @if(Request::url() == url('/store/'.$stores_for_nav->token.'/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/products/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/vendors/'.$stores_for_nav->code)) menu-open @endif" {{-- :class="{'menu-open':menuselected == 2}" --}}>
              <a href="#" class="nav-link {{-- active --}}" {{-- @click="menuselected = 2" --}}>
                <i class="nav-icon fa fa-university"></i>
                <p>
                  <span id="changeNavStoreName{{ $stores_for_nav->id }}">{{ $stores_for_nav->name }}</span>
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @permission('store-crud')
                <li class="nav-item">
                  <router-link :to="{ name: 'singleStore', params: { token: '{{ $stores_for_nav->token }}', code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @click.native="changeStoreName" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-address-card-o"></i>
                    <p>দোকানের প্রোফাইল</p>
                  </router-link> 
                  {{-- <a href="{{ url('store/'.$stores_for_nav->token.'/'.$stores_for_nav->code) }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-pencil"></i>
                    <p>প্রোফাইল</p>
                  </a> --}}
                </li>
                @endpermission
                @permission('product-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'productsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-list-ul"></i>
                    <p>মালামাল তালিকা</p>
                  </router-link> 
                </li>
                @endpermission
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>ক্রয়ের হিসাব</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>বিক্রয়ের হিসাব</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>লেন-দেন হিসাব</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>কাস্টমার তালিকা</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>কর্মচারী তালিকা</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>খরচের হিসাব</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>খরচের হিসাব</p>
                  </a>
                </li>
                @permission('vendor-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'vendorsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @click.native="changeStoreName" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-truck"></i>
                    <p>ডিলার/ ভেন্ডরের তালিকা</p>
                  </router-link> 
                </li>
                @endpermission
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>বাকির হিসাব</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#!" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-plus"></i><p>রিপোর্ট</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item-separator"></li>
          @endforeach

          {{-- <li class="nav-item">
            <a href="#" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
              <i class="nav-icon fa fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> --}}
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
  