<?php
define('ACCESS_ALLOWED', true);
require_once './../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $recentCategories = get_recent_categories();
        $typesProduits = get_product_types();

        // Calculer les statistiques
        $total_categories = count($recentCategories);
        $categories_actives = count(array_filter($recentCategories, function ($cat) {
            return $cat['c_status'] === 'Active';
        }));
        $categories_inactives = $total_categories - $categories_actives;

        // Générer le HTML
        ob_start();

        if (!empty($recentCategories)) {
            foreach ($recentCategories as $categorie) : ?>
                <tr class="category-row hover:bg-gray-50 transition-colors duration-150"
                    data-type-id="<?= htmlspecialchars($categorie['tp_id'] ?? '') ?>"
                    data-status="<?= htmlspecialchars($categorie['c_status'] ?? '') ?>"
                    data-name="<?= htmlspecialchars(strtolower($categorie['c_name'] ?? '')) ?>">
                    <!-- N° -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <?= htmlspecialchars($categorie['number'] ?? '') ?>
                        </div>
                    </td>
                    <!-- Image -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden">
                            <?php if (!empty($categorie['c_image'])): ?>
                                <img
                                    src="<?= htmlspecialchars($categorie['c_image']) ?>"
                                    alt="<?= htmlspecialchars($categorie['c_name'] ?? '') ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>

                    <!-- Nom -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($categorie['c_name'] ?? 'Sans nom') ?>
                        </div>
                    </td>

                    <!-- Type de produit -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <?= htmlspecialchars(get_type_name($categorie['tp_id']) ?? 'Non défini') ?>
                        </div>
                    </td>

                    <!-- Statut -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($categorie['c_status'] === 'Active'): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Inactive
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button
                                onclick="viewCategorie(<?= htmlspecialchars(json_encode($categorie)) ?>)"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-600 bg-gray-50 rounded-md hover:bg-gray-100 transition-all duration-200 cursor-pointer"
                                title="Voir les détails">
                                <i class="fas fa-eye mr-1"></i>
                            </button>
                            <button
                                onclick="editCategorie(<?= htmlspecialchars(json_encode($categorie)) ?>)"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition-all duration-200 cursor-pointer"
                                title="Modifier">
                                <i class="fas fa-edit mr-1"></i>
                            </button>
                            <button
                                onclick="deleteCategorie(<?= $categorie['c_id'] ?? 0 ?>, '<?= htmlspecialchars($categorie['c_name'] ?? '') ?>')"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition-all duration-200 cursor-pointer"
                                title="Supprimer">
                                <i class="fas fa-trash mr-1"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach;
        } else { ?>
            <tr id="noCategoriesRow">
                <td colspan="5" class="px-6 py-12 text-center">
                    <i class="fas fa-tags text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune catégorie trouvée</h3>
                    <p class="text-gray-600">Commencez par ajouter votre première catégorie.</p>
                </td>
            </tr>
<?php }

        $html = ob_get_clean();

        // Réponse JSON avec HTML et données
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html,
            'data' => $recentCategories,
            'count' => count($recentCategories),
            'stats' => [
                'total' => $total_categories,
                'active' => $categories_actives,
                'inactive' => $categories_inactives
            ]
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors du chargement des catégories: ' . $e->getMessage()
        ]);
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
    exit;
}
?>