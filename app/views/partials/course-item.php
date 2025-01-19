<div
    class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300"
    data-category="<?= $course->getCategory()->getName() ?>">

    <!-- Course Image -->
    <img src="/<?= $course->getImage()->getPath() ?? 'assets/img/youdemy_home_2.svg' ?>"
        alt="image for <?= $course->getName() ?>" class="w-full h-48 object-cover" />

    <!-- Course Content -->
    <div class="p-6">

        <!-- Title -->
        <h2 class="text-xl font-semibold text-gray-900 mb-2">
            <?= htmlspecialchars($course->getName()) ?>
        </h2>

        <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
            <i class="ri-folder-line mr-1"></i>
            <?= $course->getCategory()->getName() ?>
        </span>

        <!-- Description -->
        <p class="text-sm text-gray-600 mb-4">
            <?= htmlspecialchars($course->getDescription()) ?>
        </p>

        <!-- Instructor and Level -->
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>By <?= htmlspecialchars($course->getOwner()->getName()) ?></span>
        </div>
    </div>

    <!-- Tags -->
    <div class="px-6 pb-4">
        <div class="flex flex-wrap gap-2">
            <?php foreach ($course->getTags() as $tag): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                    <?= htmlspecialchars($tag->getName()) ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>