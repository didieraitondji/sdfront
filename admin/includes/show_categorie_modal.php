<!-- Modal de visualisation -->
<div id="viewModal" class="hidden cursor-pointer fixed inset-0 z-50 items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-lg shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Détails de la catégorie</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="viewModalContent">
                <!-- Le contenu sera injecté par JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
    /* Style pour le modal */
    #viewModal {
        backdrop-filter: blur(4px);
    }

    /* Animation du modal */
    #viewModal .bg-white {
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