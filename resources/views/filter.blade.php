<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar programas por fechas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Filtra los programas por rango de fechas</h1>

    <!-- Filter Form -->
    <form action="{{ route('filter.programs') }}" method="GET">
        @csrf
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>

        <button type="submit">Filtrar</button>
    </form>

    <!-- Display Results -->
    @if (isset($programs) && isset($startDate) && isset($endDate))
        <h2>programas entre las fechas {{ $startDate }} to {{ $endDate }}</h2>
        @if ($programs->isEmpty())
            <p>No se encontro ningun programa en ese rango de fechas.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $program)
                        <tr>
                            <td>{{ $program->date }}</td>
                            <td>{{ $program->time }}</td>
                            <td>{{ $program->title }}</td>
                            <td>{{ $program->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- View XML Button -->
       
<form action="{{ route('filter.programs') }}" method="GET" style="margin-top: 20px;">
    <input type="hidden" name="start_date" value="{{ $startDate }}">
    <input type="hidden" name="end_date" value="{{ $endDate }}">
    <input type="hidden" name="view_xml" value="true">
    <button type="submit">View XML</button>
</form>
        @endif
    @endif
</body>
</html>