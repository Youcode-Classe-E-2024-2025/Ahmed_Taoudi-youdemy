<div class="relative top-20 mx-auto p-5 border shadow-lg rounded-md bg-white">
    <div class="mt-3">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Course</h3>
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

        <!-- enctype="multipart/form-data" -->
        <form id="courseForm" action="/teacher/course/create" method="POST" enctype="multipart/form-data">
            <div class="space-y-4">
                <!-- Course Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                    <input name="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                        value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? ''); ?>">
                </div>

                <!-- Course Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                        value="<?php echo htmlspecialchars($_SESSION['old']['description'] ?? ''); ?>"
                        rows="3"></textarea>
                </div>

                <!-- Category Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $ctg): ?>
                            <option value="<?= $ctg->getId(); ?>"><?= $ctg->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tag Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                    <div class="flex flex-wrap gap-2">

                        <?php foreach ($tags as $tg): ?>
                            <div class="tag-selector" data-tag-id="<?= $tg->getId(); ?>">
                                <input type="checkbox" name="tags[]" value="<?= $tg->getId(); ?>" id="tag-<?= $tg->getId(); ?>" class="hidden">
                                <label for="tag-<?= $tg->getId(); ?>" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700 cursor-pointer hover:bg-blue-50 transition-colors duration-200">
                                    <i class="ri-price-tag-3-line mr-1"></i>
                                    <?= $tg->getName(); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Course Photo -->
                <!-- <div class="mb-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Course Photo</label>
                    <div class="flex items-center space-x-4">
                        <label for="photo" class="cursor-pointer bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-colors duration-200">
                            <i class="fas fa-camera mr-2"></i>Upload Photo
                            <input type="file" name="image" id="photo" accept="image/*">
                        </label>
                        <p id="image-preview" class="text-sm text-gray-500"> </p>
                    </div>
                </div> -->
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">Course Photo</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-full">
                            <input type="file" name="photo" id="thumbnail" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-200 file:text-green-700 hover:file:bg-green-100">
                            <div id="thumbnail-preview" class="mt-2 hidden">
                                <img src="" alt="Thumbnail preview" class="h-32 w-auto">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- -------------- -->
                <!-- <div class="sm:col-span-6">
                    <div class="flex items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Type de contenu *
                        </label>
                        <div class="ml-8 flex space-x-12">
                            <div class="flex items-center">
                                <input type="radio" id="video" name="content_type" value="video" required
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="video" class="ml-3 block text-sm font-medium text-gray-700">
                                    Vidéo
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="document" name="content_type" value="document" required
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="document" class="ml-3 block text-sm font-medium text-gray-700">
                                    Document
                                </label>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- --------------- -->
                    <!-- Content Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Content Type</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="content_type" value="video" class="form-radio text-indigo-600" checked>
                                <span class="ml-2">Video</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="content_type" value="document" class="form-radio text-indigo-600">
                                <span class="ml-2">Document</span>
                            </label>
                        </div>
                    </div>

                    <!-- Dynamic Content Field -->
                    <div id="content-container">
                        <!-- Video Upload -->
                        <div id="video-content" class="space-y-2">
                            <label for="video-file" class="block text-sm font-medium text-gray-700">Upload Video</label>
                            <input type="file" name="video" id="video-file" accept="video/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-200 file:text-green-700 hover:file:bg-green-100">
                            <p class="text-sm text-gray-500">Maximum file size: 99MB</p>
                            <p id="video-error" class="mt-1 text-sm text-red-600 hidden">Please upload a video file</p>
                        </div>
                        
                        <!-- Document Editor -->
                        <div id="document-content" class="hidden">
                            <label for="document-content" class="block text-sm font-medium text-gray-700 mb-2">Document Content</label>
                            <input type="hidden" id="content" name="content" class="hidden">
                            <textarea id="markdown-editor" name="document"></textarea>
                            <p id="document-error" class="mt-1 text-sm text-red-600 hidden">Please enter document content</p>
                        </div>
                    </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-300">
                        <i class="fas fa-plus-circle mr-2"></i>Add Course
                    </button>
                </div>
        </form>
    </div>
</div>

<script>
    const tagSelectors = document.querySelectorAll('.tag-selector input[type="checkbox"]');
    tagSelectors.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.classList.remove('bg-gray-100', 'text-gray-700');
                label.classList.add('bg-blue-100', 'text-blue-800');
            } else {
                label.classList.remove('bg-blue-100', 'text-blue-800');
                label.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
    });
</script>
<script>



  
    let simplemde = new SimpleMDE({ 
        element: document.getElementById("markdown-editor"),
        spellChecker: false,
        autosave: {
            enabled: true,
            unique_id: "course_content"
        }
    });

   
    const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
    const videoContent = document.getElementById('video-content');
    const documentContent = document.getElementById('document-content');

    contentTypeRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.value === 'video') {
                videoContent.classList.remove('hidden');
                documentContent.classList.add('hidden');
            } else {
                videoContent.classList.add('hidden');
                documentContent.classList.remove('hidden');
            }
        });
    });

    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailPreview = document.getElementById('thumbnail-preview');
    const thumbnailImage = thumbnailPreview.querySelector('img');

    thumbnailInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailImage.src = e.target.result;
                thumbnailPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Form validation
    const courseForm = document.getElementById('courseForm');
    const videoFile = document.getElementById('video-file');
    const videoError = document.getElementById('video-error');
    const documentError = document.getElementById('document-error');

    courseForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        videoError.classList.add('hidden');
        documentError.classList.add('hidden');
        
        const selectedType = document.querySelector('input[name="content_type"]:checked').value;
        let isValid = true;

        if (selectedType === 'video') {
            // Clear document content
            simplemde.value('');
            
            // Validate video file
            if (!videoFile.files || videoFile.files.length === 0) {
                videoError.classList.remove('hidden');
                isValid = false;
            }
        } else {
            // Clear video file
            videoFile.value = '';
            
            // Validate document content
            if (!simplemde.value().trim()) {
                documentError.classList.remove('hidden');
                isValid = false;
            }
        }

        if (isValid) {
            this.submit();
        }
    });
    function updatePreview() {
    const desc = document.getElementById("content");
    desc.value = JSON.stringify(simplemde.value());
}
simplemde.codemirror.on("change", updatePreview);
</script>