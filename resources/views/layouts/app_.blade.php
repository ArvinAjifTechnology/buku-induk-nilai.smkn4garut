<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('css')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- start sidebar section -->
                <div :class="{ 'dark text-white-dark': $store.app.semidark }">
                    <nav x-data="sidebar"
                        class="sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
                        <div class="h-full bg-white dark:bg-[#0e1726]">
                            <div class="flex items-center justify-between px-4 py-3">
                                <a href="index.html" class="main-logo flex shrink-0 items-center">
                                    <img class="ml-[5px] w-8 flex-none" src="assets/images/logo.png" alt="image">
                                    <span
                                        class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">SKMN
                                        4 Garut</span>
                                </a>
                                <a href="javascript:;"
                                    class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                                    @click="$store.app.toggleSidebar()">
                                    <svg class="m-auto h-5 w-5" width="20" height="20" viewbox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            </div>
                            <ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
                                x-data="{ activeDropdown: null }">

                                <h2
                                    class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                    <svg class="hidden h-5 w-4 flex-none" viewbox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span>Master Data</span>
                                </h2>

                                <!-- Menu Items with Icons -->
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Users</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('students.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Siswa</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('majors.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Jurusan</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('school_classes.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Kelas</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('manage-grades.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Nilai</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('subjects.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Mata
                                            Pelajaran</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('entry-years.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Tahun
                                            Masuk</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('graduation-years.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Tahun
                                            Lulus</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('list-subjects.index') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Daftar
                                            Mata Pelajaran</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('students.exports') }}" class="group flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                            viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Export
                                            Siswa</span>
                                    </a>
                                </li>

                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="group flex items-center">
                                            <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                                                viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span
                                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Login</span>
                                        </a>
                                    </li>
                                @endguest

                                @auth
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endauth

                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- end sidebar section -->

            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>


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
    <script>
        $(document).ready(function() {
            $('#Table').DataTable();
        });
    </script>

</body>

</html>
