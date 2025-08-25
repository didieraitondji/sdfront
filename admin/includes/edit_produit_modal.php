<?php
$typesProduits = get_product_types();
?>

<!-- Modal de modification -->
<div id="editModal" class="hidden cursor-pointer fixed inset-0 z-50 items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="bg-white cursor-default rounded-xl max-w-4xl w-full max-h-[92vh] ">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Modifier le Produit</h2>
                <button onclick="closeEditModal()" class="text-gray-400 cursor-pointer hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="editProductForm" enctype="multipart/form-data">
                <div class="overflow-y-auto w-[98%] mx-auto max-h-[65vh]" id="editModalContent">
                    <!-- Formulaire de modification -->

                    <input type="hidden" id="edit_product_id" name="product_id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom du produit -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du produit <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="edit_p_name"
                                name="p_name"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea
                                id="edit_p_description"
                                name="p_description"
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                        </div>

                        <!-- Type de produit -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de produit</label>
                            <select id="edit_p_type" name="p_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
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
                            <select id="edit_c_id" name="c_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
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
                                id="edit_prix"
                                name="prix"
                                required
                                min="0"
                                step="0.01"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Quantité en stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Quantité en stock <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="edit_quantite_stock"
                                name="quantite_stock"
                                required
                                min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="edit_p_status" name="p_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Disponible">Disponible</option>
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
                                        id="edit_est_en_promotion"
                                        name="est_en_promotion"
                                        value="1"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="edit_est_en_promotion" class="ml-2 block text-sm font-medium text-gray-700">
                                        Ce produit est en promotion
                                    </label>
                                </div>

                                <div id="editPromotionFields" class="hidden grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Prix promotionnel -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix promotionnel (FCFA)</label>
                                        <input
                                            type="number"
                                            id="edit_prix_promotionnel"
                                            name="prix_promotionnel"
                                            min="0"
                                            step="0.1"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <!-- Date début promotion -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date début promotion</label>
                                        <input
                                            type="date"
                                            id="edit_date_debut_promotion"
                                            name="date_debut_promotion"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <!-- Date fin promotion -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date fin promotion</label>
                                        <input
                                            type="date"
                                            id="edit_date_fin_promotion"
                                            name="date_fin_promotion"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image actuelle et nouvelle image -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image du produit</label>

                            <div class=" flex gap-6 ">
                                <!-- Image actuelle -->
                                <div id="currentImageContainer" class="mb-4 hidden">
                                    <p class="text-sm text-gray-600 mb-2">Image actuelle :</p>
                                    <img id="currentImage" src="" alt="Image actuelle" class="w-32 h-32 object-cover rounded-lg border">
                                </div>

                                <div id="editImagePreview" class="hidden">
                                    <p class="text-sm text-gray-600 mb-2">Nouvelle image :</p>
                                    <div class="relative inline-block">
                                        <img id="editPreviewImg" src="" alt="Aperçu" class="w-32 h-32 object-cover rounded-lg border">
                                        <button type="button" onclick="removeEditImage()" class="absolute bottom-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer transition-colors">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload nouvelle image -->
                            <div class="flex items-center justify-center w-full">
                                <label for="edit_p_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Nouvelle image</span> (optionnel)
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                                    </div>
                                    <input id="edit_p_image" name="p_image" type="file" accept="image/*" class="hidden" />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-6 py-3 cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-all duration-200 font-medium">
                        Annuler
                    </button>
                    <button
                        type="submit"
                        id="editSubmitBtn"
                        class="px-6 py-3 cursor-pointer bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2" id="editSubmitIcon"></i>
                        <span id="editSubmitText">Modifier le Produit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Style pour le modal */
    #editModal {
        backdrop-filter: blur(4px);
    }

    /* Animation du modal */
    #editModal .bg-white {
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

