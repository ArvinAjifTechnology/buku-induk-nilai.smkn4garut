<h1>Dokumentasi Halaman Dashboard</h1>

<div class="section">
    <h2>Deskripsi Umum</h2>
    <p>Halaman <strong>Dashboard</strong> adalah antarmuka utama untuk admin dalam aplikasi Buku Induk Nilai SMK 4 Garut. Halaman ini dirancang untuk memberikan informasi dan statistik penting terkait pengelolaan nilai siswa secara efisien.</p>
</div>

<div class="section">
    <h2>Salutation</h2>
    <p>Ketika admin masuk, akan ditampilkan pesan selamat pagi dan alamat email admin sebagai pengantar:</p>
    <blockquote>
        <p>Holaa, Selamat Pagi, {{ auth()->user()->email }}!<br>
        Selamat datang di Website Buku Induk Nilai SMK 4 Garut.</p>
    </blockquote>
</div>

<div class="section">
    <h2>Fitur Utama</h2>
    <ul>
        <li><strong>View Badge User</strong>: Menampilkan badge pengguna yang menunjukkan status atau peran pengguna dalam aplikasi.</li>
        <li><strong>Informasi Jumlah Siswa dan Kelas</strong>:
            <ul>
                <li>Jumlah Siswa</li>
                <li>Jumlah Jurusan</li>
                <li>Jumlah Kelas</li>
                <li>Jumlah Pelajaran</li>
                <li>Jumlah Angkatan</li>
                <li>Jumlah Staff</li>
            </ul>
        </li>
        <li><strong>Distribusi Gender</strong>: Grafik yang menunjukkan distribusi gender siswa dalam 3 tahun terakhir.</li>
        <li><strong>Pertumbuhan Siswa</strong>: Grafik yang menampilkan pertumbuhan jumlah siswa selama 5 tahun terakhir.</li>
        <li><strong>Filter Data</strong>: Admin dapat memfilter data berdasarkan:
            <ul>
                <li>Tahun Masuk</li>
                <li>Jurusan</li>
            </ul>
        </li>
        <li><strong>Statistik Nilai per Mata Pelajaran</strong>: Menampilkan statistik terkait nilai siswa per mata pelajaran.</li>
        <li><strong>Status Nilai Mata Pelajaran per Kelas</strong>: Menampilkan status nilai untuk setiap kelas berdasarkan filter yang diterapkan.</li>
    </ul>
</div>
