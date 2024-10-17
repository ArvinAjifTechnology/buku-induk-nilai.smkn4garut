@extends('layouts.authentication')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div
                    class="relative flex min-h-screen items-center justify-center bg-[url(../images/auth/map.png)] bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">

                    <!-- Struktur Card untuk Nama Sekolah, Logo, dan Nama Aplikasi -->
                    <div
                        class="relative w-full max-w-[870px] rounded-md bg-[linear-gradient(45deg,#fff9f9_0%,rgba(255,255,255,0)_25%,rgba(255,255,255,0)_75%,_#fff9f9_100%)] p-2 dark:bg-[linear-gradient(52.22deg,#0E1726_0%,rgba(14,23,38,0)_18.66%,rgba(14,23,38,0)_51.04%,rgba(14,23,38,0)_80.07%,#0E1726_100%)]">
                        <div
                            class="relative flex flex-col items-center justify-center rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 px-6 lg:min-h-[758px] py-20">
                            {{-- @if (session('error'))
                                <div class="card border-danger mb-3">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-exclamation-circle"></i> Error
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif --}}
                            <!-- Bagian Logo dan Nama Sekolah di dalam Card -->
                            <div class="text-center mb-10">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo SMKN 4 Garut"
                                    class="h-20 mx-auto mb-4">
                                <h1 class="text-3xl font-extrabold uppercase !leading-snug text-success">Buku Induk Nilai
                                </h1>
                                <p class="text-xl font-semibold leading-normal text-white-dark">SMKN 4 Garut</p>
                            </div>

                            <div class="mx-auto w-full max-w-[440px]">
                                <div class="mb-10 text-left">
                                    <h2 class="text-3xl font-extrabold uppercase !leading-snug text-primary md:text-4xl">
                                        Masuk
                                    </h2>
                                    <p class="text-base font-bold leading-normal text-white-dark">
                                        Masukkan email dan kata sandi untuk masuk
                                    </p>
                                </div>

                                <!-- Form Login -->
                                <form class="space-y-5 dark:text-white" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div>
                                        <label for="Email">Email</label>
                                        <div class="relative text-white-dark">
                                            <input id="Email" name="email" type="email" placeholder="Masukkan Email"
                                                class="form-input ps-10 placeholder:text-white-dark"
                                                @error('email') is-invalid @enderror name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                                <svg width="18" height="18" viewbox="0 0 18 18" fill="none">
                                                    <path opacity="0.5"
                                                        d="M10.65 2.25H7.35C4.23873 2.25 2.6831 2.25 1.71655 3.23851C0.75 4.22703 0.75 5.81802 0.75 9C0.75 12.182 0.75 13.773 1.71655 14.7615C2.6831 15.75 4.23873 15.75 7.35 15.75H10.65C13.7613 15.75 15.3169 15.75 16.2835 14.7615C17.25 13.773 17.25 12.182 17.25 9C17.25 5.81802 17.25 4.22703 16.2835 3.23851C15.3169 2.25 13.7613 2.25 10.65 2.25Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M14.3465 6.02574C14.609 5.80698 14.6445 5.41681 14.4257 5.15429C14.207 4.89177 13.8168 4.8563 13.5543 5.07507L11.7732 6.55931C11.0035 7.20072 10.4691 7.6446 10.018 7.93476C9.58125 8.21564 9.28509 8.30993 9.00041 8.30993C8.71572 8.30993 8.41956 8.21564 7.98284 7.93476C7.53168 7.6446 6.9973 7.20072 6.22761 6.55931L4.44652 5.07507C4.184 4.8563 3.79384 4.89177 3.57507 5.15429C3.3563 5.41681 3.39177 5.80698 3.65429 6.02574L5.4664 7.53583C6.19764 8.14522 6.79033 8.63914 7.31343 8.97558C7.85834 9.32604 8.38902 9.54743 9.00041 9.54743C9.6118 9.54743 10.1425 9.32604 10.6874 8.97558C11.2105 8.63914 11.8032 8.14522 12.5344 7.53582L14.3465 6.02574Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="Password">Password</label>
                                        <div class="relative text-white-dark">
                                            <input id="Password" type="password" placeholder="Masukkan Password"
                                                class="form-input ps-10 placeholder:text-white-dark"
                                                @error('password') is-invalid @enderror" name="password" required
                                                autocomplete="current-password">
                                            <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                                <svg width="18" height="18" viewbox="0 0 18 18" fill="none">
                                                    <path opacity="0.5"
                                                        d="M1.5 12C1.5 9.87868 1.5 8.81802 2.15901 8.15901C2.81802 7.5 3.87868 7.5 6 7.5H12C14.1213 7.5 15.182 7.5 15.841 8.15901C16.5 8.81802 16.5 9.87868 16.5 12C16.5 14.1213 16.5 15.182 15.841 15.841C15.182 16.5 14.1213 16.5 12 16.5H6C3.87868 16.5 2.81802 16.5 2.15901 15.841C1.5 15.182 1.5 14.1213 1.5 12Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M6 12.75C6.41421 12.75 6.75 12.4142 6.75 12C6.75 11.5858 6.41421 11.25 6 11.25C5.58579 11.25 5.25 11.5858 5.25 12C5.25 12.4142 5.58579 12.75 6 12.75Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M9 12.75C9.41421 12.75 9.75 12.4142 9.75 12C9.75 11.5858 9.41421 11.25 9 11.25C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M12.75 12C12.75 12.4142 12.4142 12.75 12 12.75C11.5858 12.75 11.25 12.4142 11.25 12C11.25 11.5858 11.5858 11.25 12 11.25C12.4142 11.25 12.75 11.5858 12.75 12Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M5.0625 6C5.0625 3.82538 6.82538 2.0625 9 2.0625C11.1746 2.0625 12.9375 3.82538 12.9375 6V7.50268C13.363 7.50665 13.7351 7.51651 14.0625 7.54096V6C14.0625 3.20406 11.7959 0.9375 9 0.9375C6.20406 0.9375 3.9375 3.20406 3.9375 6V7.54096C4.26488 7.51651 4.63698 7.50665 5.0625 7.50268V6Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="flex cursor-pointer items-center">
                                            <input type="checkbox" class="form-checkbox bg-white dark:bg-black"
                                                name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="text-white-dark">Remember Me</span>
                                        </label>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-gradient !mt-6 w-full border-0 uppercase shadow-[0_10px_20px_-10px_rgba(67,97,238,0.44)]">
                                        Masuk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif
    @endsection
