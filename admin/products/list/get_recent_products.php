<?php
define('ACCESS_ALLOWED', true);
require_once './../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $recentProducts = get_latest_products(6);

        // Générer le HTML
        ob_start();

        if (!empty($recentProducts)) {
            foreach ($recentProducts as $produit) : ?>
                <div class="recent-product-card bg-gray-50 rounded-lg p-4 border hover:shadow-md transition-all duration-200">
                    <!-- Image et informations principales -->
                    <div class="flex items-start space-x-3">
                        <!-- Image -->
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                            <?php if (!empty($produit['p_image'])): ?>
                                <img
                                    src="<?= htmlspecialchars($produit['p_image']) ?>"
                                    alt="<?= htmlspecialchars($produit['p_name'] ?? '') ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-lg"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Informations -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 truncate" title="<?= htmlspecialchars($produit['p_name'] ?? '') ?>">
                                <?= htmlspecialchars($produit['p_name'] ?? 'Produit sans nom') ?>
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                <?= htmlspecialchars($produit['categorie_nom'] ?? 'Sans catégorie') ?>
                            </p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm font-bold text-gray-900">
                                    <?= number_format($produit['prix'] ?? 0, 0, ',', ' ') ?> FCFA
                                </span>
                                <span class="text-xs text-gray-500">
                                    Stock: <?= $produit['quantite_stock'] ?? 0 ?>
                                </span>
                            </div>
                            <?php if (isset($produit['created_at'])): ?>
                                <p class="text-xs text-gray-400 mt-1">
                                    Ajouté <?= date('d/m/Y à H:i', strtotime($produit['created_at'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Badges de statut -->
                    <div class="flex items-center space-x-2 mt-3">
                        <?php if ($produit['p_status'] === 'Disponible'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Disponible
                            </span>
                        <?php elseif ($produit['p_status'] === 'En rupture'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>En rupture
                            </span>
                        <?php else: ?>
                            <!-- Statut Indisponible ou null -->
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-times-circle mr-1"></i>Indisponible
                            </span>
                        <?php endif; ?>

                        <?php if (isset($produit['est_en_promotion']) && $produit['est_en_promotion']): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-percentage mr-1"></i>Promo
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-2 mt-3 pt-3 border-t border-gray-200">
                        <button
                            onclick="openEditModal(<?= htmlspecialchars(json_encode($produit)) ?>)"
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition-all duration-200 cursor-pointer"
                            title="Modifier le produit">
                            <i class="fas fa-edit mr-1"></i>
                        </button>
                        <button
                            onclick="deleteProduit(<?= $produit['p_id'] ?? 0 ?>, '<?= htmlspecialchars($produit['p_name'] ?? '') ?>')"
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition-all duration-200 cursor-pointer"
                            title="Supprimer le produit">
                            <i class="fas fa-trash mr-1"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach;
        } else { ?>
            <div class="col-span-full text-center py-8">
                <i class="fas fa-box-open text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">Aucun produit récent trouvé</p>
            </div>
<?php }

        $html = ob_get_clean();

        // Réponse JSON avec HTML et données
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html,
            'data' => $recentProducts,
            'count' => count($recentProducts)
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors du chargement des produits: ' . $e->getMessage()
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
