<div class="grid grid-cols-1 md:grid-cols-2  gap-6 mb-8">
    <!-- Enrolled Courses Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 rounded-full">
                <i class="ri-book-open-line text-2xl text-emerald-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Enrolled Courses</h3>
                <p class="text-2xl font-bold text-emerald-600"><?= $this->studentModel->getCount();?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Summary</h2>
    <div class="flex items-center space-x-4">
        
        <div>
            <h3 class="text-lg font-medium text-gray-700"><?= $this->studentModel->getName();?></h3>
            <p class="text-sm text-gray-500"><?= $this->studentModel->getEmail();?></p>
        </div>
    </div>
</div>

</div>

<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Links</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="/student/courses" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100">
            <i class="ri-book-line text-2xl"></i>
            <p class="mt-2">Course Catalog</p>
        </a>
        <a href="/student/my-courses" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100">
            <i class="ri-folder-line text-2xl"></i>
            <p class="mt-2">My Courses</p>
        </a>
        <a href="/student/certificates" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100">
            <i class="ri-file-text-line text-2xl"></i>
            <p class="mt-2">Certificates</p>
        </a>
        <a href="/student/profile" class="bg-gray-50 p-4 rounded-lg text-center text-emerald-600 hover:bg-emerald-100">
            <i class="ri-user-line text-2xl"></i>
            <p class="mt-2">Profile </p>
        </a>
    </div>
</div>
