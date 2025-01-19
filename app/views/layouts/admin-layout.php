<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50">

    <!-- Sidebar -->
    <?php require_once "app/views/partials/dashboard-nav.php"; ?>

    <aside id="sidebar" class="fixed top-16 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-[calc(100%-4rem)] pt-4 duration-75 bg-white border-r transition-width lg:translate-x-0 -translate-x-full">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1">
                <a href="/admin/dashboard" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-dashboard-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Tableau de bord</span>
                </a>
                <a href="/admin/users" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-user-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Gestion des utilisateurs</span>
                </a>
                <a href="/admin/courses" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-book-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Gestion des cours</span>
                </a>
                <a href="/admin/categories" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-folder-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Gestion des catégories</span>
                </a>
                <a href="/admin/tags" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-price-tag-3-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Gestion des tags</span>
                </a>
                <a href="/admin/statistics" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-emerald-100 group">
                    <i class="ri-line-chart-line text-xl text-gray-500 group-hover:text-emerald-600"></i>
                    <span class="ml-3">Statistiques</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="p-4 lg:ml-64 pt-20">
        <div id="content">


            <?php if ($this->hasFlashMessage("message")): ?>
                <div id="green_message" class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-100 rounded-lg flex justify-between">
                <?php echo htmlspecialchars($this->getFlashMessage("message")); ?>
                <button type="button" onclick="document.getElementById('green_message')?.remove()"  class="text-red-700 bg-red-200 hover:bg-white rounded-md px-3 py-1 mr-4">X</button>
                <script>setTimeout(()=>{  document.getElementById('green_message')?.remove();},10000) </script>
                </div>
            <?php endif; ?>

            <?php if ($this->hasFlashMessage("error")):  ?>
                <div  id="red_message" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg flex justify-between">
                <?php echo htmlspecialchars($this->getFlashMessage("error")); ?>
                <button type="button" onclick="document.getElementById('red_message')?.remove()"  class="text-red-700 bg-red-200 hover:bg-white rounded-md px-3 py-1 mr-4">X</button>
                <script>setTimeout(()=>{  document.getElementById('red_message')?.remove();},10000) </script>
                </div>

            <?php endif; ?>

            <?php require_once $content; ?>
        </div>
    </div>
    <script>
        // Toggle Sidebar
        const burgerMenu = document.getElementById('burgerMenu');
        const sidebar = document.getElementById('sidebar');

        burgerMenu.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

    <!-- <script src="assets/js/main.js"></script> -->
</body>

</html>