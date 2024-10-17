@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1><i class="fas fa-calendar-alt"></i> Tahun Masuk</h1>
                        <a href="{{ route('entry-years.create') }}" class="btn btn-primary float-right">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Entry Year Table -->
                        <table class="table table-bordered" id="Table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><i class="fas fa-calendar"></i> Tahun</th>
                                    <th><i class="fas fa-tools"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryYears as $entryYear)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $entryYear->year }}</td>
                                        <td>
                                            <a href="{{ route('entry-years.edit', $entryYear) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- <!-- Button Hapus dengan SweetAlert -->
                                            <button class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ $entryYear->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button> --}}

                                            <!-- Form Delete -->
                                            {{-- <form id="delete-form-{{ $entryYear->id }}"
                                                action="{{ route('entry-years.destroy', $entryYear->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form> --}}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <!-- Pagination (if needed) -->
                        <div class="d-flex justify-content-center">
                            {{ $entryYears->links() }}
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form for deletion
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <!-- Success Notification -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Error Notification -->
    @if ($errors->any())
        <script>
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endpush
