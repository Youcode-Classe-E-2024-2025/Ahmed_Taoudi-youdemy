<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <?php require_once "app/views/partials/navbar.php"; ?>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-emerald-600">Youdemy</h1>
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Connexion</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ou
                    <a href="/register" class="font-medium text-emerald-600 hover:text-emerald-500">
                        créez un compte gratuitement
                    </a>
                </p>
            </div>
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ri-error-warning-line text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <?php if ($this->hasFlashMessage("error")): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ri-error-warning-line text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <?php echo htmlspecialchars($this->getFlashMessage("error")); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->hasFlashMessage("message")): ?>
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ri-error-warning-line text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <?php echo htmlspecialchars($this->getFlashMessage("message")); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <form class="mt-8 space-y-6" action="/login" method="POST" onsubmit="return validateForm()">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <!-- CSRF -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Adresse email
                        </label>
                        <input id="email" name="email" type="email" 
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>"
                            placeholder="exemple@email.com">
                        <p id="email-error" class="mt-1 text-xs text-red-500 hidden">Veuillez entrer une adresse email valide.</p>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <input id="password" name="password" type="password" 
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            placeholder="••••••••">
                        <p id="password-error" class="mt-1 text-xs text-red-500 hidden">
                            Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                        </p>
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="ri-lock-line text-emerald-500 group-hover:text-emerald-400"></i>
                        </span>
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Reset error messages
            document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));

            // Validate Email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').classList.remove('hidden');
                return false;
            }

            // Validate Password
            const password = document.getElementById('password').value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!passwordRegex.test(password)) {
                document.getElementById('password-error').classList.remove('hidden');
                return false;
            }


            return true; // Form is valid
        }
    </script>
</body>

</html>