{{-- @can('access_sidebar_management') --}}
@can('access_sidebar_management')
<!-- Main Sidebar Container -->
  @php
      $profile = \Modules\Setting\Entities\CompanyProfile::first();
  @endphp
  <aside class="main-sidebar elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="brand-link text-center text-white" style="background-color: #007bff"
          style="text-decoration: none;">
          {{-- <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
          {{-- <i class="fa fa-paw"></i> --}}
          @php($branch = Session::get('branch'))
          <span class="brand-text font-weight-bold ">{{ $branch->name ?? $profile->company_name }} </span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="">

                 <img src="{{ asset('images/company/' . $profile->logo) }}" class="img-circle elevation-2"
                      alt="User Image" style="width: 40px; height: 40px;">
              </div>
              {{-- <div class="info">
          <a href="{{ route('home') }}" class="d-block" style="text-decoration: none;">{{ $profile->company_name }}</a>
        </div> --}}
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2 mb-4">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item {{ request()->routeIs('home') ? 'menu-open' : '' }}">
                      <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard

                          </p>
                      </a>
                  </li>
                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  Users Management
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('roles.index') }}"
                                      class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Roles</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.index') }}"
                                      class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Users</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.create') }}"
                                      class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create Users</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan


                  @if (auth()->user()->access_type === 'Super Admin')
                      @can('access_restaurent')
                          <li class="nav-item {{ request()->routeIs('restaurent.*') ? 'menu-is-opening menu-open' : '' }}">
                              <a href="#" class="nav-link" {{ request()->routeIs('restaurent.*') ? 'active' : '' }}>
                                  <i class="nav-icon fas fa-store"></i>
                                  <p>
                                      Restaurent
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              {{-- @dd(Auth::user()->hasVerifiedEmail()) --}}
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="{{ route('restaurent.index') }}"
                                          class="nav-link {{ request()->routeIs('restaurent.index') ? 'active' : '' }}">
                                          {{-- <i class="far fa-circle nav-icon"></i> --}}
                                          <p>Restaurent</p>
                                      </a>
                                  </li>

                              </ul>
                          </li>
                      @endcan
                  @else
                  @endif
                  @if (auth()->user()->access_type === 'Admin' || auth()->user()->access_type === 'Reception')
                      <li class="nav-item {{ request()->routeIs('tables.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('tables.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-store"></i>
                              <p>
                                  Tables
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          {{-- @dd(Auth::user()->hasVerifiedEmail()) --}}
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('sections.index') }}"
                                      class="nav-link {{ request()->routeIs('sections.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Section</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('tables.index') }}"
                                      class="nav-link {{ request()->routeIs('tables.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Tables</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                      <li
                          class="nav-item {{ request()->routeIs('menus.*') || request()->routeIs('categories.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link"
                              {{ request()->routeIs('menus.*') || request()->routeIs('categories.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-store"></i>
                              <p>
                                  Menus
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview pl-3"><!-- added pl-3 for left padding -->
                              <li class="nav-item {{ request()->routeIs('menus.index') ? 'active' : '' }}">
                                  <a href="{{ route('menus.index') }}" class="nav-link pl-2">
                                      <p>Menus</p>
                                  </a>
                              </li>
                              <li class="nav-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                  <a href="{{ route('categories.index') }}" class="nav-link pl-2">
                                      <p>Menus Categories</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li class="nav-item {{ request()->routeIs('offices.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="{{ route('offices.index') }}" class="nav-link"
                              {{ request()->routeIs('offices.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-store"></i>
                              <p>
                                  Offices
                              </p>
                          </a>
                      </li>
                      <li
                          class="nav-item {{ request()->routeIs('neworders') || request()->routeIs('orders.index') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link">
                              <i class="nav-icon fas fa-store"></i>
                              <p>
                                  Order Management
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('neworders') }}"
                                      class="nav-link {{ request()->routeIs('neworders') ? 'active' : '' }}">
                                      <p>New Order</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('orders.index') }}"
                                      class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                      <p>Orders</p>
                                  </a>
                              </li>
                              {{-- Only include if routes exist --}}
                              <li class="nav-item">
                                  <a href="{{ route('kitchenorders') }}"
                                      class="nav-link {{ request()->routeIs('kitchenorders') ? 'active' : '' }}">
                                      <p>Kitchen Order</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('receptionorders') }}"
                                      class="nav-link {{ request()->routeIs('receptionorders') ? 'active' : '' }}">
                                      <p>Reception Order</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('completedorders') }}"
                                      class="nav-link {{ request()->routeIs('completedorders') ? 'active' : '' }}">
                                      <p>Completed Order</p>
                                  </a>
                              </li>

                          </ul>
                      </li>



                      <li class="nav-item {{ request()->routeIs('customers.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="{{ route('customers.index') }}" class="nav-link"
                              {{ request()->routeIs('customers.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-store"></i>
                              <p>
                                  Customers
                              </p>
                          </a>
                      </li>
                  @else
                  @endif
                  <!--
                  @can('access_sliders')
    <li class="nav-item {{ request()->routeIs('sliders.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('sliders.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-image"></i>
                                                      <p>
                                                          Sliders
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('sliders.index') }}"
                                                              class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Sliders</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('sliders.create') }}"
                                                              class="nav-link {{ request()->routeIs('sliders.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create Sliders</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan
                  {{-- Product Mgnt --}}
                  @can('access_product')
    <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                                                  <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                                                      <i class="nav-icon fas fa-image"></i>
                                                      <p>
                                                          Product Mgnt
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('products-categories.index') }}"
                                                              class="nav-link @if (request()->routeIs('products-categories.index')) active @endif">
                                                              <p>Categories</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('products-brands.index') }}"
                                                              class="nav-link @if (request()->routeIs('products-brands.index')) active @endif">
                                                              <p>Brands</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('products-machineries.index') }}"
                                                              class="nav-link @if (request()->routeIs('products-machineries.index')) active @endif">
                                                              <p>Machineries</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('products-accessories.index') }}"
                                                              class="nav-link @if (request()->routeIs('products-accessories.index')) active @endif">
                                                              <p>Accessories</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('technicaltools.index') }}"
                                                              class="nav-link {{ request()->routeIs('technicaltools.index') ? 'active' : '' }}">
                                                              <p>Technical Tools</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan

                  {{-- Blogs --}}
                  @can('access_blogs')
    <li class="nav-item {{ request()->routeIs('blogs.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('blogs.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-newspaper"></i>
                                                      <p>
                                                          Blogs
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('blogs.index') }}"
                                                              class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Blog</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('blogs.create') }}"
                                                              class="nav-link {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create Blogs</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan


                  @can('access_expenses')
    <li class="nav-item {{ request()->routeIs('expenses.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('expenses.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-newspaper"></i>
                                                      <p>
                                                          Expenses
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('expenses-categories.index') }}"
                                                              class="nav-link {{ request()->routeIs('expenses-categories.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Category</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('expenses.index') }}"
                                                              class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Expenses</p>
                                                          </a>
                                                      </li>

                                                  </ul>
                                              </li>
