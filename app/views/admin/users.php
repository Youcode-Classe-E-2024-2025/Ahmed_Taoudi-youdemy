<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des utilisateurs</h1>

    <!-- Filter by Status Buttons -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtrer par statut:</h3>
        <div class="flex flex-wrap gap-2" id="status-buttons">
            <!-- All Statuses -->
            <a href="?status=all">
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    Tous les statuts
                </span>
            </a>
            <!-- Active -->
            <a href="?status=active">
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    ✅ Actif
                </span>
            </a>
            <!-- Pending -->
            <a href="?status=pending">
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    ⏳ En attente
                </span>
            </a>
            <!-- Suspended -->
            <a href="?status=suspended">
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    ⛔ Suspendu
                </span>
            </a>
            <!-- Archived -->
            <a href="?status=archived">
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    🗄️ Archivé
                </span>
            </a>
        </div>
    </div>

    <!-- Users Display as Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="userCardsContainer">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <!-- User Information -->
                    <div class="space-y-2">
                        <!-- User Name -->
                        <div class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($user->getName()); ?></div>
                        <!-- User Email -->
                        <div class="text-sm text-gray-600"><?php echo htmlspecialchars($user->getEmail()); ?></div>
                        <!-- User Role with Icon and Color -->
                        <div class="text-sm">
                            <?php
                            $role = $user->getRole()->value;
                            $roleColor = '';
                            $roleIcon = '';

                            switch ($role) {
                                case 'student':
                                    $roleColor = 'bg-blue-100 text-blue-800';
                                    $roleIcon = '📚'; // Icon for student
                                    break;
                                case 'teacher':
                                    $roleColor = 'bg-green-100 text-green-800';
                                    $roleIcon = '👩‍🏫'; // Icon for teacher
                                    break;
                                case 'admin':
                                    $roleColor = 'bg-purple-100 text-purple-800';
                                    $roleIcon = '👑'; // Icon for admin
                                    break;
                                default:
                                    $roleColor = 'bg-gray-100 text-gray-800';
                                    $roleIcon = '👤'; // Default icon
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $roleColor; ?>">
                                <?php echo $roleIcon; ?> <!-- Role Icon -->
                                <span class="ml-1"><?php echo htmlspecialchars($role); ?></span> <!-- Role Name -->
                            </span>
                        </div>
                        <!-- User Status with Icon and Color -->
                        <div class="text-sm">
                            <?php
                            $status = $user->getStatus()->value;
                            $statusColor = '';
                            $statusIcon = '';

                            switch ($status) {
                                case 'active':
                                    $statusColor = 'bg-green-100 text-green-800';
                                    $statusIcon = '✅'; // Icon for active
                                    break;
                                case 'pending':
                                    $statusColor = 'bg-yellow-100 text-yellow-800';
                                    $statusIcon = '⏳'; // Icon for pending
                                    break;
                                case 'suspended':
                                    $statusColor = 'bg-red-100 text-red-800';
                                    $statusIcon = '⛔'; // Icon for suspended
                                    break;
                                case 'archived':
                                    $statusColor = 'bg-gray-100 text-gray-800';
                                    $statusIcon = '🗄️'; // Icon for archived
                                    break;
                                default:
                                    $statusColor = 'bg-gray-100 text-gray-800';
                                    $statusIcon = '❓'; // Default icon
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $statusColor; ?>">
                                <?php echo $statusIcon; ?> <!-- Status Icon -->
                                <span class="ml-1"><?php echo htmlspecialchars($status); ?></span> <!-- Status Name -->
                            </span>
                        </div>
                        <!-- User Creation Date -->
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Créé le:</span> <?php echo htmlspecialchars($user->getCreatedAt()); ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 mt-4">
                        <!-- Archive Button with Icon -->
                        <form action="/admin/user/update-status" method="POST" class="flex-1">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
                            <input type="hidden" name="id" value="<?= $user->getId(); ?>">
                            <select name="status" onchange="this.form.submit()" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>✅ Actif</option>
                                <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>⏳ En attente</option>
                                <option value="suspended" <?php echo $status === 'suspended' ? 'selected' : ''; ?>>⛔ Suspendu</option>
                                <option value="archived" <?php echo $status === 'archived' ? 'selected' : ''; ?>>🗄️ Archivé</option>
                            </select>
                        </form>

                      

                        <!-- Edit Button with Icon -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </div>
</div>