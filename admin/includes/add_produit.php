<?php
// Récupération des données nécessaires
$typesProduits = get_product_types();
$categories = get_categories();
$derniers_produits = get_latest_products(4); // Fonction pour récupérer les 4 derniers produits
$users = get_users(); // Fonction pour récupérer les utilisateurs (si nécessaire)
?>

<div>
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-4">
            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Ajouter un Produit
            </h1>
            <p class="mt-2 text-gray-600">Créez un nouveau produit pour votre boutique</p>
        </div>

        <!-- Bouton d'ajout et formulaire -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20 mb-2">
            <div class="p-4">
                <!-- Bouton pour afficher/masquer le formulaire -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Nouveau Produit</h2>
                    <button
                        id="toggleFormBtn"
                        onclick="toggleForm()"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium cursor-pointer flex items-center">
                        <i class="fas fa-plus mr-2" id="toggleIconadd"></i>
                        <span id="toggleText">Ajouter un Produit</span>
                    </button>
                </div>

                <!-- Formulaire d'ajout (masqué par défaut) -->
                <div id="addProductForm" class="hidden">
                    <form id="productForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom du produit -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom du produit <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="p_name"
                                    name="p_name"
                                    required
                                    placeholder="Saisissez le nom du produit..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <div class="text-red-500 text-sm mt-1 hidden" id="p_name_error"></div>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea
                                    id="p_description"
                                    name="p_description"
                                    rows="3"
                                    placeholder="Description détaillée du produit..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"></textarea>
                            </div>

                            <!-- Type de produit dans un select -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type de produit</label>
                                <select
                                    id="p_type"
                                    name="p_type"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">Sélectionner un type de produit</option>
                                    <?php foreach ($typesProduits as $type): ?>
                                        <option value="<?= htmlspecialchars($type['tp_id']) ?>">
                                            <?= htmlspecialchars($type['tp_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                                <select id="c_id" name="c_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                    <option value="">Sélectionner une catégorie</option>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Prix (FCFA) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="prix"
                                    name="prix"
                                    required
                                    min="0"
                                    step="0.01"
                                    placeholder="0.00"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <div class="text-red-500 text-sm mt-1 hidden" id="prix_error"></div>
                            </div>

                            <!-- Quantité en stock -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantité en stock <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="quantite_stock"
                                    name="quantite_stock"
                                    required
                                    min="0"
                                    placeholder="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <div class="text-red-500 text-sm mt-1 hidden" id="quantite_stock_error"></div>
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                                <select
                                    id="p_status"
                                    name="p_status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="Disponible" selected>Disponible</option>
                                    <option value="Indisponible">Indisponible</option>
                                    <option value="En rupture">En rupture</option>
                                </select>
                            </div>

                            <!-- Section Promotion -->
                            <div class="md:col-span-2">
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex items-center mb-4">
                                        <input
                                            type="checkbox"
                                            id="est_en_promotion"
                                            name="est_en_promotion"
                                            value="1"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="est_en_promotion" class="ml-2 block text-sm font-medium text-gray-700">
                                            Ce produit est en promotion
                                        </label>
                                    </div>

                                    <div id="promotionFields" class="hidden grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Prix promotionnel -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Prix promotionnel (FCFA)
                                            </label>
                                            <input
                                                type="number"
                                                id="prix_promotionnel"
                                                name="prix_promotionnel"
                                                min="0"
                                                step="0.1"
                                                placeholder="0.00"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        </div>

                                        <!-- Date début promotion -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Date début promotion
                                            </label>
                                            <input
                                                type="date"
                                                min="<?php echo date('Y-m-d'); ?>"
                                                id="date_debut_promotion"
                                                name="date_debut_promotion"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        </div>

                                        <!-- Date fin promotion -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Date fin promotion
                                            </label>
                                            <input
                                                type="date"
                                                id="date_fin_promotion"
                                                name="date_fin_promotion"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image du produit -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image du produit</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="p_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="imageUploadArea">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                                        </div>
                                        <input id="p_image" name="p_image" type="file" accept="image/*" class="hidden" />
                                    </label>
                                </div>
                                <div id="imagePreview" class="mt-4 hidden">
                                    <img id="previewImg" src="" alt="Aperçu" class="w-32 h-32 object-cover rounded-lg border">
                                    <button type="button" onclick="removeImage()" class="mt-2 text-red-600 text-sm hover:text-red-800">
                                        <i class="fas fa-trash mr-1"></i>Supprimer l'image
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                            <button
                                type="button"
                                onclick="resetForm()"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-all duration-200 font-medium cursor-pointer">
                                <i class="fas fa-undo mr-2"></i>
                                Réinitialiser
                            </button>
                            <button
                                type="submit"
                                id="submitBtn"
                                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition-all duration-200 font-medium cursor-pointer flex items-center">
                                <i class="fas fa-save mr-2" id="submitIcon"></i>
                                <span id="submitText">Enregistrer le Produit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section des derniers produits ajoutés -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20">
            <div class="p-4" id="derniers-produits">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-history mr-2 text-blue-600"></i>
                        Derniers Produits Ajoutés
                    </h2>
                </div>

                <?php if (empty($derniers_produits)): ?>
                    <!-- Message si aucun produit -->
                    <div class="text-center py-12" id="noRecentProductsMessage">
                        <i class="fas fa-box text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit encore</h3>
                        <p class="text-gray-600">Les derniers produits ajoutés apparaîtront ici.</p>
                    </div>
                <?php else: ?>
                    <!-- Grille des derniers produits -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="recentProductsGrid">
                        <?php foreach ($derniers_produits as $produit): ?>
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
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Bouton d'ajout et formulaire -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20 mb-2 mt-4">
            <div class="p-4">
                <!-- Bouton pour afficher/masquer le formulaire -->
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Consulter tout les Produits</h2>
                    <a
                        id="AvoirTout"
                        href="/admin/products"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium cursor-pointer flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        <span id="toggleText"> Voir tout ... </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Styles pour les cartes des produits récents */
    .recent-product-card {
        transition: all 0.2s ease;
    }

    .recent-product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Amélioration des champs de formulaire */
    input:focus,
    textarea:focus,
    select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Style pour la zone de drop d'image */
    .border-dashed {
        transition: all 0.2s ease;
    }

    .border-dashed:hover {
        border-color: #3B82F6;
        background-color: #EFF6FF;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .grid.grid-cols-1.md\\:grid-cols-2 {
            grid-template-columns: 1fr;
        }

        .grid.grid-cols-1.md\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .recent-product-card {
            margin-bottom: 1rem;
        }

        /* Ajustements pour les boutons sur mobile */
        .flex.justify-end.space-x-4 {
            flex-direction: column;
        }

        .flex.justify-end.space-x-4>* {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }

    /* Amélioration de l'accessibilité */
    .cursor-pointer:focus {
        outline: 2px solid #3B82F6;
        outline-offset: 2px;
    }

    /* Animation pour les badges */
    .badge-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
        }
    }

    /* Styles pour les états de validation */
    .field-valid {
        border-color: #10B981;
    }

    .field-invalid {
        border-color: #EF4444;
    }

    /* Loading spinner personnalisé */
    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Amélioration des tooltips */
    [title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1F2937;
        color: white;
        padding: 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 1000;
    }

    /* Print styles */
    @media print {

        .no-print,
        #notification,
        button {
            display: none !important;
        }

        .recent-product-card {
            break-inside: avoid;
            margin-bottom: 1rem;
        }

        .bg-gradient-to-r {
            background: white !important;
            color: black !important;
        }
    }