@endcan


                  {{-- Teams --}}
                  @can('access_teams')
    <li class="nav-item {{ request()->routeIs('teams.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('teams.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-user"></i>
                                                      <p>
                                                          Teams
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('teams.index') }}"
                                                              class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Teams</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('teams.create') }}"
                                                              class="nav-link {{ request()->routeIs('teams.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create Teams</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan
                  {{-- FAQs --}}
                  @can('access_faqs')
    <li class="nav-item {{ request()->routeIs('faqs.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('faqs.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-question-circle"></i>
                                                      <p>
                                                          FAQs
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('faqs.index') }}"
                                                              class="nav-link {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>FAQs</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('faqs.create') }}"
                                                              class="nav-link {{ request()->routeIs('faqs.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create FAQs</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan
                  {{-- Testimonial --}}
                  @can('access_testimonials')
    <li class="nav-item {{ request()->routeIs('testimonials.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('testimonials.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-comment"></i>
                                                      <p>
                                                          Testimonial
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('testimonials.index') }}"
                                                              class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Testimonials</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('testimonials.create') }}"
                                                              class="nav-link {{ request()->routeIs('testimonials.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create Testimonials</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan
                  {{-- Vacancies --}}
                  @can('access_vacancies')
    <li class="nav-item {{ request()->routeIs('vacancies.*') ? 'menu-is-opening menu-open' : '' }}">
                                                  <a href="#" class="nav-link" {{ request()->routeIs('vacancies.*') ? 'active' : '' }}>
                                                      <i class="nav-icon fas fa-briefcase"></i>
                                                      <p>
                                                          Vacancies
                                                          <i class="right fas fa-angle-left"></i>
                                                      </p>
                                                  </a>
                                                  <ul class="nav nav-treeview">
                                                      <li class="nav-item">
                                                          <a href="{{ route('vacancies.index') }}"
                                                              class="nav-link {{ request()->routeIs('vacancies.index') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Vacancies</p>
                                                          </a>
                                                      </li>
                                                      <li class="nav-item">
                                                          <a href="{{ route('vacancies.create') }}"
                                                              class="nav-link {{ request()->routeIs('vacancies.create') ? 'active' : '' }}">
                                                              {{-- <i class="far fa-circle nav-icon"></i> --}}
                                                              <p>Create Vacancy</p>
                                                          </a>
                                                      </li>
                                                  </ul>
                                              </li>
@endcan

                  {{-- Inquiries --}}
                  @can('access_inquiries')
    <li class="nav-item">
                                                  <a href="{{ route('inquires.index') }}"
                                                      class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                                                      <i class="far fa-address-book nav-icon"></i>
                                                      <p>Inquiries</p>
                                                  </a>
                                              </li>
@endcan
                  {{-- Setting --}}
                    -->
                  @can('access_settings')
                      <li class="nav-item {{ request()->routeIs('company.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('company.*') ? 'active' : '' }}>
                              <i class="nav-icon fas fa-cogs"></i>
                              <p>
                                  Setting
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('company.index') }}"
                                      class="nav-link {{ request()->routeIs('company.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Company Profile</p>
                                  </a>
                              </li>
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('whyus.index') }}"
                                      class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Why Choose Us</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

@endcan
{{-- @endcan --}}