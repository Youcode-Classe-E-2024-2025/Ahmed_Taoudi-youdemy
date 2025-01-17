<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des utilisateurs</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user->getName()); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user->getEmail()); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user->getRole()->value); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user->getStatus()->value); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user->getCreatedAt()); ?></td>
                            <td class="px-6 py-4">
                                <form action="/admin/user/delete" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
                                    <input type="hidden" name="id" value="<?= $user->getId(); ?>">
                                    <button class="text-red-600 hover:text-red-700 ml-2">Archive</button>
                                </form>

                                <button href="edit_user.php?id=<?php echo $user->getId(); ?>" class="text-emerald-600 hover:text-emerald-700">Modifier</button>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
