<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Schedule</title>
</head>
<body>
    <h1>TV Schedule</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td>{{ $entry->date }}</td>
                    <td>{{ $entry->time }}</td>
                    <td>{{ $entry->title }}</td>
                    <td>{{ $entry->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('uploads.index') }}">Back</a>
</body>
</html>
