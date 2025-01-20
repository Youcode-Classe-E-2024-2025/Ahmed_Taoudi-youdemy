<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Course Details - Youdemy</title>
</head>

<body class="bg-gray-100">
    <?php require_once "app/views/partials/navbar.php"; ?>

    <!-- Course Details Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            
            <!-- Course Photo -->
            <img src="/<?= $course->getImage()->getPath() ?? 'assets/img/youdemy_home_2.svg' ?>"
                alt="Course Photo" class="w-full h-96 object-cover">

            <!-- Course Details -->
            <div class="p-6">
                <div class="flex justify-between">

                    <!-- Course Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($course->getName()) ?>
                    </h1>
                    <!-- Enrollment Button -->
                    <?php if($this->_is(Role::ADMIN->value) || $this->_is(Role::TEACHER->value) ): ?>
                    <?php else:?>
                    <div class="mt-6">
                        <form action="/enroll" method="POST">
                            <input type="hidden" name="course_id" value="<?= $course->getId() ?>">
                            <button type="submit" class="inline-block bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-500">
                                S'inscrire au cours 
                            </button>
                        </form>
                    </div>
                    <?php endif ;?>

                </div>


                <!-- Course Description -->
                <p class="text-gray-600 mb-4">
                    <?= htmlspecialchars($course->getDescription()) ?>
                </p>

                <!-- Course Category Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                        <i class="ri-folder-line mr-1"></i>
                        <?= htmlspecialchars($course->getCategory()->getName()) ?>
                    </span>
                </div>


                <!-- Teacher Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Enseignant:</h3>
                    <div class="mt-2 flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <i class="ri-user-line text-2xl text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-700 font-medium">
                                <?= htmlspecialchars($course->getOwner()->getName()) ?>
                            </p>
                            <span class="text-sm text-emerald-600 ">
                                <?= htmlspecialchars($course->getOwner()->getEmail()) ?>
                            </span>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Course Content -->
            <div class="p-6 bg-gray-50">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Contenu du cours</h2>
                <div class="space-y-4">
                    <?php $course->getContent() ?>
                </div>
            </div>



        </div>
    </div>

    <?php require_once "app/views/partials/footer.php"; ?>
</body>

</html>