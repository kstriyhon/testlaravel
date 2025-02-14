<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Schedule</title>
</head>
<body>
    <h1>TV Schedule</h1>

    <form action="{{ route('tv_schedules.store') }}" method="POST">
        @csrf
        <textarea name="schedule_data" rows="10" cols="50" placeholder="Paste schedule text here..."></textarea>
        <button type="submit">Upload</button>
    </form>

    <h2>Schedule List</h2>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
        @foreach($schedules as $schedule)
            <tr>
                <td>{{ $schedule->date }}</td>
                <td>{{ $schedule->time }}</td>
                <td>{{ $schedule->title }}</td>
                <td>{{ $schedule->description }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
