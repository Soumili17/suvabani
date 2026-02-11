<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | SUVABANI Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN for simplicity -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .sidebar { min-height: 100vh; background:#008080; color:white; }
        .sidebar a { display:block; padding:10px 15px; color:white; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active { background:#006666; text-decoration:none; }
        .topbar { background:#f8f8f8; padding:10px 20px; border-bottom:1px solid #ddd; }
        .content { padding:20px; }
    </style>
</head>
<body class="flex">

    <!-- Sidebar -->
    <div class="sidebar w-64">
        <h2 class="text-2xl font-bold p-4 border-b border-teal-500">Admin Panel</h2>
        <nav class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home mr-2"></i> Dashboard</a>
            <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}"><i class="fas fa-users mr-2"></i> Members</a>
            <a href="{{ route('admin.invoices') }}" class="{{ request()->routeIs('admin.invoices*') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar mr-2"></i> Invoices</a>
            <a href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1">
        <div class="topbar flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title')</h1>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>
