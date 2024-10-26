@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <!-- Tombol Import -->
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload"></i> <i class="fas fa-file-excel"></i> Import Nilai dari E-Raport
                </button>
            </div>
        </div>

        <!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('students-grades-e-raport-preview-import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="fas fa-upload me-2"></i> Import Nilai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="files" class="form-label">
                            <i class="fas fa-file-excel me-2"></i> Upload File Excel (Banyak File)
                        </label>
                        <input type="file" name="files[]" class="form-control" required multiple accept=".xlsx, .xls">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i> Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i> Preview
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


        <div class="row">
            @foreach ($entryYears as $entryYear)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Card Title with Icon -->
                            <h5 class="card-title">
                                <i class="fas fa-calendar-alt"></i> {{ $entryYear->year }}
                            </h5>
                            <!-- Button with Icon -->
                            <a href="{{ route('manage-grades.school-classes', $entryYear->uniqid) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Daftar Kelas
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
