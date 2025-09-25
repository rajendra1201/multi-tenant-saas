<!DOCTYPE html>
<html lang="en" data-theme="{{ \$tenant->theme ?? 'default' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \$tenant->business_name ?? 'Dashboard' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @if(isset(\$tenant))
            {!! app(\App\Services\ThemeService::class)->generateThemeCSS(\$tenant) !!}
        @endif
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    @if(isset(\$tenant) && \$tenant->logo_path)
                        <img src="{{ Storage::url(\$tenant->logo_path) }}" alt="Logo" class="h-8 w-auto">
                    @endif
                    <h1 class="ml-3 text-xl font-semibold text-gray-900">{{ \$tenant->business_name ?? 'Business' }}</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('products.*') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-box mr-1"></i> Products
                    </a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('services.*') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-concierge-bell mr-1"></i> Services
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('blog.*') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-blog mr-1"></i> Blog
                    </a>
                    <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('offers.*') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-tags mr-1"></i> Offers
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')
</body>
</html>