<script>
    // Date de fin minimale edit
    document.getElementById('edit_date_fin_promotion').min = document.getElementById('edit_date_debut_promotion').value;
    document.getElementById('edit_date_debut_promotion').addEventListener('change', function() {
        document.getElementById('edit_date_fin_promotion').value = '';
        document.getElementById('edit_date_fin_promotion').min = this.value;
    });

    // code pour la modification d'un produit
    // Fonction pour ouvrir le modal de modification
    function openEditModal(produit) {
        // Remplir les champs du formulaire
        document.getElementById('edit_product_id').value = produit.p_id || '';
        document.getElementById('edit_p_name').value = produit.p_name || '';
        document.getElementById('edit_p_description').value = produit.p_description || '';
        document.getElementById('edit_p_type').value = produit.p_type || '';
        document.getElementById('edit_prix').value = produit.prix || '';
        document.getElementById('edit_quantite_stock').value = produit.quantite_stock || '';
        document.getElementById('edit_p_status').value = produit.p_status || 'Disponible';

        // Gérer la promotion
        const isPromo = produit.est_en_promotion == '1' || produit.est_en_promotion === true;
        document.getElementById('edit_est_en_promotion').checked = isPromo;

        if (isPromo) {
            document.getElementById('editPromotionFields').classList.remove('hidden');
            document.getElementById('editPromotionFields').classList.add('grid');
            document.getElementById('edit_prix_promotionnel').value = produit.prix_promotionnel || '';

            // Formater les dates
            if (produit.date_debut_promotion) {
                const dateDebut = new Date(produit.date_debut_promotion);
                document.getElementById('edit_date_debut_promotion').value = dateDebut.toISOString().split('T')[0];
            }
            if (produit.date_fin_promotion) {
                const dateFin = new Date(produit.date_fin_promotion);
                document.getElementById('edit_date_fin_promotion').value = dateFin.toISOString().split('T')[0];
            }
        }

        // Gérer l'image actuelle
        if (produit.p_image) {
            document.getElementById('currentImage').src = produit.p_image;
            document.getElementById('currentImageContainer').classList.remove('hidden');
        } else {
            document.getElementById('currentImageContainer').classList.add('hidden');
        }

        // Charger les catégories pour le type sélectionné
        if (produit.p_type) {
            loadCategoriesForEdit(produit.p_type, produit.c_id);
        }

        // Afficher le modal
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');

        // Plus propre que setTimeout
        requestAnimationFrame(() => {
            document.getElementById('editModalContent').scrollTop = 0;
        });
    }

    // Fonction pour charger les catégories dans le modal de modification
    function loadCategoriesForEdit(typeId, selectedCategoryId = null) {
        fetch('get_categories.php?type_id=' + typeId)
            .then(response => response.json())
            .then(data => {
                let selectCategorie = document.getElementById('edit_c_id');
                selectCategorie.innerHTML = '<option value="">Sélectionner une catégorie</option>';
                data.forEach(cat => {
                    let option = document.createElement('option');
                    option.value = cat.c_id;
                    option.textContent = cat.c_name;
                    if (selectedCategoryId && cat.c_id == selectedCategoryId) {
                        option.selected = true;
                    }
                    selectCategorie.appendChild(option);
                });
            })
            .catch(err => console.error(err));
    }

    // Fonction pour fermer le modal de modification
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editProductForm').reset();
        document.getElementById('editPromotionFields').classList.add('hidden');
        document.getElementById('editImagePreview').classList.add('hidden');
        document.getElementById('currentImageContainer').classList.add('hidden');
    }

    // Fonction pour supprimer un produit avec SweetAlert
    function deleteProduit(productId, productName) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: `Voulez-vous vraiment supprimer le produit "${productName}" ? Cette action est irréversible.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(productId, productName);
            }
        });
    }

    // Fonction pour effectuer la suppression
    async function performDelete(productId, productName) {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token d\'authentification manquant');
            }

            const response = await fetch(API_URL + 'produit/' + productId, {
                method: 'DELETE',
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                }
            });

            if (response.ok) {
                // recharger la liste des produits
                refreshRecentProducts();

                // afficher la notification de succès
                showNotification(`Produit "${productName}" supprimé avec succès !`, 'success');
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

    // Gestion de l'image dans le modal de modification
    function removeEditImage() {
        document.getElementById('edit_p_image').value = '';
        document.getElementById('editImagePreview').classList.add('hidden');
    }

    // Event listeners pour le modal de modification
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle promotion fields dans le modal de modification
        document.getElementById('edit_est_en_promotion').addEventListener('change', function() {
            const fields = document.getElementById('editPromotionFields');
            if (this.checked) {
                fields.classList.remove('hidden');
                fields.classList.add('grid');
            } else {
                fields.classList.add('hidden');
            }
        });

        // gestion du checked de edit_est_en_promotion
        document.getElementById('edit_est_en_promotion').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('edit_prix_promotionnel').setAttribute('required', 'required');
                document.getElementById('edit_date_debut_promotion').setAttribute('required', 'required');
                document.getElementById('edit_date_fin_promotion').setAttribute('required', 'required');
            } else {
                document.getElementById('edit_prix_promotionnel').removeAttribute('required');
                document.getElementById('edit_date_debut_promotion').removeAttribute('required');
                document.getElementById('edit_date_fin_promotion').removeAttribute('required');
            }
        });

        // si l'utilsateur tente au moins une fois de modifier le prix_promotionnel, on mets également les trois champs à required
        document.getElementById('edit_prix_promotionnel').addEventListener('change', function() {
            if (document.getElementById('edit_est_en_promotion').checked) {
                document.getElementById('edit_prix_promotionnel').setAttribute('required', 'required');
                document.getElementById('edit_date_debut_promotion').setAttribute('required', 'required');
                document.getElementById('edit_date_fin_promotion').setAttribute('required', 'required');
            } else {
                document.getElementById('edit_prix_promotionnel').removeAttribute('required');
                document.getElementById('edit_date_debut_promotion').removeAttribute('required');
                document.getElementById('edit_date_fin_promotion').removeAttribute('required');
            }
        });

        // Gestion du changement de type de produit dans le modal
        document.getElementById('edit_p_type').addEventListener('change', function() {
            if (this.value) {
                loadCategoriesForEdit(this.value);
            } else {
                document.getElementById('edit_c_id').innerHTML = '<option value="">Sélectionner une catégorie</option>';
            }
        });

        // Gestion de l'upload d'image dans le modal
        document.getElementById('edit_p_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('editImagePreview');
            const previewImg = document.getElementById('editPreviewImg');

            if (file) {
                if (!file.type.startsWith('image/')) {
                    showNotification('Veuillez sélectionner un fichier image valide.', 'error');
                    event.target.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    showNotification('L\'image ne doit pas dépasser 2MB.', 'error');
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
        });

        // Soumission du formulaire de modification
        document.getElementById('editProductForm').addEventListener('submit', handleEditSubmit);
    });



    // Fonction pour gérer la soumission du formulaire de modification
    async function handleEditSubmit(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('editSubmitBtn');
        const submitIcon = document.getElementById('editSubmitIcon');
        const submitText = document.getElementById('editSubmitText');

        // État de chargement
        submitBtn.disabled = true;
        submitIcon.className = 'fas fa-spinner fa-spin mr-2';
        submitText.textContent = 'Modification...';

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

                // on controle pour voir si le prix promotionnel n'est pas supérieur au prix normal
                const prixNormal = parseFloat(document.getElementById('edit_prix').value);
                const prixPromotionnel = parseFloat(document.getElementById('edit_prix_promotionnel').value);
                const estEnPromotion = document.getElementById('edit_est_en_promotion').checked;

                if (estEnPromotion && prixPromotionnel > prixNormal) {
                    throw new Error('Le prix promotionnel ne peut pas être supérieur au prix normal.');
                }

                let formData = new FormData(document.getElementById('editProductForm'));
                let productId = document.getElementById('edit_product_id').value;
                if (!productId) {
                    throw new Error('ID du produit manquant');
                }

                // convertir produitId en entier
                productId = parseInt(productId);

                // variable de est_en_promotion
                let promo = document.getElementById('edit_est_en_promotion').checked ? '1' : '0';

                // Gestion de la promotion
                if (promo === '0') {
                    // on ajoute est_en_promotion au formData
                    formData.append('est_en_promotion', 0);
                }


                if (promo === '1') {

                    formData.set('est_en_promotion', 1);

                    // Formater les dates seulement si elles existent
                    const dateDebutPromotion = formData.get('date_debut_promotion');
                    const dateFinPromotion = formData.get('date_fin_promotion');

                    if (dateDebutPromotion) {
                        formData.set('date_debut_promotion', dateDebutPromotion + ' 00:00:00');
                    }
                    if (dateFinPromotion) {
                        formData.set('date_fin_promotion', dateFinPromotion + ' 23:59:59');
                    }
                }

                // Debug: Afficher le contenu de formData
                console.log("=== Contenu du FormData ===");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}:`, value);
                }

                const token = localStorage.getItem('token');
                if (!token) {
                    throw new Error('Token d\'authentification manquant');
                }

                const response = await fetch(API_URL + 'produit/' + productId, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                });

                console.log('Réponse de la modification:', response);

                if (response.ok) {
                    const result = await response.json();
                    console.log('Résultat:', result);

                    // actualiser la liste des produits
                    if (typeof refreshRecentProducts === 'function') {
                        refreshRecentProducts();
                    }

                    // afficher la notification
                    if (typeof showNotification === 'function') {
                        showNotification('Produit modifié avec succès !', 'success');
                    }

                    // fermer le modal
                    closeEditModal();
                } else {
                    const errorText = await response.text();
                    console.error('Erreur API:', errorText);

                    let errorMessage = 'Erreur lors de la modification';
                    try {
                        const error = JSON.parse(errorText);
                        errorMessage = error.message || errorMessage;
                    } catch (e) {
                        errorMessage = errorText || errorMessage;
                    }

                    throw new Error(errorMessage);
                }

            } catch (error) {
                console.error('Erreur complète:', error);

                if (typeof showNotification === 'function') {
                    showNotification(error.message || 'Une erreur est survenue', 'error');
                } else {
                    alert(error.message || 'Une erreur est survenue');
                }

            } finally {
                submitBtn.disabled = false;
                submitIcon.className = 'fas fa-save mr-2';
                submitText.textContent = 'Modifier le Produit';
            }
        }
    }
</script>