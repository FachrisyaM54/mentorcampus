<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>MentorCampus Report</title>

    <style>

        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background: #f3f3f3;
        }

    </style>

</head>
<body>

<h1>MentorCampus Dashboard Report</h1>

<hr>

<h2>Summary</h2>

<table>

    <tr>
        <th>Total User</th>
        <td>{{ $totalUser }}</td>
    </tr>

    <tr>
        <th>Total Mentor</th>
        <td>{{ $totalMentor }}</td>
    </tr>

    <tr>
        <th>Total Booking</th>
        <td>{{ $totalBooking }}</td>
    </tr>

    <tr>
        <th>Pending Mentor</th>
        <td>{{ $pendingMentor }}</td>
    </tr>

</table>

<h2>User Distribution</h2>

<table>

    <tr>
        <th>Student</th>
        <th>Mentor</th>
        <th>Admin</th>
    </tr>

    <tr>
        <td>{{ $studentCount }}</td>
        <td>{{ $mentorCount }}</td>
        <td>{{ $adminCount }}</td>
    </tr>

</table>

<h2>Booking Status</h2>

<table>

    <tr>
        <th>Completed</th>
        <th>Ongoing</th>
        <th>Cancelled</th>
    </tr>

    <tr>
        <td>{{ $completedBooking }}</td>
        <td>{{ $ongoingBooking }}</td>
        <td>{{ $cancelledBooking }}</td>
    </tr>

</table>

<h2>Booking Per Month</h2>

<table>

    <tr>
        <th>Month</th>
        <th>Total Booking</th>
    </tr>

    @foreach($bookingPerMonth as $item)

        <tr>
            <td>{{ $item->month }}</td>
            <td>{{ $item->total }}</td>
        </tr>

    @endforeach

</table>

</body>
</html>