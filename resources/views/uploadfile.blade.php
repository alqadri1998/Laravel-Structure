<!DOCTYPE html>
<html>
<body>

<h1>Show a file-select field:</h1>

<h3>Show a file-select field which allows only one file to be chosen:</h3>
<form action="http://localhost:8000/en/admin/upload-image" method="post" enctype="multipart/form-data">
    @csrf
    Select a file: <input type="file" name="image"><br><br>
    <input type="submit">
</form>

</body>
</html>