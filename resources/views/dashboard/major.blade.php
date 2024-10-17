<h1>Dokumentasi Halaman Daftar Jurusan</h1>

    <div class="section">
        <h2>Deskripsi Umum</h2>
        <p>Halaman <strong>Daftar Jurusan</strong> adalah antarmuka yang memungkinkan admin untuk mengelola data jurusan di dalam sistem. Admin dapat melakukan berbagai aksi seperti menambah jurusan, mengimpor data jurusan dari file Excel, mengedit, menghapus, serta melihat detail setiap jurusan yang terdaftar.</p>
    </div>

    <div class="section">
        <h2>Fitur-Fitur Utama</h2>
        <ul>
            <li><strong>Download Template</strong>: Tombol untuk mengunduh template Excel yang dapat digunakan untuk mengimpor data jurusan. Tersedia pada baris berikut:
                <code>&lt;a href="{{ route('majors-template-download') }}" class="btn btn-success"&gt;</code></li>

            <li><strong>Form Import Data</strong>: Formulir yang memungkinkan admin mengunggah file Excel (.xls atau .xlsx) untuk diimpor ke dalam sistem. Dapat ditemukan pada kode berikut:
                <code>&lt;form action="{{ route('majors.import') }}" method="POST" enctype="multipart/form-data"&gt;</code></li>

            <li><strong>Tambah Jurusan</strong>: Tombol untuk menambah jurusan baru melalui form input. Ditempatkan pada:
                <code>&lt;a href="{{ route('majors.create') }}" class="btn btn-primary"&gt;</code></li>

            <li><strong>Tabel Jurusan</strong>: Menampilkan daftar jurusan yang ada dalam bentuk tabel. Admin dapat melakukan aksi berikut pada setiap jurusan:
                <ul>
                    <li><strong>View</strong>: Melihat detail jurusan.</li>
                    <li><strong>Edit</strong>: Mengubah informasi jurusan.</li>
                    <li><strong>Delete</strong>: Menghapus jurusan secara permanen dengan konfirmasi menggunakan SweetAlert.</li>
                </ul>
            </li>
        </ul>
    </div>
