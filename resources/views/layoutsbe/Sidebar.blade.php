 <!-- Sidebar -->
 <ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon">
             <img src="{{ asset('pena.png') }}">
         </div>
         <div class="sidebar-brand-text mx-3">Apple Store</div>
     </a>
     <hr class="sidebar-divider my-0">

     <li class="nav-item">
         <a class="nav-link active" href="/dashboard">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <b><span>Dashboard</span></a></b>
     </li>

     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Data
     </div>
     {{-- @if (auth()->user()->level == 'Super Admin') --}}
     <li class="nav-item {{ request()->is('cms/backend/data/admin') ? 'active' : '' }}">
         <a class="nav-link " href="/cms/backend/data/admin" style="font-size:14px;" data-target="#collapsePage"
             aria-expanded="true" aria-controls="collapsePage">
             <i class="fas fa-fw fa-user"></i>
             Data Admin
         </a>
     </li>
     <li class="nav-item {{ request()->is('cms/backend/phone') ? 'active' : '' }}">
         <a class="nav-link " href="/cms/backend/phone" style="font-size:14px;" data-target="#collapsePage"
             aria-expanded="true" aria-controls="collapsePage">
             <i class="fa-brands fa-product-hunt"></i>
             Data Phone
         </a>
     </li>
     <li class="nav-item {{ request()->is('cms/backend/detail/phone ') ? 'active' : '' }}">
        <a class="nav-link " href="/cms/backend/detail/phone" style="font-size:14px;" data-target="#collapsePage"
            aria-expanded="true" aria-controls="collapsePage">
            <i class="fa-brands fa-product-hunt"></i>
            Detail Phone
        </a>
    </li>

     {{-- @endif --}}



     <hr class="sidebar-divider">

 </ul>

 <!-- Sidebar -->
