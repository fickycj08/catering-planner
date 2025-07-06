<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Summary</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h1>Analytics Summary</h1>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Revenue</th>
                <th>Orders</th>
                <th>New Customers</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlyData as $row)
                <tr>
                    <td>{{ $row['month'] }}</td>
                    <td>{{ $row['revenue'] }}</td>
                    <td>{{ $row['orders'] }}</td>
                    <td>{{ $row['customers'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
