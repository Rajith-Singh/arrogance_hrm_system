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
        <h1>Attendance Report</h1>
    </div>
    <div class="employee-details">
        <p>Employee ID: {{ $employee->emp_no }}</p>
        <p>Employee Name: {{ $employee->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Verify Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->check_in }}</td>
                    <td>{{ $record->check_out }}</td>
                    <td>{{ $record->verify_code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
