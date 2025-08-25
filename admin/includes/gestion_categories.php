<?php
// Récupération des données nécessaires
$typesProduits = get_product_types();
$categories = get_recent_categories();
$users = get_users();

// Statistiques des catégories
$total_categories = count($categories);
$categories_actives = count(array_filter($categories, function ($cat) {
    return $cat['c_status'] === 'Active';
}));
$categories_inactives = $total_categories - $categories_actives;
?>

<div>
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-2">
            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Gestion des Catégories
            </h1>
            <p class="mt-2 text-gray-600">Gérez les catégories de votre boutique</p>
        </div>

        <!-- Bouton d'ajout et formulaire -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20">
            <div class="p-6">
                <!-- Bouton pour afficher/masquer le formulaire -->
                <div class="flex justify-end items-center mb-4">
                    <button
                        id="toggleFormBtn"
                        onclick="toggleForm()"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium cursor-pointer flex items-center">
                        <i class="fas fa-plus mr-2" id="toggleIconadd"></i>
                        <span id="toggleText">Ajouter une Catégorie</span>
                    </button>
                </div>

                <!-- Formulaire d'ajout (masqué par défaut) -->
                <div id="addCategoryForm" class="hidden">
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Nouvelle Catégorie</h2>
                        <p class="text-sm text-gray-600">Remplissez les informations ci-dessous pour créer une nouvelle catégorie</p>
                    </div>

                    <form id="categoryForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom de la catégorie -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom de la catégorie <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="c_name"
                                    name="c_name"
                                    required
                                    placeholder="Saisissez le nom de la catégorie..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <div class="text-red-500 text-sm mt-1 hidden" id="c_name_error"></div>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea
                                    id="c_description"
                                    name="c_description"
                                    rows="3"
                                    placeholder="Description détaillée de la catégorie..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"></textarea>
                            </div>

                            <!-- Type de produit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de produit <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="tp_id"
                                    name="tp_id"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">Sélectionner un type de produit</option>
                                    <?php foreach ($typesProduits as $type): ?>
                                        <option value="<?= htmlspecialchars($type['tp_id']) ?>">
                                            <?= htmlspecialchars($type['tp_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="tp_id_error"></div>
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                                <select
                                    id="c_status"
                                    name="c_status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Image de la catégorie -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image de la catégorie</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="c_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="imageUploadArea">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                                        </div>
                                        <input id="c_image" name="c_image" type="file" accept="image/*" class="hidden" />
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
                                <span id="submitText">Enregistrer la Catégorie</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des catégories -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl border border-white/20">
            <div class="p-4">
                <!-- En-tête avec recherche et filtres -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-2">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-list mr-2 text-blue-600"></i>
                        Liste des Catégories
                    </h2>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Barre de recherche -->
                        <div class="relative">
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Rechercher une catégorie..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 w-full sm:w-64">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- Filtre par type de produit -->
                        <select
                            id="typeFilter"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Tous les types</option>
                            <?php foreach ($typesProduits as $type): ?>
                                <option value="<?= htmlspecialchars($type['tp_id']) ?>">
                                    <?= htmlspecialchars($type['tp_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Filtre par statut -->
                        <select
                            id="statusFilter"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Tous les statuts</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Tableau des catégories -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="categoriesTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    N°
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="categoriesTableBody">
                            <?php if (empty($categories)): ?>
                                <tr id="noCategoriesRow">
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <i class="fas fa-tags text-gray-400 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune catégorie trouvée</h3>
                                        <p class="text-gray-600">Commencez par ajouter votre première catégorie.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $categorie): ?>
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
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between mt-2 pt-4 border-t">
                    <div class="text-sm text-gray-500" id="tableInfo">
                        Affichage de <span id="visibleCount"><?= count($categories) ?></span> sur <span id="totalCount"><?= count($categories) ?></span> catégories
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles existants... */
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

    .stats-card {
        transition: all 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    input:focus,
    textarea:focus,
    select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .border-dashed {
        transition: all 0.2s ease;
    }

    .border-dashed:hover {
        border-color: #3B82F6;
        background-color: #EFF6FF;
    }

    .category-row {
        transition: all 0.15s ease;
    }

    .category-row.hidden {
        display: none;
    }

    /* Styles pour les modals */
    .modal-overlay {
        backdrop-filter: blur(4px);
    }

    @media (max-width: 768px) {
        .grid.grid-cols-1.md\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .flex.flex-col.md\\:flex-row {
            flex-direction: column;
        }

        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }

        table {
            min-width: 800px;
        }
    }

    .field-valid {
        border-color: #10B981;
    }

    .field-invalid {
        border-color: #EF4444;
    }

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
</style>

<script>
    let isFormVisible = false;
    let allCategories = <?= json_encode($categories) ?>;
    let editingCategoryId = null;

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('c_image').addEventListener('change', handleImageUpload);
        document.getElementById('categoryForm').addEventListener('submit', handleFormSubmit);
        document.getElementById('edit_c_image').addEventListener('change', handleEditImageUpload);
        document.getElementById('editCategoryForm').addEventListener('submit', handleEditSubmit);
        document.getElementById('searchInput').addEventListener('input', filterCategories);
        document.getElementById('typeFilter').addEventListener('change', filterCategories);
        document.getElementById('statusFilter').addEventListener('change', filterCategories);
        setupRealtimeValidation();
    });

    function toggleForm() {
        const form = document.getElementById('addCategoryForm');
        const btn = document.getElementById('toggleFormBtn');
        const icon = document.getElementById('toggleIconadd');
        const text = document.getElementById('toggleText');

        if (isFormVisible) {
            form.classList.add('hidden');
            icon.className = 'fas fa-plus mr-2';
            text.textContent = 'Ajouter une Catégorie';
            btn.className = btn.className.replace('from-red-600 to-red-700 hover:from-red-700 hover:to-red-800',
                'from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700');
            isFormVisible = false;
        } else {
            form.classList.remove('hidden');
            form.style.animation = 'slideDown 0.3s ease-out';
            icon.className = 'fas fa-times mr-2';
            text.textContent = 'Fermer le Formulaire';
            btn.className = btn.className.replace('from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700',
                'from-red-600 to-red-700 hover:from-red-700 hover:to-red-800');
            isFormVisible = true;
        }
    }

    function resetForm() {
        document.getElementById('categoryForm').reset();
        document.getElementById('imagePreview').classList.add('hidden');
        clearValidationErrors();
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const uploadArea = document.getElementById('imageUploadArea');

        if (file) {
            if (file.size > 2 * 1024 * 1024) { // 2MB
                showNotification('Le fichier est trop volumineux (max 2MB)', 'error');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('c_image').value = '';
        document.getElementById('imagePreview').classList.add('hidden');
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

            console.log(isValid);

            try {
                const form = event.target;
                const formData = new FormData(form);

                const user = JSON.parse(localStorage.getItem('user'));

                // on ajoute user_id au formData
                formData.append('user_id', user.user_id);

                // Debug: Afficher le contenu de formData
                // console.log("=== Contenu du FormData ===");
                // for (let [key, value] of formData.entries()) {
                //     console.log(`${key}:`, value);
                // }

                // Validation côté client avant envoi
                const requiredFields = ['c_name', 'tp_id'];
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

                // console.log("Envoi de la requête vers:", API_URL + '/categorie');

                // Vérifier que API_URL est défini
                if (typeof API_URL === 'undefined') {
                    throw new Error('API_URL n\'est pas défini');
                }


                // Vérifier le token
                const token = localStorage.getItem('token');
                if (!token) {
                    throw new Error('Token d\'authentification manquant');
                }

                const response = await fetch(API_URL + 'categorie', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                });

                // console.log("Réponse reçue:", response.status, response.statusText);

                if (response.ok) {
                    const result = await response.json();
                    // console.log("Résultat:", result);

                    // actualiser la liste des catégories
                    refreshRecentCategories();

                    // Afficher la notification
                    showNotification('Catégorie ajoutée avec succès !', 'success');

                    // Réinitialiser le formulaire
                    resetForm();

                    // Masquer le formulaire
                    if (isFormVisible) toggleForm();

                } else {
                    // Gestion des erreurs HTTP
                    const contentType = response.headers.get('content-type');
                    let errorMessage = 'Erreur lors de l\'ajout de la catégorie';

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
                submitText.textContent = 'Enregistrer la Catégorie';
            }
        }
    }

    function validateForm() {
        let isValid = true;
        clearValidationErrors();

        const name = document.getElementById('c_name');
        const typeId = document.getElementById('tp_id');

        if (!name.value.trim()) {
            showFieldError('c_name', 'Le nom de la catégorie est requis');
            isValid = false;
        }

        if (!typeId.value) {
            showFieldError('tp_id', 'Le type de produit est requis');
            isValid = false;
        }

        return isValid;
    }

    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + '_error');

        field.classList.add('field-invalid');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    function clearValidationErrors() {
        const fields = ['c_name', 'tp_id'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(fieldId + '_error');

            field.classList.remove('field-invalid', 'field-valid');
            errorDiv.classList.add('hidden');
        });
    }

    function setupRealtimeValidation() {
        const nameField = document.getElementById('c_name');
        const typeField = document.getElementById('tp_id');

        nameField.addEventListener('input', function() {
            validateField('c_name', this.value.trim() !== '');
        });

        typeField.addEventListener('change', function() {
            validateField('tp_id', this.value !== '');
        });
    }

    function validateField(fieldId, isValid) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + '_error');

        if (isValid) {
            field.classList.remove('field-invalid');
            field.classList.add('field-valid');
            errorDiv.classList.add('hidden');
        } else {
            field.classList.remove('field-valid');
            field.classList.add('field-invalid');
        }
    }

    function filterCategories() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;

        const rows = document.querySelectorAll('.category-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const typeId = row.getAttribute('data-type-id');
            const status = row.getAttribute('data-status');

            const matchesSearch = !searchTerm || name.includes(searchTerm);
            const matchesType = !typeFilter || typeId === typeFilter;
            const matchesStatus = !statusFilter || status === statusFilter;

            if (matchesSearch && matchesType && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mettre à jour les informations de pagination
        document.getElementById('visibleCount').textContent = visibleCount;

        // Afficher/masquer la ligne "Aucune catégorie"
        const noDataRow = document.getElementById('noCategoriesRow');
        if (noDataRow) {
            if (visibleCount === 0 && rows.length > 0) {
                // Créer une ligne temporaire si elle n'existe pas
                if (!document.querySelector('.no-results-row')) {
                    const tbody = document.getElementById('categoriesTableBody');
                    const tempRow = document.createElement('tr');
                    tempRow.className = 'no-results-row';
                    tempRow.innerHTML = `
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun résultat trouvé</h3>
                            <p class="text-gray-600">Essayez de modifier vos critères de recherche.</p>
                        </td>
                    `;
                    tbody.appendChild(tempRow);
                }
            } else {
                // Supprimer la ligne temporaire si elle existe
                const tempRow = document.querySelector('.no-results-row');
                if (tempRow) {
                    tempRow.remove();
                }
            }
        }
    }

    function viewCategorie(categorie) {
        const modal = document.getElementById('viewModal');
        const content = document.getElementById('viewModalContent');

        const typeNames = <?= json_encode(array_column($typesProduits, 'tp_name', 'tp_id')) ?>;
        const typeName = typeNames[categorie.tp_id] || 'Non défini';

        content.innerHTML = `
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                        ${categorie.c_image ? 
                            `<img src="${categorie.c_image}" alt="${categorie.c_name}" class="w-full h-full object-cover">` :
                            `<div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-tag text-gray-400 text-xl"></i>
                            </div>`
                        }
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">${categorie.c_name}</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                            categorie.c_status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                        }">
                            <i class="fas ${categorie.c_status === 'Active' ? 'fa-check-circle' : 'fa-times-circle'} mr-1"></i>
                            ${categorie.c_status}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de produit</label>
                        <p class="mt-1 text-sm text-gray-900">${typeName}</p>
                    </div>
                    ${categorie.c_description ? `
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">${categorie.c_description}</p>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;

        modal.classList.remove('hidden');
        modal.style.animation = 'fadeIn 0.3s ease-out';
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    function editCategorie(categorie) {
        editingCategoryId = categorie.c_id;

        document.getElementById('edit_c_name').value = categorie.c_name || '';
        document.getElementById('edit_c_description').value = categorie.c_description || '';
        document.getElementById('edit_tp_id').value = categorie.tp_id || '';
        document.getElementById('edit_c_status').value = categorie.c_status || 'Active';

        // Afficher l'aperçu de l'image actuelle si elle existe
        if (categorie.c_image) {
            const preview = document.getElementById('editImagePreview');
            const previewImg = document.getElementById('editPreviewImg');
            previewImg.src = categorie.c_image;
            preview.classList.remove('hidden');
        }

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editImagePreview').classList.add('hidden');
        editingCategoryId = null;
    }

    function handleEditImageUpload(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('editImagePreview');
        const previewImg = document.getElementById('editPreviewImg');

        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                showNotification('Le fichier est trop volumineux (max 2MB)', 'error');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function deleteCategorie(categoryId, categoryName) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: `Voulez-vous vraiment supprimer la catégorie "${categoryName}" ? Cette action est irréversible.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(categoryId, categoryName);
            }
        });
    }

    // Fonction pour effectuer la suppression
    async function performDelete(categoryId, categoryName) {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token d\'authentification manquant');
            }

            const response = await fetch(API_URL + 'categorie/' + categoryId, {
                method: 'DELETE',
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                }
            });

            if (response.ok) {
                // recharger la liste des catégories
                refreshRecentCategories();

                // afficher la notification de succès
                showNotification(`Catégorie "${categoryName}" supprimée avec succès !`, 'success');
            } else {
                throw new Error('Erreur lors de la suppression');
            }

        } catch (error) {
            console.error('Erreur:', error);
            Swal.fire({
                title: 'Erreur !',
                text: 'Une erreur est survenue lors de la suppression du produit.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }

    function updateStats() {
        // Simuler la mise à jour des statistiques
        const totalCount = parseInt(document.getElementById('totalCategoriesCount').textContent);
        document.getElementById('totalCategoriesCount').textContent = totalCount + 1;

        const activeCount = parseInt(document.getElementById('activeCategoriesCount').textContent);
        document.getElementById('activeCategoriesCount').textContent = activeCount + 1;
    }

    // Fermer les modals en cliquant à l'extérieur
    window.addEventListener('click', function(event) {
        const viewModal = document.getElementById('viewModal');
        const editModal = document.getElementById('editModal');

        if (event.target === viewModal) {
            closeViewModal();
        }

        if (event.target === editModal) {
            closeEditModal();
        }
    });

    // Gérer la touche Escape pour fermer les modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeViewModal();
            closeEditModal();
        }
    });

    // Fonction principale pour actualiser les catégories récentes
    function refreshRecentCategories(attributName = null) {
        // Afficher un indicateur de chargement (optionnel)
        let tableBody = document.getElementById('categoriesTableBody');
        if (attributName) {
            tableBody = document.getElementById(attributName);
        }

        if (tableBody) {
            const originalContent = tableBody.innerHTML;
            // Indicateur de chargement
            tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-500">Actualisation des catégories...</span>
                    </div>
                </td>
            </tr>`;

            // Requête AJAX vers votre fichier PHP
            fetch('get_recent_categories.php', {
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
                        // Remplacer le contenu du tbody avec le nouveau HTML
                        tableBody.innerHTML = data.html;

                        // Mettre à jour les statistiques si disponibles
                        if (data.stats) {
                            const totalCount = document.getElementById('totalCategoriesCount');
                            const activeCount = document.getElementById('activeCategoriesCount');
                            const inactiveCount = document.getElementById('inactiveCategoriesCount');
                            const totalTableCount = document.getElementById('totalCount');
                            const visibleTableCount = document.getElementById('visibleCount');

                            if (totalCount) totalCount.textContent = data.stats.total || 0;
                            if (activeCount) activeCount.textContent = data.stats.active || 0;
                            if (inactiveCount) inactiveCount.textContent = data.stats.inactive || 0;
                            if (totalTableCount) totalTableCount.textContent = data.stats.total || 0;
                            if (visibleTableCount) visibleTableCount.textContent = data.stats.total || 0;
                        }

                        // Animation d'apparition (optionnel)
                        tableBody.style.opacity = '0';
                        setTimeout(() => {
                            tableBody.style.transition = 'opacity 0.3s ease';
                            tableBody.style.opacity = '1';
                        }, 10);

                        // Réinitialiser les filtres
                        document.getElementById('searchInput').value = '';
                        document.getElementById('typeFilter').value = '';
                        document.getElementById('statusFilter').value = '';

                        // console.log(`${data.count} catégories chargées`);
                    } else {
                        throw new Error(data.message || 'Erreur inconnue');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du rafraîchissement:', error);
                    // Restaurer le contenu original en cas d'erreur
                    tableBody.innerHTML = originalContent;
                    // Afficher un message d'erreur (optionnel)
                    showNotification('Erreur lors du rafraîchissement des catégories', 'error');
                });
        } else {
            // Supprimer le message "Aucune catégorie" s'il existe
            const noCategoriesMessage = document.getElementById('noCategoriesRow');
            if (noCategoriesMessage) {
                noCategoriesMessage.remove();
            }

            // Créer le conteneur pour les catégories si inexistant
            const newTableBody = document.createElement('tbody');
            newTableBody.id = 'categoriesTableBody';
            newTableBody.className = 'bg-white divide-y divide-gray-200';

            const table = document.getElementById('categoriesTable');
            if (table) {
                table.appendChild(newTableBody);
            }

            // Rappeler la fonction pour actualiser les catégories
            refreshRecentCategories();
        }
    }
</script>