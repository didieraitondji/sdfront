<!-- Modal pour les détails du produit - CORRIGÉ -->
<div id="productModal" class="hidden cursor-pointer fixed inset-0 z-50 items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="bg-white rounded-xl cursor-default max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <!-- En-tête du modal -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900" id="modalProductName">Détails du produit</h2>
            <button onclick="closeProductModal()" class="text-gray-500 cursor-pointer hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image du produit -->
                <div class="space-y-4">
                    <div id="modalProductImage" class="w-full h-64 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                </div>

                <!-- Informations du produit -->
                <div class="space-y-6">
                    <!-- Prix -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 mb-2">Prix</h3>
                        <div id="modalProductPrice" class="text-2xl font-bold text-gray-900">
                            299,99 €
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 mb-2">Catégorie</h3>
                        <span id="modalProductCategory" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Électronique
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Stock -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-2">Stock</h3>
                            <span id="modalProductStock" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                En stock
                            </span>
                        </div>

                        <!-- Statut -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-2">Statut</h3>
                            <span id="modalProductStatus" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Actif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description complète -->
            <div class="mt-6 bg-gray-100 p-4 rounded-lg" id="modalProductDescriptionContainer">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Description</h3>
                <p id="modalProductDescription" class="text-gray-700 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>

        <!-- Pied du modal -->
        <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
            <button
                onclick="closeProductModal()"
                class="px-4 py-2 cursor-pointer bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-all duration-200">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
    // Fonction principale pour actualiser les produits récents
    function refreshRecentProducts(attributName = null) {
        // Afficher un indicateur de chargement (optionnel)

        const grid = document.getElementById('productsGrid');

        if (attributName) {
            grid = document.getElementById(attributName);
        }

        if (grid) {
            const originalContent = grid.innerHTML;

            // Indicateur de chargement
            grid.innerHTML = `
        <div class="col-span-full flex items-center justify-center py-8">
            <div class="flex items-center space-x-2">
                <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-500">Actualisation...</span>
            </div>
        </div>`;

            // Requête AJAX vers votre fichier PHP
            fetch('get_recent_products.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remplacer le contenu du div avec le nouveau HTML
                        grid.innerHTML = data.html;

                        // Animation d'apparition (optionnel)
                        grid.style.opacity = '0';
                        setTimeout(() => {
                            grid.style.transition = 'opacity 0.3s ease';
                            grid.style.opacity = '1';
                        }, 10);

                        console.log(`${data.count} produits chargés`);
                    } else {
                        throw new Error(data.message || 'Erreur inconnue');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du rafraîchissement:', error);

                    // Restaurer le contenu original en cas d'erreur
                    grid.innerHTML = originalContent;

                    // Afficher un message d'erreur (optionnel)
                    showNotification('Erreur lors du rafraîchissement des produits', 'error');
                });
        } else {

            // on supprime noRecentProductsMessage
            const noRecentProductsMessage = document.getElementById('noRecentProductsMessage');
            if (noRecentProductsMessage) {
                noRecentProductsMessage.remove();
            }

            // on crée le conteneur pour les produits récents
            const newGrid = document.createElement('div');
            newGrid.id = 'recentProductsGrid';
            newGrid.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6';

            const container = document.getElementById('derniers-produits');
            if (container) {
                container.appendChild(newGrid);
            }

            // on rappelle la fonction pour actualiser les produits récents
            refreshRecentProducts();
        }
    }
</script>