
    <!-- Course Catalog Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Explore Our Courses
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Find the perfect course for your learning journey.
                </p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-8">
                <!-- Search Bar -->
                <div class="mb-6">
                    <input
                        type="text"
                        id="search"
                        placeholder="Search for a course..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>

                <!-- Category Buttons -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter by Category</h3>
                    <div class="flex flex-wrap gap-2" id="category-buttons">
                        <a href="/student/courses">
                            <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                                All Categories
                            </span>
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <a href="?category=<?= htmlspecialchars($category->getId()) ?>">
                                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                                    <?= htmlspecialchars($category->getName()) ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tags Buttons -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter by Tags</h3>
                    <div class="flex flex-wrap gap-2" id="tag-buttons">
                        <?php foreach ($tags as $tag): ?>
                            <label class="cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="tags"
                                    value="<?= htmlspecialchars($tag->getId()) ?>"
                                    class="hidden" />
                                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                                    <?= htmlspecialchars($tag->getName()) ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div> -->
            </div>

            <!-- Course List -->
            <?php if (!empty($courses)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="course-list">
                    <?php foreach ($courses as $course): ?>
                        <?php require 'app/views/partials/course-item.php'; ?>
                    <?php endforeach; ?>
                </div>

                <?php if($totalPages > 1):?>
                <?php require_once 'app/views/partials/pagination-nav.php' ?>
                <?php endif;?>

            <?php else: ?>
                <!-- No Courses Found -->
                <div class="text-center py-12">
                    <i class="ri-book-line text-4xl text-gray-400"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun cours disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Il n'y a pas encore de cours disponibles.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
