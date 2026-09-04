<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation Complete</title>
    <style>body{font-family:system-ui,-apple-system,Segoe UI,sans-serif;background:#f8fafc;margin:0;color:#0f172a}.wrap{max-width:680px;margin:80px auto;padding:24px}.card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:32px;box-shadow:0 10px 30px #0f172a12}a{display:inline-block;margin-top:18px;padding:12px 18px;background:#2563eb;color:#fff;text-decoration:none;border-radius:8px;font-weight:700}</style>
</head>
<body>
<div class="wrap"><div class="card">
    <h1>Installation complete</h1>
    <p>Your Project Management System has been installed successfully.</p>
    <p>Super Administrator: <strong>{{ $email }}</strong></p>
    <p>Sign in from the application using the administrator credentials you entered during installation.</p>
    <a href="{{ $appUrl }}">Open Application</a>
</div></div>
</body>
</html>
