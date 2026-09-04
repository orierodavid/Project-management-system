<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Install Project Management System</title>
    <style>
        body{font-family:system-ui,-apple-system,Segoe UI,sans-serif;background:#f8fafc;margin:0;color:#0f172a}.wrap{max-width:760px;margin:40px auto;padding:24px}.card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:28px;box-shadow:0 10px 30px #0f172a12}h1{margin-top:0}h2{font-size:18px;margin-top:28px}label{display:block;font-weight:600;margin:14px 0 6px}input{width:100%;box-sizing:border-box;padding:11px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:15px}button{margin-top:24px;padding:12px 18px;border:0;border-radius:8px;background:#2563eb;color:#fff;font-weight:700;cursor:pointer}.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.error{background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px}@media(max-width:640px){.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Project Management System</h1>
        <p>Local installation wizard for your XAMPP environment.</p>

        @if ($errors->any())
            <div class="error">
                <strong>Installation could not continue.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/install') }}">
            @csrf
            <h2>Application</h2>
            <label for="app_name">Application name</label>
            <input id="app_name" name="app_name" value="{{ old('app_name', $defaults['app_name']) }}" required>

            <label for="app_url">Application URL</label>
            <input id="app_url" name="app_url" value="{{ old('app_url', $defaults['app_url']) }}" required>

            <label for="timezone">Timezone</label>
            <input id="timezone" name="timezone" value="{{ old('timezone', $defaults['timezone']) }}" required>

            <h2>MySQL database</h2>
            <div class="grid">
                <div><label for="db_host">Host</label><input id="db_host" name="db_host" value="{{ old('db_host', $defaults['db_host']) }}" required></div>
                <div><label for="db_port">Port</label><input id="db_port" name="db_port" value="{{ old('db_port', $defaults['db_port']) }}" required></div>
                <div><label for="db_database">Database</label><input id="db_database" name="db_database" value="{{ old('db_database', $defaults['db_database']) }}" required></div>
                <div><label for="db_username">Username</label><input id="db_username" name="db_username" value="{{ old('db_username', $defaults['db_username']) }}" required></div>
            </div>
            <label for="db_password">Password</label>
            <input id="db_password" type="password" name="db_password" value="{{ old('db_password') }}">

            <h2>Super Administrator</h2>
            <label for="admin_name">Name</label>
            <input id="admin_name" name="admin_name" value="{{ old('admin_name', $defaults['admin_name']) }}" required>

            <label for="admin_email">Email</label>
            <input id="admin_email" type="email" name="admin_email" value="{{ old('admin_email', $defaults['admin_email']) }}" required>

            <label for="admin_password">Password</label>
            <input id="admin_password" type="password" name="admin_password" minlength="8" required>

            <button type="submit">Install Application</button>
        </form>
    </div>
</div>
</body>
</html>
