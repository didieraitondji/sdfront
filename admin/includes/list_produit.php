<?php
// Récupération des données
$produits = get_products(); // Utilisation de votre fonction existante
$categories = []; // Extraction des catégories uniques depuis les produits

// Extraire les catégories uniques
foreach ($produits as $produit) {
    if (isset($produit['c_id']) && !in_array($produit['c_id'], $categories)) {
        $categories[] = $produit['c_id'];
    }
}
sort($categories); // Tri alphabétique des catégories
?>

<div class="">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Liste des Produits
            </h1>
            <p class="mt-2 text-gray-600">Découvrez vos produits</p>
        </div>

        <!-- Statistiques rapides -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"> -->
        <!-- <div class="bg-gray-100 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Produits</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalProducts"><?= count($produits) ?></p>
                    </div>
                </div>
            </div> -->

        <!-- <div class="bg-gray-100 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-lg">
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Catégories</p>
                        <p class="text-2xl font-bold text-gray-900"><?= count($categories) ?></p>
                    </div>
                </div>
            </div> -->

        <!-- <div class=" bg-gray-100 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg">
                        <i class="fas fa-percentage text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En Promotion</p>
                        <p class="text-2xl font-bold text-gray-900" id="promotionCount">
                            <?= count(array_filter($produits, fn($p) => isset($p['est_en_promotion']) && $p['est_en_promotion'])) ?>
                        </p>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->

        <!-- Filtres et recherche -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher un produit</label>
                    <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Tapez le nom d'un produit..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par catégorie</label>
                    <select
                        id="categoryFilter"
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars(get_category_name($category)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <span id="visibleCount"><?= count($produits) ?></span> produit(s) affiché(s)
                </div>
                <button
                    onclick="resetFilters()"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-all duration-200 flex items-center cursor-pointer">
                    <i class="fas fa-undo mr-2"></i>
                    Réinitialiser
                </button>
            </div>
        </div>

        <!-- Liste des produits SIMPLIFIÉE -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="productsGrid">
            <?php foreach ($produits as $produit): ?>
                <div class="product-card bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-white/20 overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                    data-name="<?= strtolower(htmlspecialchars($produit['p_name'] ?? '')) ?>"
                    data-category="<?= htmlspecialchars($produit['c_id'] ?? '') ?>"
                    data-promotion="<?= isset($produit['est_en_promotion']) && $produit['est_en_promotion'] ? 'true' : 'false' ?>">

                    <!-- Image du produit -->
                    <div class="relative h-36 bg-gray-100 overflow-hidden">
                        <?php if (!empty($produit['p_image'])): ?>
                            <img
                                src="<?= htmlspecialchars($produit['p_image']) ?>"
                                alt="<?= htmlspecialchars($produit['p_name'] ?? '') ?>"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                        <?php endif; ?>

                        <!-- Badge promotion simplifié -->
                        <?php if (isset($produit['est_en_promotion']) && $produit['est_en_promotion']): ?>
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                                PROMO
                            </div>
                        <?php endif; ?>

                        <!-- Badge catégorie -->
                        <?php if (!empty($produit['categorie'])): ?>
                            <div class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                                <?= htmlspecialchars(get_category_name($produit['c_id'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contenu simplifié -->
                    <div class="p-4">
                        <!-- Nom et prix sur la même ligne -->
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm font-bold text-gray-900 flex-1 mr-2 truncate" title="<?= htmlspecialchars($produit['p_name'] ?? 'Produit sans nom') ?>">
                                <?= htmlspecialchars($produit['p_name'] ?? 'Produit sans nom') ?>
                            </h3>
                            <div class="text-right">
                                <?php if (isset($produit['est_en_promotion']) && $produit['est_en_promotion'] && !empty($produit['prix_promotionnel'])): ?>
                                    <span class="text-sm font-bold text-red-600">
                                        <?= number_format($produit['prix_promotionnel'], 0, ',', ' ') ?>
                                    </span>
                                    <span class="text-xs text-gray-500 line-through">
                                        <?= number_format($produit['prix'], 0, ',', ' ') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-sm font-bold text-gray-900">
                                        <?= number_format($produit['prix'] ?? 0, 0, ',', ' ') ?>
                                    </span>
                                <?php endif; ?>
                                <div class="text-xs text-gray-500">FCFA</div>
                            </div>
                        </div>

                        <!-- Boutons voir détails alignés à droite -->
                        <div class="flex justify-end items-center gap-2">
                            <button
                                onclick="openProductModal(<?= htmlspecialchars(json_encode($produit)) ?>)"
                                class="group cursor-pointer relative flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                title="Voir les détails">
                                <i class="fas fa-eye text-xs group-hover:scale-110 transition-transform duration-200"></i>
                            </button>

                            <button
                                onclick="openEditModal(<?= htmlspecialchars(json_encode($produit)) ?>)"
                                class="group cursor-pointer relative flex items-center justify-center w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 rounded-lg transition-all duration-200 border border-blue-200/50 hover:border-blue-300"
                                title="Modifier le produit">
                                <i class="fas fa-edit text-xs group-hover:scale-110 transition-transform duration-200"></i>
                            </button>

                            <button
                                onclick="deleteProduit(<?= $produit['p_id'] ?? 0 ?>, '<?= htmlspecialchars($produit['p_name'] ?? '') ?>')"
                                class="group cursor-pointer relative flex items-center justify-center w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 rounded-lg transition-all duration-200 border border-red-200/50 hover:border-red-300"
                                title="Supprimer le produit">
                                <i class="fas fa-trash text-xs group-hover:scale-110 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Message si aucun produit trouvé -->
        <div id="noProductsMessage" class="hidden text-center py-12">
            <div class="max-w-md mx-auto">
                <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit trouvé</h3>
                <p class="text-gray-600">Essayez de modifier vos critères de recherche ou de filtrage.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables globales
    let allProducts = [];

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer toutes les cartes de produits
        allProducts = Array.from(document.querySelectorAll('.product-card'));

        // Ajouter les event listeners
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);

        // Animation d'entrée pour les cartes
        animateCards();

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        // Fermer le modal avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('productModal').classList.contains('hidden')) {
                closeProductModal();
            }
        });
    });

    // NOUVELLE FONCTION : Ouvrir le modal avec les détails du produit
    function openProductModal(produit) {
        const modal = document.getElementById('productModal');

        // Remplir le nom
        document.getElementById('modalProductName').textContent = produit.p_name || 'Produit sans nom';

        // Remplir l'image
        const imageContainer = document.getElementById('modalProductImage');
        if (produit.p_image) {
            imageContainer.innerHTML = `<img src="${produit.p_image}" alt="${produit.p_name || ''}" class="w-full h-full object-cover">`;
        } else {
            imageContainer.innerHTML = `<div class="w-full h-full flex items-center justify-center"><i class="fas fa-image text-gray-400 text-4xl"></i></div>`;
        }

        // Remplir le prix
        const priceContainer = document.getElementById('modalProductPrice');
        if (produit.est_en_promotion && produit.prix_promotionnel) {
            priceContainer.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-red-600">
                        ${Number(produit.prix_promotionnel).toLocaleString()} FCFA
                    </span>
                    <span class="text-lg text-gray-500 line-through">
                        ${Number(produit.prix).toLocaleString()} FCFA
                    </span>
                </div>
                <div class="text-sm text-red-600 font-medium">
                    Économisez ${Number(produit.prix - produit.prix_promotionnel).toLocaleString()} FCFA
                </div>
            `;
        } else {
            priceContainer.innerHTML = `<span class="text-2xl font-bold text-gray-900">${Number(produit.prix || 0).toLocaleString()} FCFA</span>`;
        }

        // Remplir la catégorie
        document.getElementById('modalProductCategory').textContent = produit.categorie.c_name || 'Non catégorisé';

        // Remplir le stock
        const stockContainer = document.getElementById('modalProductStock');
        const stock = produit.quantite_stock || 0;
        let stockClass = '';
        let stockText = '';

        if (stock == 0) {
            stockClass = 'bg-red-100 text-red-800';
            stockText = 'Rupture de stock';
        } else if (stock < 10) {
            stockClass = 'bg-orange-100 text-orange-800';
            stockText = `Stock faible (${stock})`;
        } else if (stock < 50) {
            stockClass = 'bg-yellow-100 text-yellow-800';
            stockText = `Stock limité (${stock})`;
        } else {
            stockClass = 'bg-green-100 text-green-800';
            stockText = `En stock (${stock})`;
        }

        stockContainer.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${stockClass}`;
        stockContainer.textContent = stockText;

        // Remplir le statut
        const statusContainer = document.getElementById('modalProductStatus');
        if (produit.p_status === 'Disponible') {
            statusContainer.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            statusContainer.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Disponible';
        } else {
            statusContainer.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            statusContainer.innerHTML = '<i class="fas fa-pause-circle mr-1"></i>Indisponible';
        }

        // Remplir la description
        const descriptionContainer = document.getElementById('modalProductDescriptionContainer');
        const description = document.getElementById('modalProductDescription');
        if (produit.p_description && produit.p_description.trim()) {
            description.textContent = produit.p_description;
            descriptionContainer.style.display = 'block';
        } else {
            descriptionContainer.style.display = 'none';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        modal.classList.add('flex');

    }

    // NOUVELLE FONCTION : Fermer le modal
    function closeProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Fonction pour appliquer les filtres
    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const selectedCategory = document.getElementById('categoryFilter').value;

        let visibleCount = 0;

        allProducts.forEach(card => {
            const productName = card.getAttribute('data-name');
            const productCategory = card.getAttribute('data-category');

            const matchesSearch = !searchTerm || productName.includes(searchTerm);
            const matchesCategory = !selectedCategory || productCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.3s ease';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Mettre à jour le compteur
        document.getElementById('visibleCount').textContent = visibleCount;

        // Afficher/masquer le message "aucun produit"
        const noProductsMessage = document.getElementById('noProductsMessage');
        const productsGrid = document.getElementById('productsGrid');

        if (visibleCount === 0) {
            noProductsMessage.classList.remove('hidden');
            productsGrid.style.display = 'none';
        } else {
            noProductsMessage.classList.add('hidden');
            productsGrid.style.display = 'grid';
        }
    }

    // Fonction pour réinitialiser les filtres
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('categoryFilter').value = '';
        applyFilters();

        // Animation de réapparition
        setTimeout(() => {
            animateCards();
        }, 100);
    }

    // Animation des cartes
    function animateCards() {
        const visibleCards = allProducts.filter(card => card.style.display !== 'none');

        visibleCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 50);
        });
    }

    // Fonction de recherche en temps réel améliorée
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Appliquer le debounce à la recherche
    const debouncedFilter = debounce(applyFilters, 300);
    document.getElementById('searchInput').addEventListener('input', debouncedFilter);

    // Gestion des raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl + F : Focus sur la recherche
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }

        // Escape : Réinitialiser les filtres ou fermer le modal
        if (e.key === 'Escape') {
            if (!document.getElementById('productModal').classList.contains('hidden')) {
                closeProductModal();
            } else {
                resetFilters();
            }
        }
    });

    // console.log('Composant Liste Produits chargé avec succès');
</script>

<style>
    /* Styles personnalisés */
    .line-clamp-2 {
        display: -webkit-box;
        /* -webkit-line-clamp: 2; */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Animation pour l'apparition des cartes */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive design amélioré */
    @media (max-width: 768px) {
        .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3.xl\\:grid-cols-4 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .product-card {
            margin-bottom: 1rem;
        }

        .grid.grid-cols-1.md\\:grid-cols-3 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        /* Modal responsive */
        #productModal .max-w-2xl {
            max-width: 95vw;
        }

        #productModal .grid-cols-1.md\\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }

    /* Amélioration des focus states */
    input:focus,
    select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Style pour le modal */
    #productModal {
        backdrop-filter: blur(4px);
    }

    /* Animation du modal */
    #productModal .bg-white {
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Print styles */
    @media print {

        .no-print,
        #productModal {
            display: none !important;
        }

        .product-card {
            break-inside: avoid;
            margin-bottom: 1rem;
        }

        .bg-gradient-to-br {
            background: white !important;
        }
    }
</style>