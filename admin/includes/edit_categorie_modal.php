<!-- Modal de modification -->
<div id="editModal" class="hidden cursor-pointer fixed inset-0 z-50 items-center justify-center p-4 overflow-auto" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="relative top-5 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Modifier la catégorie</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="editCategoryForm" enctype="multipart/form-data">
                <div class="grid grid-cols-1 gap-4 overflow-auto h-[65vh] border-2 border-gray-100 p-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de la catégorie <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="edit_c_name"
                            name="c_name"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea
                            id="edit_c_description"
                            name="c_description"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Type de produit <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="edit_tp_id"
                                name="tp_id"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionner</option>
                                <?php foreach ($typesProduits as $type): ?>
                                    <option value="<?= htmlspecialchars($type['tp_id']) ?>">
                                        <?= htmlspecialchars($type['tp_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select
                                id="edit_c_status"
                                name="c_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image de la catégorie</label>
                        <div id="editImagePreview" class="mt-2 hidden">
                            <img id="editPreviewImg" src="" alt="Aperçu" class="w-20 h-20 object-cover rounded">
                        </div>
                        <div class="flex items-center justify-center w-full mt-2">
                            <label for="edit_c_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="imageUploadArea">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="edit_c_image" name="c_image" type="file" accept="image/*" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Annuler
                    </button>
                    <button
                        type="submit"
                        id="editSubmitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <span id="editSubmitText">Modifier</span>
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
</style>

<script>
    async function handleEditSubmit(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('editSubmitBtn');
        const submitText = document.getElementById('editSubmitText');

        // État de chargement
        submitBtn.disabled = true;
        submitText.textContent = 'Modification...';

        // Vérifier la validité du token
        const isValid = await checkTokenOnly();
        if (!isValid) {
            showNotification('Session expirée. Veuillez vous reconnecter.', 'error');

            // Recharger la page après 2 secondes
            setTimeout(() => {
                location.reload();
            }, 2000);
            return;
        }

        try {
            const form = document.getElementById('editCategoryForm');
            const formData = new FormData(form);

            const user = JSON.parse(localStorage.getItem('user'));

            // Ajouter user_id et c_id au formData
            formData.append('user_id', user.user_id);
            formData.append('c_id', editingCategoryId);

            // Debug: Afficher le contenu de formData (optionnel)
            /* console.log("=== Contenu du FormData pour modification ===");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            } */

            // Validation côté client avant envoi
            const requiredFields = ['c_name', 'tp_id'];
            let hasErrors = false;

            for (let field of requiredFields) {
                const value = formData.get(field);
                if (!value || (typeof value === 'string' && value.trim() === '')) {
                    console.error(`Champ requis manquant: ${field}`);
                    showNotification(`Le champ ${field} est requis`, 'error');
                    hasErrors = true;
                    break;
                }
            }

            if (hasErrors) {
                return;
            }

            // console.log("Envoi de la requête de modification vers:", API_URL + 'categorie/' + editingCategoryId);

            // Vérifier que API_URL est défini
            if (typeof API_URL === 'undefined') {
                throw new Error('API_URL n\'est pas défini');
            }

            // Vérifier le token
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token d\'authentification manquant');
            }

            // Requête POST pour la modification
            const response = await fetch(API_URL + 'categorie/' + editingCategoryId, {
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

                refreshRecentCategories();

                // Afficher la notification de succès
                showNotification('Catégorie modifiée avec succès!', 'success');

                // Fermer le modal
                closeEditModal();

            } else {
                // Gestion des erreurs HTTP
                const contentType = response.headers.get('content-type');
                let errorMessage = 'Erreur lors de la modification de la catégorie';

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

            let userMessage = 'Une erreur est survenue lors de la modification';

            if (error.name === 'TypeError' && error.message.includes('fetch')) {
                userMessage = 'Erreur de connexion au serveur. Vérifiez votre connexion internet.';
            } else if (error.message) {
                userMessage = error.message;
            }

            showNotification(userMessage, 'error');

        } finally {
            // Restaurer l'état du bouton
            submitBtn.disabled = false;
            submitText.textContent = 'Modifier';
        }
    }
</script>