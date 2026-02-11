<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') | SUVABANI Admin</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
    body { font-family: 'Segoe UI', sans-serif; }
    .sidebar a.active { background-color: #006666; }
    .stat-box { background-color: #008080; color: #fff; padding: 1rem; border-radius: 0.5rem; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
    th { background-color: #f0f8f8; }
</style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="sidebar w-64 bg-teal-600 text-white p-5">
        <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded hover:bg-teal-700 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home mr-2"></i> Dashboard</a>
            <a href="{{ route('admin.members') }}" class="px-3 py-2 rounded hover:bg-teal-700 {{ request()->routeIs('admin.members*') ? 'active' : '' }}"><i class="fas fa-users mr-2"></i> Members</a>
            <a href="{{ route('admin.invoices') }}" class="px-3 py-2 rounded hover:bg-teal-700 {{ request()->routeIs('admin.invoices*') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar mr-2"></i> Invoices</a>
            <a href="{{ route('admin.logout') }}" class="px-3 py-2 rounded hover:bg-teal-700"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="text-3xl font-bold mb-6">@yield('title')</h1>
        <div>
            @yield('content')
        </div>
    </div>

</body>
</html>
