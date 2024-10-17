<h1>Dokumentasi Halaman Daftar Kelas Sekolah</h1>

    <div class="section">
        <h2>Deskripsi Halaman</h2>
        <p>Halaman <strong>Daftar Kelas Sekolah</strong> dirancang untuk menampilkan daftar kelas yang ada di sekolah. Admin dapat melakukan berbagai tindakan terkait pengelolaan data kelas melalui fitur yang tersedia, seperti melihat detail, menambah kelas baru, mengimpor data dari file Excel, dan menghapus kelas yang sudah ada.</p>
    </div>

    <div class="section">
        <h2>Fitur Halaman</h2>
        <ul>
            <li><strong>Download Template</strong>: Tombol untuk mengunduh template Excel sebagai acuan format impor data kelas. Admin dapat mengklik tombol "Download Template" untuk mengunduh file.</li>
            <li><strong>Import Kelas</strong>: Formulir untuk mengimpor data kelas dari file Excel. Admin dapat memilih file dengan ekstensi `.xls` atau `.xlsx` dan mengunggahnya menggunakan tombol "Import".</li>
            <li><strong>Tambah Kelas Sekolah</strong>: Tombol untuk menambahkan kelas baru. Admin dapat mengklik tombol "Tambah Kelas Sekolah" yang akan mengarahkan ke halaman pembuatan kelas baru.</li>
            <li><strong>Daftar Kelas</strong>: Tabel yang menampilkan daftar kelas yang sudah terdaftar, termasuk nama kelas, jurusan, dan aksi yang bisa dilakukan.</li>
        </ul>
    </div>

    <div class="section">
        <h2>Fitur Aksi Pada Setiap Kelas</h2>
        <ul>
            <li><strong>Lihat Detail</strong>: Tombol <i class="fa-solid fa-eye"></i> untuk melihat detail dari kelas yang dipilih.</li>
            <li><strong>Edit Kelas</strong>: Tombol <i class="fa-solid fa-pencil-alt"></i> untuk mengedit informasi kelas yang sudah terdaftar.</li>
            <li><strong>Hapus Kelas</strong>: Tombol <i class="fa-solid fa-trash"></i> untuk menghapus kelas yang dipilih. Tindakan ini dilengkapi dengan konfirmasi melalui SweetAlert untuk memastikan penghapusan.</li>
        </ul>
    </div>

    <div class="section">
        <h2>Struktur Tabel Daftar Kelas</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>APHP-1</td>
                    <td>Agribisnis Pengolahan Hasil Pertanian</td>
                    <td>
                        <a href="#" class="btn btn-info">Lihat</a>
                        <a href="#" class="btn btn-warning">Edit</a>
                        <a href="#" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <!-- Data kelas lainnya akan ditampilkan di sini -->
            </tbody>
        </table>
    </div>
