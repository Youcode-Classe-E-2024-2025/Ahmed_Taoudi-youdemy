<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des catégories</h1>
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

    <!-- Category Creation Form -->
    <div class="mb-8">
        <form id="categoryForm" action="/admin/category/create" method="POST" class="space-y-4" onsubmit="return validateCategoryForm()">
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <!-- Error Message Container -->
            <div id="errorMessageCategory" class="hidden bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
                Veuillez remplir tous les champs de catégorie.
            </div>

            <div id="categoryContainer">
                <div class="category-container flex items-center gap-2">
                    <input type="text" name="categories[]" class="category-input flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Entrez une catégorie" >
                </div>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="addCategoryField()" class="add-category-btn bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition duration-200">Ajouter une autre catégorie</button>
                <button type="submit" class="submit-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Enregistrer les catégories</button>
            </div>
        </form>
    </div>

    <!-- Categories Display as Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php if (!empty($categorys)): ?>
            <?php foreach ($categorys as $ctg): ?>
                <div class="bg-emerald-50 p-4 rounded-lg shadow-md border border-emerald-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-emerald-800"><?php echo htmlspecialchars($ctg->getName()); ?></span>
                        <div class="flex gap-2">
                            <!-- Delete Button with Icon -->
                            <form action="/admin/category/delete" method="POST" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
                                <input type="hidden" name="id" value="<?= $ctg->getId(); ?>">
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <!-- Heroicon: Trash -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>

                            <!-- Edit Button with Icon -->
                            <a class="text-emerald-600 hover:text-emerald-700">
                                <!-- Heroicon: Pencil -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Aucune catégorie trouvée.</p>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for Dynamic Category Fields and Validation -->
<script>
    function addCategoryField() {
        const container = document.getElementById('categoryContainer');
        const newCategoryInput = document.createElement('div');
        newCategoryInput.classList.add('category-container', 'flex', 'items-center', 'gap-2', 'mt-2');
        newCategoryInput.innerHTML = `
            <input type="text" name="categories[]" class="category-input flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Entrez une catégorie" >
            <button type="button" onclick="removeCategoryField(this)" class="text-red-600 hover:text-red-700">
                <!-- Heroicon: Trash -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        container.appendChild(newCategoryInput);
    }

    function removeCategoryField(button) {
        const container = document.getElementById('categoryContainer');
        if (container.children.length > 1) {
            container.removeChild(button.parentElement);
        } else {
            alert("Au moins une catégorie est requise.");
        }
    }

    function validateCategoryForm() {
        const categoryInputs = document.querySelectorAll('.category-input');
        const errorMessage = document.getElementById('errorMessageCategory');
        let isValid = true;

        categoryInputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('border-red-500'); // Add red border to empty fields
            } else {
                input.classList.remove('border-red-500'); // Remove red border if field is filled
            }
        });

        if (!isValid) {
            errorMessage.classList.remove('hidden'); // Show error message
            return false; // Prevent form submission
        } else {
            errorMessage.classList.add('hidden'); // Hide error message if all fields are valid
            return true; // Allow form submission
        }
    }
</script>