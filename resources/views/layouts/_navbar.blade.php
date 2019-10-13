<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
  </ul>

  <!-- SEARCH FORM -->
  <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" v-model="search" @keyup="searchIt" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" @click.prevent="searchIt">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item" style="cursor: pointer;"  v-tooltip="'ক্রয় করুন'" @click="purchaseFromNavBtn">
      <a class="nav-link">
        <i class="fa fa-cart-plus"></i> <span id="purchaseStoreNavCode"></span>
      </a>
    </li>
    <li class="nav-item" style="cursor: pointer;" v-tooltip="'বিক্রয় করুন'" @click="saleFromNavBtn">
      <a class="nav-link">
        <i class="fa fa-balance-scale"></i> <span id="saleStoreNavCode"></span>
      </a>
    </li>
    {{-- <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-comments-o"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <div class="media">
            <img src="{{ asset('images/profile.png') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <div class="media">
            <img src="{{ asset('images/profile.png') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Nora Silvester
                <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
              </h3>
              <p class="text-sm">The subject goes here</p>
              <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li> --}}
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown" v-tooltip="'নোটিফিকেশন'">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-bell-o"></i>
        <span class="badge badge-warning navbar-badge">1</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">5 Notifications</span>
        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item" style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
          <i class="fa fa-envelope mr-2"></i> 4 new messages 4 new messages 4 new messages 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item" v-tooltip="'সারাদিনের লেন-দেন'" @click="dailyDebitCredit">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
          class="fa fa-th-large"></i></a>
    </li>
  </ul>
</nav>