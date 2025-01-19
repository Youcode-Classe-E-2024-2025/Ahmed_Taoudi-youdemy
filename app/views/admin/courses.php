<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des cours</h1>

    <!-- Courses Display as Cards -->
    <?php if (!empty($courses)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($courses as $course): ?>
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <!-- Course Image -->
                    <div class="mb-4">
                        <img src="/<?php echo $course->getImage()->getPath()?? 'assets/img/youdemy_home_2.svg'; ?>" alt="image for <?php echo htmlspecialchars($course->getName()); ?>" class="w-full h-40 object-cover rounded-lg">
                    </div>

                    <!-- Course Information -->
                    <div class="space-y-2">
                        <!-- Course Title -->
                        <a href="/course?id=<?= $course->getId(); ?>" class="text-lg font-medium text-gray-800 hover:text-emerald-600 transition duration-200">
                            <?php echo htmlspecialchars($course->getName()); ?>
                        </a>
                        <!-- Course Category -->
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Catégorie:</span> <?php echo htmlspecialchars($course->getCategory()->getName()); ?>
                        </div>
                        <!-- Course Teacher -->
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Enseignant:</span> <?php echo htmlspecialchars($course->getOwner()->getName()); ?>
                        </div>
                        <!-- Course Creation Date -->
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Créé le:</span> <?php echo htmlspecialchars($course->getCreatedAt()); ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 mt-4">
                        <!-- Delete Button with Icon -->
                        <form action="/admin/course/delete" method="POST" class="inline">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
                            <input type="hidden" name="id" value="<?= $course->getId(); ?>">
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <!-- Heroicon: Trash -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>

                        <!-- Edit Button with Icon -->
                        <a href="edit_course.php?id=<?php echo $course->getId(); ?>" class="text-emerald-600 hover:text-emerald-700">
                            <!-- Heroicon: Pencil -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
         <?php require_once "app/views/partials/pagination-nav.php"?>
        <?php else: ?>
            <p class="text-gray-500">Aucun cours trouvé.</p>
        <?php endif; ?>
</div>