                <!-- Pagination -->
                <div class="flex justify-center mt-6">
                    <nav class="inline-flex rounded-md shadow-sm">
                        <!-- Previous Page Link -->
                        <?php if ($page > 1): ?>
                            <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=<?= $page - 1 ?>"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50"
                                aria-label="Previous page">Précédent</a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-md"
                                aria-disabled="true" aria-label="Previous page">Précédent</span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php if ($totalPages <= 7): ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=<?= $i ?>"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 <?= $i == $page ? 'bg-gray-200' : '' ?>"
                                    aria-label="Page <?= $i ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        <?php else: ?>
                            <!-- Show First Page -->
                            <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=1"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 <?= $page == 1 ? 'bg-gray-200' : '' ?>"
                                aria-label="Page 1">1</a>

                            <!-- Show Ellipsis if necessary -->
                            <?php if ($page > 4): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">...</span>
                            <?php endif; ?>

                            <!-- Show Near Pages -->
                            <?php
                            $start = max(2, $page - 2);
                            $end = min($totalPages - 1, $page + 2);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=<?= $i ?>"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 <?= $i == $page ? 'bg-gray-200' : '' ?>"
                                    aria-label="Page <?= $i ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <!-- Show Ellipsis if necessary -->
                            <?php if ($page < $totalPages - 3): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">...</span>
                            <?php endif; ?>

                            <!-- Show Last Page -->
                            <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=<?= $totalPages ?>"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 <?= $page == $totalPages ? 'bg-gray-200' : '' ?>"
                                aria-label="Page <?= $totalPages ?>"><?= $totalPages ?></a>
                        <?php endif; ?>

                        <!-- Next Page Link -->
                        <?php if ($page < $totalPages): ?>
                            <a href="?category=<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>&page=<?= $page + 1 ?>"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50"
                                aria-label="Next page">Suivant</a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-r-md"
                                aria-disabled="true" aria-label="Next page">Suivant</span>
                        <?php endif; ?>
                    </nav>
                </div>