<!-- navbar-->
<nav class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/">
                    YouDemy
                </a>
            </div>
            <!-- Navigation Links -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-4">
                    <a href="/" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium">
                        Accueil
                    </a>
                    <a href="/courses" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium">
                        Cours
                    </a>
                    <a href="/#features" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium">
                        Fonctionnalités
                    </a>
                </div>
            </div>
            <?php if (!isset($_SESSION['user'])): ?>
                <!-- Auth Buttons -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center space-x-4">
                        <a href="/login" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="/register"
                            class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                            S'inscrire
                        </a>

                    </div>
                </div>
            <?php else: ?>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center space-x-4">
                        <a href="/<?= $_SESSION['user']['role'] ?>/dashboard" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="ri-user-fill"></i>
                            <?= $_SESSION['user']['name'] ?>
                        </a>
                        <a href="/logout" class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                            <span class="ml-1">Log Out</span>
                            <i class="ri-logout-circle-r-line text-xs"></i>
                        </a>
                    </div>
                </div>

            <?php endif; ?>
            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex md:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-900 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <i class="ri-menu-line text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/" class="block text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-base font-medium">
                Accueil
            </a>
            <a href="/courses" class="block text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-base font-medium">
                Cours
            </a>
            <a href="/#features" class="block text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-base font-medium">
                Fonctionnalités
            </a>
            <?php if (!isset($_SESSION['user'])): ?>
            <a href="/login" class="block text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-base font-medium">
                Connexion
            </a>
            <a href="/register"
                class="block rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                S'inscrire
            </a>
            <?php else:?>
                <a href="/login" class="block text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-base font-medium">
                <i class="ri-user-fill"></i>
                <?= $_SESSION['user']['name'] ?>
            </a>
            <a href="/register"
                class="block rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                <span class="ml-1">Log Out</span>
                <i class="ri-logout-circle-r-line text-xs"></i>
            </a>
            <?php endif;?>

        </div>
    </div>
</nav>
<script>
    // Toggle mobile menu
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Close mobile menu when a link is clicked
        const mobileMenuLinks = document.querySelectorAll('#mobile-menu a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            });
        });
    });
</script>