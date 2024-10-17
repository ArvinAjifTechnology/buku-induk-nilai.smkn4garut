<div class="col-12 col-lg-8 order-3 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                        <h5 class="text-nowrap mb-2">Distribusi Gender</h5>
                        <span class="badge bg-label-info rounded-pill">3 Tahun Terakhir</span>
                    </div>
                </div>
                <div id="genderDistributionChart">
                    {!! $genderDistributionChart->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>
