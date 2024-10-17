<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                        <h5 class="text-nowrap mb-2">Pertumbuhan Siswa</h5>
                        <span class="badge bg-label-warning rounded-pill">5 Tahun Terakhir</span>
                    </div>
                    <!-- Chart Pertumbuhan Siswa -->
                    <div class="chart-container">
                        <div id="chart">
                            {!! $studentGrowthChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
