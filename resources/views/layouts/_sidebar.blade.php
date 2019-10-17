<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">দোকান খাতা</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img {{-- :src="getUserProfilePhotoOnNav(1)" --}} {{-- @mounted="getUserProfilePhotoOnNav()" --}} :src="profileNavImageLink"  class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ url('/profile') }}" class="d-block">
            <span id="profileNavName">{{ Auth::user()->name }}</span><br/>
          </a>
          <small id="networkStatus" style="color: #C2C7D0;"><i class="fa fa-circle" style="color: #42B72A;"></i> অনলাইন</small>
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
          @permission('user-crud') {{-- eta pore admin section name e ekta permiossion korte hobe --}}
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
            <li class="nav-item has-treeview @if(Request::url() == url('/store/'.$stores_for_nav->token.'/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/products/'.$stores_for_nav->code)) menu-open @endif @if(Request::is('product/*/' . $stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/purchases/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/sales/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/dues/'.$stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/expenses/'.$stores_for_nav->code)) menu-open @endif @if(Request::is('expense/*/' . $stores_for_nav->code)) menu-open @endif @if(Request::url() == url('/vendors/'.$stores_for_nav->code)) menu-open @endif @if(Request::is('vendor/*/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('customers/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('customer/*/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('staffs/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('staff/*/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('customer-dues/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('accounts/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('reports/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('purchase/new/' . $stores_for_nav->code)) menu-open @endif @if(Request::is('sale/new/' . $stores_for_nav->code)) menu-open @endif" {{-- :class="{'menu-open':menuselected == 2}" --}}>
              <a href="#" class="nav-link {{-- active --}}" {{-- @click="menuselected = 2" --}}>
                <i class="nav-icon fa fa-university"></i>
                <p>
                  <i class="right fa fa-angle-left"></i><small><span id="changeNavStoreName{{ $stores_for_nav->id }}">{{ $stores_for_nav->name }}</span></small>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @permission('store-profile')
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
                    <i class="nav-icon fa fa-cubes"></i>
                    <p>মালামাল তালিকা</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('purchase-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'purchasesPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-briefcase"></i>
                    <p>ক্রয়ের হিসাব</p>
                  </router-link> 
                </li>
                @endpermission 
                @permission('due-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'duesPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-hourglass-start"></i>
                    <p>দেনার হিসাব</p>
                  </router-link> 
                </li>
                @endpermission        
                @permission('sale-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'salesPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-line-chart"></i>
                    <p>বিক্রয়ের হিসাব</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('customer-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'customersPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-users"></i>
                    <p>কাস্টমার তালিকা</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('staff-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'staffsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-vcard-o"></i>
                    <p>কর্মচারী ব্যবস্থাপনা</p>
                  </router-link> 
                </li>
                @endpermission   
                @permission('expense-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'expensesPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-cogs"></i>
                    <p>খরচের হিসাব</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('vendor-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'vendorsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-truck"></i>
                    <p>ডিলার/ ভেন্ডরের তালিকা</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('customer-due-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'customerduesPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-book"></i>
                    <p>বকেয়ার হিসাব</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('accounts-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'accountsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-calculator"></i>
                    <p>হিসাব-নিকাশ একনজরে</p>
                  </router-link> 
                </li>
                @endpermission
                @permission('reports-page')
                <li class="nav-item">
                  <router-link :to="{ name: 'reportsPage', params: { code: '{{ $stores_for_nav->code }}' }}" class="nav-link" @mobile data-widget="pushmenu" @endmobile>
                    <i class="nav-icon fa fa-pie-chart"></i>
                    <p>রিপোর্ট</p>
                  </router-link> 
                </li>
                @endpermission
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
  