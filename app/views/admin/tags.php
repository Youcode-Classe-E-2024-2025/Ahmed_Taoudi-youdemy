<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des tags</h1>
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

    <!-- Tag Creation Form -->
    <div class="mb-8">
        <form id="tagForm" action="/admin/tag/create" method="POST" class="space-y-4" onsubmit="return validateTagForm()">
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <!-- Error Message Container -->
            <div id="errorMessage" class="hidden bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
                Veuillez remplir tous les champs de tag.
            </div>

            <div id="tagContainer">
                <div class="tag-container flex items-center gap-2">
                    <input type="text" name="tags[]" class="tag-input flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Entrez un tag" >
                </div>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="addTagField()" class="add-tag-btn bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition duration-200">Ajouter un autre tag</button>
                <button type="submit" class="submit-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Enregistrer les tags</button>
            </div>
        </form>
    </div>

    <!-- Tags Display as Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php if (!empty($tags)): ?>
            <?php foreach ($tags as $tg): ?>
                <div class="bg-emerald-50 p-4 rounded-lg shadow-md border border-emerald-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-emerald-800"><?php echo htmlspecialchars($tg->getName()); ?></span>
                        <div class="flex gap-2">
                            <form action="/admin/tag/delete" method="POST" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
                                <input type="hidden" name="id" value="<?= $tg->getId(); ?>">
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>

                            <!-- Edit Button with Icon -->
                            <button class="text-emerald-600 hover:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Aucun tag trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for Dynamic Tag Fields and Validation -->
<script>
    function addTagField() {
        const container = document.getElementById('tagContainer');
        const newTagInput = document.createElement('div');
        newTagInput.classList.add('tag-container', 'flex', 'items-center', 'gap-2', 'mt-2');
        newTagInput.innerHTML = `
            <input type="text" name="tags[]" class="tag-input flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Entrez un tag" >
            <button type="button" onclick="removeTagField(this)" class="text-red-600 hover:text-red-700">
                <!-- Heroicon: Trash -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        container.appendChild(newTagInput);
    }

    function removeTagField(button) {
        const container = document.getElementById('tagContainer');
        if (container.children.length > 1) {
            container.removeChild(button.parentElement);
        } else {
            alert("Au moins un tag est requis.");
        }
    }

    function validateTagForm() {
        const tagInputs = document.querySelectorAll('.tag-input');
        const errorMessage = document.getElementById('errorMessage');
        let isValid = true;

        tagInputs.forEach(input => {
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