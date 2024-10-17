<html>
<head>
    <title>Dokumen PDF</title>
</head>
<body>
    <h1>Dokumen Gabungan</h1>

    <!-- Tampilkan konten teks -->
    <pre>{!! nl2br(e($wordContent)) !!}</pre>

    <!-- Loop untuk menampilkan gambar -->
    @if(!empty($images))
        <h2>Gambar:</h2>
        @foreach($images as $image)
            <img src="{{ $image }}" alt="Dokumen Gambar" style="max-width: 100%; height: auto;">
        @endforeach
    @endif
</body>
</html>
