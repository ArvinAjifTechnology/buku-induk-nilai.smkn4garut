<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('') }}assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Buku Induk SMKN 4 Garut</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('') }}assets/img/favicon/favicon.ico" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/boxicons.css" />

    <!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/css/demo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/apex-charts/apex-charts.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('') }}assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('') }}assets/js/config.js"></script>

    @stack('css')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('home') }}" class="app-brand-link">
              <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo SMKN 4 garut" width="50">
              <span class="demo menu-text fw-bolder ms-2 font-medium">SMKN 4 Garut</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('home') ? 'active' : '' }}">
              <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            @role('admin')
    <!-- Master Data Section Header -->
                        <li class="menu-header small text-uppercase">
                          <span class="menu-header-text">Master Data</span>
                        </li>

                        <!-- Master Data Items -->
                        <li class="menu-item {{ Request::routeIs('users.index') ? 'active' : '' }}">
                          <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-users"></i>
                            <div data-i18n="Tables">Staff</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('students.index') ? 'active' : '' }}">
                          <a href="{{ route('students.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-graduate"></i>
                            <div data-i18n="Tables">Siswa</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('majors.index') ? 'active' : '' }}">
                          <a href="{{ route('majors.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-book"></i>
                            <div data-i18n="Tables">Jurusan</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('school_classes.index') ? 'active' : '' }}">
                          <a href="{{ route('school_classes.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-chalkboard-teacher"></i>
                            <div data-i18n="Tables">Kelas</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('subject_types.index') ? 'active' : '' }}">
                          <a href="{{ route('subject_types.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-pencil-alt"></i>
                            <div data-i18n="Tables">Jenis Mata Pelajaran</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('subjects.index') ? 'active' : '' }}">
                          <a href="{{ route('subjects.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-book-open"></i>
                            <div data-i18n="Tables">Mata Pelajaran</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('entry-years.index') ? 'active' : '' }}">
                          <a href="{{ route('entry-years.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-calendar-plus"></i>
                            <div data-i18n="Tables">Tahun Masuk</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('graduation-years.index') ? 'active' : '' }}">
                          <a href="{{ route('graduation-years.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-calendar-check"></i>
                            <div data-i18n="Tables">Tahun Lulus</div>
                          </a>
                        </li>

                        <!-- Apps Section Header -->
                        <li class="menu-header small text-uppercase">
                          <span class="menu-header-text">Buku Induk Nilai</span>
                        </li>

                        <li class="menu-item {{ Request::routeIs('manage-subject-and-major.index') ? 'active' : '' }}">
                          <a href="{{ route('manage-subject-and-major.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-list"></i>
                            <div data-i18n="Tables">Manage Jurusan & Mata Pelajaran</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('manage-grades.index') ? 'active' : '' }}">
                          <a href="{{ route('manage-grades.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-graduation-cap"></i>
                            <div data-i18n="Tables">Manage Nilai</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('students.exports') ? 'active' : '' }}">
                          <a href="{{ route('students.exports') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-file-export"></i>
                            <div data-i18n="Tables">Export Siswa</div>
                          </a>
                        </li>
                      </ul>
@endrole
            @role('student_affairs_staff')
    <!-- Apps Section Header -->
                        <li class="menu-header small text-uppercase">
                          <span class="menu-header-text">Buku Induk Nilai</span>
                        </li>

                        <li class="menu-item {{ Request::routeIs('manage-grades.index') ? 'active' : '' }}">
                          <a href="{{ route('manage-grades.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-graduation-cap"></i>
                            <div data-i18n="Tables">Manage Nilai</div>
                          </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('students.exports') ? 'active' : '' }}">
                          <a href="{{ route('students.exports') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-file-export"></i>
                            <div data-i18n="Tables">Export Siswa</div>
                          </a>
                        </li>
                    {{-- <li class="menu-item {{ Request::routeIs('students.exports') ? 'active' : '' }}">
                        <a href="{{ route('students.exports') }}" class="menu-link">
                        <i class="menu-icon fa-solid fa-file-export"></i>
                        <div data-i18n="Tables">Buku Induk Nilai</div>
                        </a>
                    </li> --}}
                      </ul>
@endrole

        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/ArvinAjifTechnology"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star Arvin Muhammad Ajif"
                    >Star</a
                  >
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('') }}assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset('') }}assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li> --}}
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper mt-4">
            <!-- Content -->


            @yield('content')
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  © 1968-
                  <script>
                      document.write(new Date().getFullYear());
                  </script>
                  , Dibuat Dengan ❤️ by 2106100 Arvin Muhammad Ajif & 2106098 Muthia Mutmainah Aprinelia KP Institut Teknologi Garut &trade; 2024
                  <a href="https://github.com/ArvinAjifTechnology/" target="_blank" class="footer-link fw-bolder"></a>
                </div>
                {{-- <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div> --}}
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    {{-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> --}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#Table');
    </script>
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('') }}assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('') }}assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('') }}assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('') }}assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('') }}assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('') }}assets/js/dashboards-analytics.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });
    </script>

    @if (session('success'))
<script>
    $(document).ready(function() {
        toastr.success('{{ session('success') }}', 'Success');
    });
</script>
@endif

    @if (session('error'))
<script>
    $(document).ready(function() {
        toastr.error('{{ session('error') }}', 'Error');
    });
</script>
@endif

<!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('js')
</body>
</html>
