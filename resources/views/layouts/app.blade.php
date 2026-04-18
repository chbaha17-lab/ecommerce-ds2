<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bloom Café</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5efe6;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e6d3b3;
        }

        .nav-link {
            color: #6b4f4f !important;
        }

        .btn-beige {
            background: #e6d3b3;
            color: #6b4f4f;
            border: none;
        }

        .btn-beige:hover {
            background: #d9c2a0;
        }

        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<nav class="navbar px-4 py-3 d-flex justify-content-between align-items-center"
     style="background:white; border-bottom:1px solid #e6d3b3;">

    <h4 class="mb-0" style="color:#6b4f4f;">
        ☕ Bloom Café
    </h4>

    <div class="d-flex gap-3">

        <a href="/menu" class="text-decoration-none"
           style="color:#6b4f4f;">
            Menu
        </a>

        <a href="/cart" class="text-decoration-none"
           style="color:#6b4f4f;">
            Cart 🛒
        </a>

        <a href="/dashboard" class="text-decoration-none"
           style="color:#6b4f4f;">
            Admin
        </a>

    </div>

</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>