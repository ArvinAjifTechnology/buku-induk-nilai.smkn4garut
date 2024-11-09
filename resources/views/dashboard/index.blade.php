@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">

    <style>
        /* Container for chart with horizontal scrollbar */
        .chart-container {
            overflow-x: auto;
            overflow-y: auto;
            white-space: nowrap;
            width: 100%;
            padding: 10px;
            /* Reduced padding to minimize gaps */
        }

        /* Set minimum width for chart canvas */
        .chart-container .apexcharts-canvas {
            min-width: 1200px;
        }

        #chart {
            max-width: 100%;
            /* Adjusted to fit within its container */
            margin: 0 auto;
        }
    </style>
    <style>
        .icon-color-primary {
            color: #007bff;
            /* Ganti dengan warna yang diinginkan */
        }

        .icon-color-secondary {
            color: #6c757d;
            /* Ganti dengan warna yang diinginkan */
        }

        .icon-color-success {
            color: #28a745;
            /* Ganti dengan warna yang diinginkan */
        }

        .icon-color-warning {
            color: #ffc107;
            /* Ganti dengan warna yang diinginkan */
        }

        .icon-color-danger {
            color: #dc3545;
            /* Ganti dengan warna yang diinginkan */
        }
    </style>
@endpush

@section('content')
    @php
        $hour = date('H');
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Holaa, {{ $greeting }}, {{ Auth::user()->name }}!
                                </h5>
                                <p class="mb-4">
                                    Selamat datang di Website Buku Induk Nilai SMK 4 Garut. Aplikasi ini dirancang untuk
                                    membantu Anda mengelola dan memantau nilai siswa dengan mudah dan efisien. Gunakan
                                    fitur-fitur yang tersedia untuk memaksimalkan pengalaman Anda.
                                </p>
                                <a href="javascript:;" class="btn btn-sm btn-outline-primary" id="learn-more-btn">Pelajari
                                    Lebih Lanjut</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('') }}assets/img/illustrations/man-with-laptop-light.png"
                                    height="120" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Tabs Section -->
                    <div class="card-body" id="tabs-section" style="display: none;">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard"
                                    role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="staff-tab" data-bs-toggle="tab" href="#staff" role="tab"
                                    aria-controls="staff" aria-selected="false">Staff</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="student-tab" data-bs-toggle="tab" href="#student" role="tab"
                                    aria-controls="student" aria-selected="false">Siswa</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="student-filter-tab" data-bs-toggle="tab" href="#student-filter"
                                    role="tab" aria-controls="student-filter" aria-selected="false">Filter Siswa</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="student-detail-tab" data-bs-toggle="tab" href="#student-detail"
                                    role="tab" aria-controls="student-detail" aria-selected="false">Detail Siswa</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="major-tab" data-bs-toggle="tab" href="#major" role="tab"
                                    aria-controls="major" aria-selected="false">Jurusan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="school-classes-tab" data-bs-toggle="tab" href="#school-classes"
                                    role="tab" aria-controls="school-classes" aria-selected="false">Kelas</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <!-- Profil Tab (Content) -->
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel"
                                aria-labelledby="dashboard-tab">
                                @include('dashboard.dashboard')
                            </div>

                            <!--Staff Tab (Content) -->
                            <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                                @include('dashboard.staff')
                            </div>
                            <!--Siswa Tab (Content) -->
                            <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                                @include('dashboard.student')
                            </div>
                            <!-- Filter Siswa Tab (Content) -->
                            <div class="tab-pane fade" id="student-filter" role="tabpanel"
                                aria-labelledby="student-filter-tab">
                                @include('dashboard.student-filter')
                            </div>
                            <!-- Detail Siswa Tab (Content) -->
                            <div class="tab-pane fade" id="student-detail" role="tabpanel"
                                aria-labelledby="student-detail-tab">
                                @include('dashboard.student-detail')
                            </div>
                            <!-- Jurusan Tab (Content) -->
                            <div class="tab-pane fade" id="major" role="tabpanel" aria-labelledby="major-tab">
                                @include('dashboard.major')
                            </div>
                            <!-- Kelas Tab (Content) -->
                            <div class="tab-pane fade" id="school-classes" role="tabpanel"
                                aria-labelledby="school-classes-tab">
                                @include('dashboard.school-classes')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <!-- Total Students -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-user-graduate fa-2x icon-color-primary"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Siswa</span>
                                <h3 class="card-title mb-2">{{ $studentCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Majors -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-book-open fa-2x icon-color-secondary"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Jurusan</span>
                                <h3 class="card-title mb-2">{{ $majorCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total School Classes -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-chalkboard-teacher fa-2x icon-color-success"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Kelas</span>
                                <h3 class="card-title mb-2">{{ $schoolClassCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subjects -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-book fa-2x icon-color-warning"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Pelajaran</span>
                                <h3 class="card-title mb-2">{{ $subjectCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Entry Years -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-calendar-alt fa-2x icon-color-danger"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Angkatan</span>
                                <h3 class="card-title mb-2">{{ $entryYearCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Total Users -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fas fa-users fa-2x icon-color-primary"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Staff</span>
                                <h3 class="card-title mb-2">{{ $userCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Student Statuses -->
            @include('dashboard.chart.student-statuses')

            <!-- Chart Gender Distribution -->
            @include('dashboard.chart.gender-distribution')

            <!-- Additional Statistics -->
            <div class="col-12 col-md-8 col-lg-4 order-4">
                <div class="row">

                </div>

                <!-- Chart Student Growth -->
                <div class="row">
                    {{-- @include('dashboard.chart.student-growth') --}}
                </div>
            </div>
        </div>

        <!-- Additional Sections -->
        <div class="container">
            <div class="row">
                {{-- @include('dashboard.chart.grades-statistic') --}}
            </div>
        </div>
        <!-- Chart Subject Completion -->
        <div class="row">
            {{-- @include('dashboard.chart.subject-completion') --}}
        </div>
        <div class="row">
            @include('dashboard.chart.grade-range-chart')
        </div>
    </div>
@endsection

@push('js')
    <!-- Script to toggle tab pane visibility -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/larapex-charts@latest/dist/larapex-charts.js"></script>
    <script>
        document.getElementById('learn-more-btn').addEventListener('click', function() {
            var tabsSection = document.getElementById('tabs-section');
            if (tabsSection.style.display === "none") {
                tabsSection.style.display = "block";
            } else {
                tabsSection.style.display = "none";
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM sudah siap.');

            const majorSelect = document.getElementById('major');
            const schoolClassSelect = document.getElementById('school_class');
            const subjectSelect = document.getElementById('subject');

            majorSelect.addEventListener('change', async function() {
                const majorId = this.value;
                console.log('Jurusan dipilih:', majorId);

                if (majorId) {
                    try {
                        const response = await fetch(`/get-classes/${majorId}`);
                        console.log('Status respons:', response.status); // Status fetch

                        // Cek apakah respons berhasil
                        if (!response.ok) throw new Error(`Gagal: ${response.statusText}`);

                        const data = await response.json();
                        console.log('Data kelas yang diterima:', data); // Tampilkan data respons

                        if (data.length === 0) {
                            console.warn('Tidak ada data kelas.');
                            schoolClassSelect.innerHTML = '<option value="">Tidak ada kelas</option>';
                            return; // Keluar jika data kosong
                        }

                        // Isi dropdown kelas
                        let classOptions = '<option value="">-</option>';
                        data.forEach(classItem => {
                            classOptions +=
                                `<option value="${classItem.id}">${classItem.name}</option>`;
                        });

                        schoolClassSelect.innerHTML = classOptions;
                        subjectSelect.innerHTML = '<option value="">-</option>'; // Reset mata pelajaran
                        console.log('Dropdown kelas berhasil diisi.');
                    } catch (error) {
                        console.error('Kesalahan terjadi saat mengambil data:', error);
                    }
                } else {
                    console.log('Jurusan tidak dipilih, mengosongkan dropdown.');
                    schoolClassSelect.innerHTML = '<option value="">-</option>';
                    subjectSelect.innerHTML = '<option value="">-</option>';
                }
            });
        });


        document.getElementById('school_class').addEventListener('change', function() {
            const classId = this.value;
            const entryYearId = document.getElementById('entry_year').value;

            if (classId && entryYearId) {
                fetch(`{{ route('get.subjects', ':id') }}`.replace(':id', classId) +
                        `?entry_year_id=${entryYearId}`)
                    .then(response => response.json())
                    .then(data => {
                        let subjectOptions = '<option value="">-</option>';
                        data.forEach(subject => {
                            subjectOptions += `<option value="${subject.id}">${subject.name}</option>`;
                        });
                        document.getElementById('subject').innerHTML = subjectOptions;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('subject').innerHTML = '<option value="">-</option>';
            }
        });
    </script>

    <!-- JavaScript untuk AJAX -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script></script>
    {{-- {!! $studentGrowthChart->script() !!} --}}
    {{-- {!! $genderDistributionChart->script() !!} --}}
    {{-- {!! $statisticGradeChart->script() !!} --}}
    {{-- {!! $subjectCompletionChart->script() !!} --}}
    {!! $gradeRangeChart->script() !!}
@endpush
