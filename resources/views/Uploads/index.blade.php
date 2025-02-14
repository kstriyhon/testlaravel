<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h1>Upload a File</h1>
    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h2>Uploaded Files</h2>
    <ul>
        @foreach($uploads as $upload)
            <li>
                <a href="{{ route('uploads.show', $upload) }}">{{ $upload->filename }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
