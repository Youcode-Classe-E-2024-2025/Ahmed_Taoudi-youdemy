<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Youdemy - Online Learning Platform</title>
</head>

<body>
    <?php require_once "app/views/partials/navbar.php"; ?>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gradient-to-b from-emerald-100/20">
            <div class="mx-auto max-w-7xl pb-24 pt-10 sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-20">
                <div class="px-6 lg:px-0 lg:pt-4">
                    <div class="mx-auto max-w-2xl">
                        <div class="max-w-lg">
                            <h1 class="mt-10 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                                Apprenez, enseignez, et grandissez avec Youdemy
                            </h1>
                            <p class="mt-6 text-lg leading-8 text-gray-600">
                                Youdemy est une plateforme d'apprentissage en ligne interactive et personnalisée, conçue pour les étudiants et les enseignants.
                            </p>
                            <div class="mt-10 flex items-center gap-x-6">
                                <a href="/register"
                                    class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                    Commencer gratuitement
                                </a>
                                <a href="/courses" class="text-sm font-semibold leading-6 text-gray-900">
                                    Explorer les cours <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-2xl lg:mx-0 lg:mt-0 lg:w-screen">
                    <img src="assets/img/youdemy_home_1.svg" alt="Learning illustration" class="w-full">
                </div>
            </div>
        </div>

        <!-- Category Section -->
        <div id="categories" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-base font-semibold leading-7 text-emerald-600">Parcourez par catégories</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Catégories populaires
                </p>
            </div>
            <div class="px-4 py-8 sm:px-0">
                <?php if (!empty($categories)): ?>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <?php foreach ($categories as $category): ?>
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        <i class="ri-folder-line mr-2"></i>
                                        <?= htmlspecialchars($category->getName()) ?>
                                    </h3>
                                    <a href="/courses?category=<?= $category->getId() ?>"
                                        class="mt-4 inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-500">
                                        Voir les cours <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- No Categories Found -->
                    <div class="text-center py-12">
                        <i class="ri-folder-line text-4xl text-gray-400"></i>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune catégorie disponible</h3>
                        <p class="mt-1 text-sm text-gray-500">Il n'y a pas encore de catégories disponibles.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Course Catalog Section -->
        <div id="courses" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-base font-semibold leading-7 text-emerald-600">Explorez notre catalogue</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Cours populaires
                </p>
            </div>
            <div class="px-4 py-8 sm:px-0">
                <?php if (!empty($courses)): ?>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($courses as $course): ?>
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300"
                                data-category="<?= $course->getCategory()->getName() ?>">
                                <!-- Course Image -->
                                <img src="<?= $course->getImage()->getPath() ?? '/assets/img/youdemy_home_2.svg' ?>"
                                    alt="image for <?= $course->getName() ?>" class="w-full h-48 object-cover" />
                                <!-- Course Content -->
                                <div class="p-6">
                                    <!-- Title -->
                                    <a href="/course?id=<?= $course->getId(); ?>">
                                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                            <?= htmlspecialchars($course->getName()) ?>
                                        </h2>
                                    </a>
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
                        <?php endforeach; ?>
                    </div>
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

        <!-- Features Section -->
        <div id="features" class="mx-auto mt-8 max-w-7xl px-6 sm:mt-16 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-base font-semibold leading-7 text-emerald-600">Pourquoi choisir Youdemy ?</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Une expérience d'apprentissage unique
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-7xl sm:mt-20 lg:mt-24 lg:max-w-7xl">
                <div class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">
                    <div class="relative pl-16">
                        <div class="text-emerald-600 absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50">
                            <i class="ri-search-line text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold leading-7 text-gray-900">
                            Recherche avancée
                        </h3>
                        <p class="mt-2 text-base leading-7 text-gray-600">
                            Trouvez facilement des cours par mots-clés, catégories ou niveaux.
                        </p>
                    </div>
                    <div class="relative pl-16">
                        <div class="text-emerald-600 absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50">
                            <i class="ri-user-line text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold leading-7 text-gray-900">
                            Choix de rôle
                        </h3>
                        <p class="mt-2 text-base leading-7 text-gray-600">
                            Créez un compte en tant qu'étudiant ou enseignant pour accéder à des fonctionnalités adaptées.
                        </p>
                    </div>
                    <div class="relative pl-16">
                        <div class="text-emerald-600 absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50">
                            <i class="ri-video-line text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold leading-7 text-gray-900">
                            Cours interactifs
                        </h3>
                        <p class="mt-2 text-base leading-7 text-gray-600">
                            Apprenez avec des vidéos, quiz et exercices pratiques.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative isolate mt-32 px-6 py-32 sm:mt-40 sm:py-40 lg:px-8">
            <div class="absolute inset-x-0 top-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-emerald-200 to-emerald-400 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
            </div>
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Prêt à commencer votre voyage d'apprentissage ?
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">
                    Rejoignez Youdemy aujourd'hui et accédez à des milliers de cours interactifs et personnalisés.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="/register"
                        class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        S'inscrire maintenant
                    </a>
                    <a href="/login" class="text-sm font-semibold leading-6 text-gray-900">
                        Se connecter <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "app/views/partials/footer.php"; ?>
</body>

</html>