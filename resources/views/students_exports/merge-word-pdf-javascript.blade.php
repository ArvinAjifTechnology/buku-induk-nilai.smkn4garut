<h1>Upload Files to Merge</h1>
<form action="/merge" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="files[]" accept=".docx" multiple required>
    <br><br>
    <button type="submit">Merge Files</button>
</form>
