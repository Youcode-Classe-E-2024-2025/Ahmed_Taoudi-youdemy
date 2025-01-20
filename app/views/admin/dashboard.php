<!-- Main Content -->
<div class="">

    <div class="container mx-auto p-6">
    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3  gap-6 mb-8">
        <!-- Total Courses Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 rounded-full">
                    <i class="ri-book-open-line text-2xl text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Courses</h3>
                    <p class="text-2xl font-bold text-emerald-600">15</p>
                </div>
            </div>
        </div>

        <!-- total Students Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-50 rounded-full">
                    <i class="ri-user-line text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Teachers</h3>
                    <p class="text-2xl font-bold text-blue-600">120</p>
                </div>
            </div>
        </div>
        <!-- total Students Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-50 rounded-full">
                    <i class="ri-user-line text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Students</h3>
                    <p class="text-2xl font-bold text-blue-600">120</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Activities -->
    

    <!-- Quick Links -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Links</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/admin/courses" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100 transition-colors duration-200">
                <i class="ri-book-line text-2xl"></i>
                <p class="mt-2">Manage Courses</p>
            </a>
            <a href="/admin/users" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100 transition-colors duration-200">
                <i class="ri-user-line text-2xl"></i>
                <p class="mt-2">Manage users</p>
            </a>
            <a href="/admin/tags" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100 transition-colors duration-200">
                <i class="ri-price-tag-3-line text-2xl"></i>
                <p class="mt-2">Manage tags</p>
            </a>
            <a href="/admin/categories" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100 transition-colors duration-200">
                <i class="ri-folder-line text-2xl"></i>
                <p class="mt-2">Manage categories</p>
            </a>
        </div>
    </div>

    <!-- Profile Summary -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Summary</h2>
        <div class="flex items-center space-x-4">
            <div>
            <h3 class="text-lg font-medium text-gray-700"><?= $this->user['name'];?></h3>
            <p class="text-sm text-gray-500"><?= $this->user['email'];?></p>
            </div>
        </div>
    </div>
</div>
</div>
