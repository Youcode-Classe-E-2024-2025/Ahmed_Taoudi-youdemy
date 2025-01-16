<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <?php require_once "app/views/partials/navbar.php"; ?>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-emerald-600">YouDemy</h1>
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Créer un compte</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ou
                    <a href="/login" class="font-medium text-emerald-600 hover:text-emerald-500">
                        connectez-vous à votre compte
                    </a>
                </p>
            </div>

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

            <!-- Display Server-Side Errors -->
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

            <form class="mt-8 space-y-6" action="/register" method="POST" onsubmit="return validateForm()">
                <div class="rounded-md shadow-sm space-y-4">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            placeholder="ahmed taoudi"
                            value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? ''); ?>">
                        <p id="name-error" class="mt-1 text-xs text-red-500 hidden">Le nom est requis.</p>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            placeholder="exemple@email.com"
                            value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>">
                        <p id="email-error" class="mt-1 text-xs text-red-500 hidden">Veuillez entrer une adresse email valide.</p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            placeholder="••••••••">
                        <p id="password-error" class="mt-1 text-xs text-red-500 hidden">
                            Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                        </p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                        <input id="confirm_password" name="confirm_password" type="password" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                            placeholder="••••••••">
                        <p id="confirm-password-error" class="mt-1 text-xs text-red-500 hidden">Les mots de passe ne correspondent pas.</p>
                    </div>

                    <!-- Role Selection Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Étudiant Card -->
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="student" 
                                    class="hidden peer"
                                    <?php echo (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] === 'student') ? 'checked' : ''; ?>>
                                <div class="p-4 border-2 border-gray-200 rounded-lg transition-all duration-200 ease-in-out
                                            peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Étudiant</h3>
                                            <p class="text-sm text-gray-500">Je veux apprendre et suivre des cours.</p>
                                        </div>
                                        <i class="ri-user-3-line text-2xl text-gray-400 peer-checked:text-emerald-600"></i>
                                    </div>
                                </div>
                            </label>

                            <!-- Enseignant Card -->
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="teacher" 
                                    class="hidden peer"
                                    <?php echo (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] === 'teacher') ? 'checked' : ''; ?>>
                                <div class="p-4 border-2 border-gray-200 rounded-lg transition-all duration-200 ease-in-out
                                            peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Enseignant</h3>
                                            <p class="text-sm text-gray-500">Je veux créer et partager des cours.</p>
                                        </div>
                                        <i class="ri-user-star-line text-2xl text-gray-400 peer-checked:text-emerald-600"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <p id="role-error" class="mt-2 text-xs text-red-500 hidden">Veuillez sélectionner un rôle.</p>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="ri-user-add-line text-emerald-500 group-hover:text-emerald-400"></i>
                            </span>
                            Créer un compte
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Reset error messages
            document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));

            // Validate Name
            const name = document.getElementById('name').value.trim();
            if (!name) {
                document.getElementById('name-error').classList.remove('hidden');
                return false;
            }

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

            // Validate Confirm Password
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                document.getElementById('confirm-password-error').classList.remove('hidden');
                return false;
            }

            // Validate Role
            const role = document.querySelector('input[name="role"]:checked');
            if (!role) {
                document.getElementById('role-error').classList.remove('hidden');
                return false;
            }

            return true; // Form is valid
        }
    </script>
</body>

</html>