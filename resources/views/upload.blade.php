<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Store Data</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .output { background: #f4f4f4; padding: 10px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Text File</h2>

        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>

        @if(isset($tvShows) && count($tvShows) > 0)
            <div class="output">
                <h3>Stored Data:</h3>
                <table>
                    <tr>
                        <th>Time</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                    @foreach($tvShows as $show)
                        <tr>
                            <td>{{ $show->time }}</td>
                            <td>{{ $show->title }}</td>
                            <td>{{ $show->description }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
</body>
</html>
