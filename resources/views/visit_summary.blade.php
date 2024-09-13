<!DOCTYPE html>
<html>
<head>
    <title>Visit Summary Report</title>
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
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Visit Summary Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Current Stage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visits as $visit)
                <tr>
                    <td>{{ $visit->id }}</td>
                    <td>{{ $visit->patient->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($visit->check_in_time)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($visit->check_out_time)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $visit->current_stage }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
