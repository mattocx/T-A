<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .group:hover .child-btn {
            display: flex;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="relative group">
        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition">
            Login
        </button>

        <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-3 space-y-2 hidden child-btn">
            <a href="/dashboard/login" class="block px-6 py-3 bg-red-500 text-white rounded-lg shadow-lg hover:bg-red-600 transition">
                Admin
            </a>
            <a href="sales/login" class="block px-6 py-3 bg-green-500  text-white rounded-lg shadow-lg hover:bg-green-600 transition">
                Sales
            </a>
            <a href="customer/login" class="block px-6 py-3 bg-yellow-500 text-white rounded-lg shadow-lg hover:bg-yellow-600 transition">
                Customer
            </a>
        </div>
    </div>
</body>
</html>