</style>

<script>
    // requete pour mettre à jour la liste des catégories en fonction du type de produit
    document.getElementById('p_type').addEventListener('change', function() {
        //console.log(this.value);

        let typeId = this.value;

        fetch('get_categories.php?type_id=' + typeId)
            .then(response => response.json())
            .then(data => {
                let selectCategorie = document.getElementById('c_id');
                selectCategorie.innerHTML = '<option value="">Sélectionner une catégorie</option>';
                data.forEach(cat => {
                    let option = document.createElement('option');
                    option.value = cat.c_id;
                    option.textContent = cat.c_name;
                    selectCategorie.appendChild(option);
                });
            })
            .catch(err => console.error(err));
    });

    // Date de fin minimale
    document.getElementById('date_fin_promotion').min = document.getElementById('date_debut_promotion').value;
    document.getElementById('date_debut_promotion').addEventListener('change', function() {
        // on change la veleur de la date de fin de promotion en fonction de la date de debut
        document.getElementById('date_fin_promotion').value = '';
        document.getElementById('date_fin_promotion').min = this.value;
    });

    // Variables globales
    let isFormVisible = false;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners
        document.getElementById('est_en_promotion').addEventListener('change', togglePromotionFields);
        document.getElementById('p_image').addEventListener('change', handleImageUpload);
        document.getElementById('productForm').addEventListener('submit', handleFormSubmit);

        // Validation en temps réel
        setupRealtimeValidation();
    });

    // Toggle du formulaire
    function toggleForm() {
        const form = document.getElementById('addProductForm');
        const btn = document.getElementById('toggleFormBtn');
        const icon = document.getElementById('toggleIconadd');
        const text = document.getElementById('toggleText');

        if (isFormVisible) {
            // Masquer le formulaire
            form.classList.add('hidden');
            icon.className = 'fas fa-plus mr-2';
            text.textContent = 'Ajouter un Produit';
            btn.className = btn.className.replace('from-red-600 to-red-700 hover:from-red-700 hover:to-red-800', 'from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700');
        } else {
            // Afficher le formulaire
            form.classList.remove('hidden');
            form.style.animation = 'slideDown 0.3s ease-out';
            icon.className = 'fas fa-times mr-2';
            text.textContent = 'Annuler';
            btn.className = btn.className.replace('from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700', 'from-red-600 to-red-700 hover:from-red-700 hover:to-red-800');
        }

        isFormVisible = !isFormVisible;
    }

    // Toggle des champs de promotion
    function togglePromotionFields() {
        const checkbox = document.getElementById('est_en_promotion');
        const fields = document.getElementById('promotionFields');
        const requiredFields = ['prix_promotionnel', 'date_debut_promotion', 'date_fin_promotion'];

        if (checkbox.checked) {
            fields.classList.remove('hidden');
            fields.classList.add('grid');
            fields.style.animation = 'fadeIn 0.3s ease-out';

            // Rendre les champs requis
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) field.setAttribute('required', 'required');
            });
        } else {
            fields.classList.add('hidden');

            // Supprimer les requis et vider les champs
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.removeAttribute('required');
                    field.value = '';
                }
            });
        }
    }

    // Gestion de l'upload d'image
    function handleImageUpload(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (file) {
            // Validation du fichier
            if (!file.type.startsWith('image/')) {
                showNotification('Veuillez sélectionner un fichier image valide.', 'error');
                event.target.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) { // 2MB
                showNotification('L\'image ne doit pas dépasser 2MB.', 'error');
                event.target.value = '';
                return;
            }

            // Afficher l'aperçu
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    // Supprimer l'image
    function removeImage() {
        document.getElementById('p_image').value = '';
        document.getElementById('imagePreview').classList.add('hidden');
    }

    // Validation en temps réel
    function setupRealtimeValidation() {
        const requiredFields = [{
                id: 'p_name',
                message: 'Le nom du produit est requis'
            },
            {
                id: 'prix',
                message: 'Le prix est requis'
            },
            {
                id: 'quantite_stock',
                message: 'La quantité en stock est requise'
            }
        ];

        requiredFields.forEach(field => {
            const input = document.getElementById(field.id);
            const errorDiv = document.getElementById(field.id + '_error');

            if (input && errorDiv) {
                input.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        errorDiv.textContent = field.message;
                        errorDiv.classList.remove('hidden');
                        this.classList.add('border-red-500');
                    } else {
                        errorDiv.classList.add('hidden');
                        this.classList.remove('border-red-500');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        errorDiv.classList.add('hidden');
                        this.classList.remove('border-red-500');
                    }
                });
            }
        });
    }

    async function handleFormSubmit(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        // État de chargement
        submitBtn.disabled = true;
        submitIcon.className = 'fas fa-spinner fa-spin mr-2';
        submitText.textContent = 'Enregistrement...';

        // console.log("Début de soumission");

        const isValid = await checkTokenOnly();
        if (!isValid) {
            showNotification('Session expirée. Veuillez vous reconnecter.', 'error');

            // recharger la page après 2 secondes
            setTimeout(() => {
                location.reload();
            }, 2000);
            return;
        } else {

            try {
                const form = event.target;
                const formData = new FormData(form);

                // on mets les dates au format datetime
                const dateDebutPromotion = formData.get('date_debut_promotion');
                const dateFinPromotion = formData.get('date_fin_promotion');
                if (dateDebutPromotion) {
                    formData.set('date_debut_promotion', dateDebutPromotion + ' 00:00:00');
                }
                if (dateFinPromotion) {
                    formData.set('date_fin_promotion', dateFinPromotion + ' 23:59:59');
                }

                // Debug: Afficher le contenu de formData
                // console.log("=== Contenu du FormData ===");
                // for (let [key, value] of formData.entries()) {
                //    console.log(`${key}:`, value);
                // }


                // Validation côté client avant envoi
                const requiredFields = ['p_name', 'prix', 'quantite_stock'];
                let hasErrors = false;

                for (let field of requiredFields) {
                    const value = formData.get(field);
                    if (!value || (typeof value === 'string' && value.trim() === '')) {
                        // console.error(`Champ requis manquant: ${field}`);
                        showNotification(`Le champ ${field} est requis`, 'error');
                        hasErrors = true;
                        break;
                    }
                }

                if (hasErrors) {
                    return;
                }

                // Validation spéciale pour la promotion
                const estEnPromotion = formData.get('est_en_promotion');
                if (estEnPromotion) {
                    const prixPromotionnel = formData.get('prix_promotionnel');
                    const dateDebut = formData.get('date_debut_promotion');
                    const dateFin = formData.get('date_fin_promotion');

                    if (!prixPromotionnel || !dateDebut || !dateFin) {
                        showNotification('Tous les champs de promotion sont requis', 'error');
                        return;
                    }

                    // Vérifier que le prix promotionnel est inférieur au prix normal
                    const prixNormal = parseFloat(formData.get('prix'));
                    const prixPromo = parseFloat(prixPromotionnel);

                    if (prixPromo >= prixNormal) {
                        showNotification('Le prix promotionnel doit être inférieur au prix normal', 'error');
                        return;
                    }
                }

                // console.log("Envoi de la requête vers:", API_URL + '/produit');

                // Vérifier que API_URL est défini
                if (typeof API_URL === 'undefined') {
                    throw new Error('API_URL n\'est pas défini');
                }

                // Vérifier le token
                const token = localStorage.getItem('token');
                if (!token) {
                    throw new Error('Token d\'authentification manquant');
                }

                const response = await fetch(API_URL + 'produit', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                });

                // console.log("Réponse reçue:", response.status, response.statusText);

                if (response.ok) {
                    const result = await response.json();
                    console.log("Résultat:", result);

                    // actualiser la liste des produits
                    refreshRecentProducts();

                    // Afficher la notification
                    showNotification('Produit ajouté avec succès !', 'success');

                    // Réinitialiser le formulaire
                    resetForm();

                    // Masquer le formulaire
                    if (isFormVisible) toggleForm();

                } else {
                    // Gestion des erreurs HTTP
                    const contentType = response.headers.get('content-type');
                    let errorMessage = 'Erreur lors de l\'ajout du produit';

                    if (contentType && contentType.includes('application/json')) {
                        try {
                            const error = await response.json();
                            errorMessage = error.message || error.error || errorMessage;
                            console.error("Erreur du serveur:", error);
                        } catch (parseError) {
                            console.error("Impossible de parser l'erreur JSON:", parseError);
                        }
                    } else {
                        const errorText = await response.text();
                        console.error("Réponse d'erreur (text):", errorText);
                        errorMessage = `Erreur HTTP ${response.status}: ${response.statusText}`;
                    }

                    throw new Error(errorMessage);
                }

            } catch (error) {
                console.error('Erreur complète:', error);

                let userMessage = 'Une erreur est survenue';

                if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    userMessage = 'Erreur de connexion au serveur. Vérifiez votre connexion internet.';
                } else if (error.message) {
                    userMessage = error.message;
                }

                showNotification(userMessage, 'error');

            } finally {
                // Restaurer l'état du bouton
                submitBtn.disabled = false;
                submitIcon.className = 'fas fa-save mr-2';
                submitText.textContent = 'Enregistrer le Produit';
            }
        }
    }

    // Réinitialiser le formulaire
    function resetForm() {
        document.getElementById('productForm').reset();
        document.getElementById('promotionFields').classList.add('hidden');
        document.getElementById('imagePreview').classList.add('hidden');

        // Supprimer les messages d'erreur
        document.querySelectorAll('[id$="_error"]').forEach(error => {
            error.classList.add('hidden');
        });

        // Supprimer les bordures d'erreur
        document.querySelectorAll('.border-red-500').forEach(input => {
            input.classList.remove('border-red-500');
        });
    }

    // Fonction principale pour actualiser les produits récents
    function refreshRecentProducts(attributName = null) {
        // Afficher un indicateur de chargement (optionnel)

        const grid = document.getElementById('recentProductsGrid');

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

                        // console.log(`${data.count} produits chargés`);
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