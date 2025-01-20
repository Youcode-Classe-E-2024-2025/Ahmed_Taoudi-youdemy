<?php
// Debug::pd($courses);
?>
<div>
    <a href="/teacher/course/add" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-green-100 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
        Ajoute un Cours
</a>
</div>
<div class="px-4 py-8 sm:px-0">
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