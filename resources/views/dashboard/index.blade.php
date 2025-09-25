@extends('layouts.tenant')

@section('content')
<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Welcome to {{ \$tenant->business_name }} management panel</p>
    </div>

    @if(!\$tenant->setup_completed)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Your business setup is still in progress. We're generating your assets and setting up your store.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-box text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Products</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ \$stats['products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-concierge-bell text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Services</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ \$stats['services'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <i class="fas fa-blog text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Blog Posts</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ \$stats['blog_posts'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <i class="fas fa-tags text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Offers</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ \$stats['offers'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Business Information</h3>
            </div>
            <div class="p-6">
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Business Name</dt>
                        <dd class="text-sm text-gray-900">{{ \$tenant->business_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Business Type</dt>
                        <dd class="text-sm text-gray-900">{{ ucwords(str_replace('_', ' ', \$tenant->business_type)) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Owner</dt>
                        <dd class="text-sm text-gray-900">{{ \$tenant->owner_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-sm text-gray-900">{{ \$tenant->owner_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Theme</dt>
                        <dd class="text-sm text-gray-900">{{ ucwords(\$tenant->theme) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('products.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-plus text-blue-500 mr-3"></i>
                        <span class="text-sm text-gray-900">Add Product</span>
                    </a>
                    <a href="{{ route('services.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-plus text-green-500 mr-3"></i>
                        <span class="text-sm text-gray-900">Add Service</span>
                    </a>
                    <a href="{{ route('blog.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-plus text-purple-500 mr-3"></i>
                        <span class="text-sm text-gray-900">Write Blog</span>
                    </a>
                    <a href="{{ route('offers.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-plus text-yellow-500 mr-3"></i>
                        <span class="text-sm text-gray-900">Create Offer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(\$tenant->business_description)
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Business Description</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700">{{ \$tenant->business_description }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
