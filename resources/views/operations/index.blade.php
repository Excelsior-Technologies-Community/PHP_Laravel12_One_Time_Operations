<!DOCTYPE html>
<html>
<head>
    <title>Operations Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 30px;
        }
        h1 {
            text-align: center;
        }
        h2 {
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #222;
            color: #fff;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .failed {
            color: red;
            font-weight: bold;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 12px;
        }
        .completed {
            background: green;
        }
        .pending {
            background: orange;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h1>⚙️ Operations Dashboard</h1>

<div class="card">
    <h2>📌 One-Time Operations Status</h2>

    <table>
        <tr>
            <th>Operation</th>
            <th>Status</th>
            <th>Executed At</th>
        </tr>

        @forelse($operations as $op)
            <tr>
                <td>{{ $op->operation }}</td>
                <td>
                    @if($op->ran_at)
                        <span class="badge completed">Completed</span>
                    @else
                        <span class="badge pending">Pending</span>
                    @endif
                </td>
                <td>{{ $op->ran_at ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align:center;">No operations found</td>
            </tr>
        @endforelse
    </table>
</div>

<div class="card">
    <h2>📊 Execution Logs</h2>

    <table>
        <tr>
            <th>Operation</th>
            <th>Status</th>
            <th>Message</th>
            <th>Executed At</th>
        </tr>

        @forelse($logs as $log)
            <tr>
                <td>{{ $log->operation_name }}</td>

                <td class="{{ $log->status }}">
                    {{ ucfirst($log->status) }}
                </td>

                <td>{{ $log->message }}</td>

                <td>{{ $log->executed_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">No logs found</td>
            </tr>
        @endforelse
    </table>
</div>

</body>
</html>