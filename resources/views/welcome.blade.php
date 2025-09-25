@extends('layouts.app')

@section('title', 'Welcome to Multi-Tenant SaaS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Multi-Tenant SaaS</h1>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-gray-900">How It Works</a>
                    <a href="/create-business" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Get Started</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-bold text-gray-900 mb-6">
                Launch Your Business in <span class="text-blue-600">Minutes</span>
            </h2>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Create a professional multi-tenant SaaS application with automated onboarding, 
                AI-powered asset generation, and business-specific themes.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="/create-business" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                    Start Free Trial
                </a>
                <a href="#how-it-works" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Everything You Need</h3>
                <p class="text-xl text-gray-600">Powerful features to help you build and manage your business</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-robot text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">AI Chatbot Onboarding</h4>
                    <p class="text-gray-600">Guided setup process with intelligent chatbot assistance</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-magic text-2xl text-green-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Auto Asset Generation</h4>
                    <p class="text-gray-600">AI-powered logos, banners, and business descriptions</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-2xl text-purple-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Dynamic Themes</h4>
                    <p class="text-gray-600">Business-specific themes and customization options</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-store text-2xl text-yellow-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Multi-Business Support</h4>
                    <p class="text-gray-600">Gym, Kirana, Clothing, Restaurant, Salon & more</p>
                </div>

                <div class="text-center">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cogs text-2xl text-red-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Complete Management</h4>
                    <p class="text-gray-600">Products, services, blog, offers management</p>
                </div>

                <div class="text-center">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cloud text-2xl text-indigo-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Multi-Tenant</h4>
                    <p class="text-gray-600">Isolated tenants with custom subdomains</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h3>
                <p class="text-xl text-gray-600">Get your business online in just 3 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h4 class="text-xl font-semibold mb-2">Chat with AI</h4>
                    <p class="text-gray-600">Tell our AI assistant about your business type, name, and basic details</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h4 class="text-xl font-semibold mb-2">Auto Setup</h4>
                    <p class="text-gray-600">AI generates your logo, banner, description, and sets up your products</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h4 class="text-xl font-semibold mb-2">Go Live</h4>
                    <p class="text-gray-600">Access your custom dashboard and start managing your business</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h3>
            <p class="text-xl text-blue-100 mb-8">Join thousands of businesses already using our platform</p>
            <a href="/create-business" class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                Create Your Business Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Multi-Tenant SaaS. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection
