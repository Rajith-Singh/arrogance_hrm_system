<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: red;
        }
        .employee-details {
            text-align: center;
            margin-bottom: 30px;
        }
        .employee-details p {
            margin: 0;
        }
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
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Leave Report</h1>
    </div>
    <div class="employee-details">
        <p>Employee ID: {{ $employee->emp_no }}</p>
        <p>Employee Name: {{ $employee->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->start_date }}</td>
                    <td>{{ $record->end_date }}</td>
                    <td>{{ $record->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
