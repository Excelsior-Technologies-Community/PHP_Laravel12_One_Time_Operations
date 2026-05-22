{{-- C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\resources\views\operations\index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Operations Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
            font-weight: normal;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
        }

        .stat-title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .stat-unit {
            font-size: 12px;
            color: #666;
        }

        /* Cards */
        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .card-header {
            background: #fafafa;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-title {
            font-size: 18px;
            color: #333;
            font-weight: normal;
        }

        .card-body {
            padding: 15px;
            overflow-x: auto;
        }

        /* Buttons */
        .btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 3px;
            cursor: pointer;
            font-size: 13px;
            background: white;
            color: #333;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #f0f0f0;
        }

        .btn-primary {
            background: #0066cc;
            border-color: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #0052a3;
        }

        .btn-success {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-warning {
            background: #ffc107;
            border-color: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-sm {
            padding: 3px 8px;
            font-size: 12px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fafafa;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        tr:hover {
            background: #f9f9f9;
        }

        /* Status Badges */
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            display: inline-block;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Alerts */
        .alert {
            padding: 10px 15px;
            border-radius: 3px;
            margin-bottom: 15px;
            border-left: 3px solid;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            max-width: 450px;
            width: 90%;
        }

        .modal-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: normal;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 500;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 13px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0066cc;
        }

        /* Pagination */
        .pagination {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 5px 10px;
            border: 1px solid #ddd;
            color: #0066cc;
            text-decoration: none;
            font-size: 13px;
        }

        .pagination span.active {
            background: #0066cc;
            color: white;
            border-color: #0066cc;
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #666;
        }

        .mt-20 {
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .card-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            table {
                font-size: 12px;
            }
            
            td, th {
                padding: 6px;
            }
            
            .btn {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Operations Dashboard</h1>
            <p class="subtitle">Manage one-time database operations</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                [Success] {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                [Error] {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                [Info] {{ session('info') }}
            </div>
        @endif

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Operations</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Completed</div>
                <div class="stat-value" style="color: #28a745;">{{ $stats['completed'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Pending</div>
                <div class="stat-value" style="color: #ffc107;">{{ $stats['pending'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Success Rate</div>
                <div class="stat-value">{{ $stats['success_rate'] }}<span class="stat-unit">%</span></div>
            </div>
        </div>

        <!-- Operations Table -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">One-Time Operations</div>
                <div>
                    <button class="btn btn-primary" onclick="openModal()">+ New Operation</button>
                    <form action="{{ route('operations.execute-pending') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Run All Pending</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($operations->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Operation</th>
                                <th>Status</th>
                                <th>Executed At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operations as $op)
                                <tr>
                                    <td>
                                        <code>{{ $op->operation }}</code>
                                    </td>
                                    <td>
                                        @if($op->ran_at)
                                            <span class="status status-completed">Completed</span>
                                        @else
                                            <span class="status status-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($op->ran_at)
                                            {{ \Carbon\Carbon::parse($op->ran_at)->format('Y-m-d H:i:s') }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$op->ran_at)
                                            <form action="{{ route('operations.execute', $op->operation) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Run</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('operations.delete', $op->operation) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this operation?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-muted">No operations found. Click "New Operation" to create one.</p>
                @endif
            </div>
        </div>

        <!-- Execution Logs -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Execution Logs</div>
                @if($logs->count() > 0)
                    <form action="{{ route('logs.clear') }}" method="POST" onsubmit="return confirm('Clear all logs?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">Clear All Logs</button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                @if($logs->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Operation</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Executed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->operation_name }}</td>
                                    <td>
                                        <span class="status status-{{ $log->status }}">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->message ?? '--' }}</td>
                                    <td>{{ $log->executed_at ? \Carbon\Carbon::parse($log->executed_at)->format('Y-m-d H:i:s') : '--' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if(method_exists($logs, 'links'))
                        <div class="pagination">
                            {{ $logs->links() }}
                        </div>
                    @endif
                @else
                    <p class="text-center text-muted">No execution logs found</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Operation Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Operation</h3>
            </div>
            <form action="{{ route('operations.create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Operation Name</label>
                    <input type="text" name="operation_name" required placeholder="e.g., cleanup_sessions" autocomplete="off">
                    <small style="color: #666; font-size: 11px;">Use lowercase letters and underscores</small>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('createModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('createModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('createModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) alert.remove();
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>