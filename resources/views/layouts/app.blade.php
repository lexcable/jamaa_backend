<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supermarket Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 text-white">

    @include('layouts.sidebar')

    <div class="ml-64 p-6">
        @yield('content')
    </div>

</body>
</html>
