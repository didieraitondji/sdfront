<!-- Header -->
<header class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 -z-10 border-b border-white/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo à gauche -->
            <div class="flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <img src="/assets/images/logo.png" alt="Logo de SOUAIBOU" class="w-8 h-8">
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            SOUAIBOU
                        </h1>
                        <p class="text-xs text-gray-500 -mt-1">DISTRIBUTION</p>
                    </div>
                </div>
            </div>

            <!-- Menu central - caché en mobile -->
            <nav class="hidden lg:flex space-x-6">
                <a href="/admin/dashboard/" class="menu-item group relative text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Tableau de bord
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                <a href="/admin/products/" class="menu-item group relative text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-box mr-2"></i>
                    Produits
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                <a href="/admin/deliverers/" class="menu-item group relative text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-motorcycle mr-2"></i>
                    Livreurs
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                <a href="/admin/orders/" class="menu-item group relative text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Commandes
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
            </nav>

            <!-- Actions à droite -->
            <div class="flex items-center space-x-3">
                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full bg-gray-100 cursor-pointer">
                        <i class="fas fa-bell text-lg"></i>
                        <!-- Badge de notification correctement positionné -->
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center font-medium">1</span>
                    </button>
                </div>

                <!-- Avatar dropdown -->
                <div class="relative">
                    <button
                        id="avatarButton"
                        class="flex items-center cursor-pointer space-x-2 text-sm rounded-full focus:outline-none p-1 bg-gray-100 hover:bg-gray-200  transition-colors duration-200"
                        onclick="toggleDropdown()">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center shadow-md hover:shadow-lg transition-shadow duration-200">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="hidden lg:block text-left max-w-32">
                            <p class="text-sm font-medium text-gray-700 truncate" id="userName">Admin User</p>
                            <p class="text-xs text-gray-500 truncate" id="userRole">Administrateur</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" id="chevron"></i>
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        id="dropdownMenu"
                        class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-white/20 py-2 opacity-0 invisible transform -translate-y-2 transition-all duration-200 ease-out">

                        <!-- User info dans le dropdown -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900 truncate" id="dropdownUserName">Admin User</p>
                            <p class="text-sm text-gray-500 truncate" id="dropdownUserEmail">admin@souaibou-distribution.com</p>
                        </div>

                        <!-- Menu items -->
                        <div class="py-1">
                            <a href="/admin/profile/" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-user-circle mr-3 text-gray-400 w-4"></i>
                                Profil
                            </a>
                            <a href="/admin/settings/" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-cog mr-3 text-gray-400 w-4"></i>
                                Paramètres
                            </a>
                        </div>

                        <div class="border-t border-gray-100 py-1">
                            <button
                                onclick="logout()"
                                class="flex items-center cursor-pointer w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                Déconnexion
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu mobile toggle -->
                <button
                    id="mobileMenuButton"
                    class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                    onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobileMenu" class="lg:hidden hidden border-t border-gray-100 py-4 max-h-screen overflow-y-auto">
            <div class="space-y-1">
                <a href="/admin/dashboard/" class="mobile-menu-item flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Tableau de bord
                </a>
                <a href="/admin/products/" class="mobile-menu-item flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <i class="fas fa-box mr-3 w-5"></i>
                    Produits
                </a>
                <a href="/admin/deliverers/" class="mobile-menu-item flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <i class="fas fa-motorcycle mr-3 w-5"></i>
                    Livreurs
                </a>
                <a href="/admin/orders/" class="mobile-menu-item flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <i class="fas fa-shopping-cart mr-3 w-5"></i>
                    Commandes
                </a>
            </div>
        </div>
    </div>
</header>

<script>
    // Fonction pour toggle le dropdown
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const chevron = document.getElementById('chevron');

        if (dropdownMenu.classList.contains('opacity-0')) {
            // Ouvrir
            dropdownMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
            dropdownMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            chevron.classList.add('rotate-180');
        } else {
            // Fermer
            dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            dropdownMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            chevron.classList.remove('rotate-180');
        }
    }

    // Fonction pour toggle le menu mobile
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const menuButton = document.getElementById('mobileMenuButton');
        const icon = menuButton.querySelector('i');

        mobileMenu.classList.toggle('hidden');

        if (mobileMenu.classList.contains('hidden')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    }

    // Fonction de déconnexion
    function logout() {
        Swal.fire({
            title: 'Déconnexion',
            text: 'Êtes-vous sûr de vouloir vous déconnecter ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Oui, déconnecter',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Supprimer les données du localStorage
                localStorage.removeItem('user');
                localStorage.removeItem('token');

                Swal.fire({
                    title: 'Déconnecté',
                    text: 'Vous avez été déconnecté avec succès',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Redirection vers la page de connexion
                    window.location.href = '/admin/';
                });
            }
        });
    }

    // FONCTION POUR MARQUER LE MENU ACTIF SELON L'URL
    function setActiveMenu() {
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll('.menu-item, .mobile-menu-item');

        // Retirer toutes les classes actives d'abord
        menuItems.forEach(item => {
            item.classList.remove('text-blue-600');
            const indicator = item.querySelector('span');
            if (indicator) {
                indicator.classList.add('w-0', 'left-1/2');
                indicator.classList.remove('w-full', 'left-0');
            }
        });

        // Ajouter la classe active au menu correspondant à l'URL
        menuItems.forEach(item => {
            const href = item.getAttribute('href');
            //console.log('Comparaison:', href, 'avec', currentPath); // Pour debug

            // Vérification plus flexible
            if (currentPath === href ||
                currentPath.startsWith(href) ||
                (href.includes('dashboard') && (currentPath.includes('dashboard') || currentPath === '/admin/' || currentPath === '/admin')) ||
                (href.includes('products') && currentPath.includes('products')) ||
                (href.includes('deliverers') && currentPath.includes('deliverers')) ||
                (href.includes('orders') && currentPath.includes('orders'))) {

                item.classList.add('text-blue-600');
                //console.log('Menu actif trouvé:', href); // Pour debug

                // Ajouter l'indicateur actif pour le menu desktop
                if (item.classList.contains('menu-item')) {
                    const indicator = item.querySelector('span');
                    if (indicator) {
                        indicator.classList.add('w-full', 'left-0');
                        indicator.classList.remove('w-0', 'left-1/2');
                    }
                }
            }
        });
    }

    // Fermer le dropdown en cliquant ailleurs
    document.addEventListener('click', function(event) {
        const avatarButton = document.getElementById('avatarButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const chevron = document.getElementById('chevron');

        if (!avatarButton.contains(event.target)) {
            dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            dropdownMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            chevron.classList.remove('rotate-180');
        }
    });

    // APPEL DE LA FONCTION AU CHARGEMENT DE LA PAGE
    document.addEventListener('DOMContentLoaded', function() {
        // Appeler la fonction pour marquer le menu actif
        setActiveMenu();

        // Charger les infos utilisateur depuis localStorage
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        if (user.first_name) {
            document.getElementById('userName').textContent = user.first_name;
            document.getElementById('dropdownUserName').textContent = user.first_name + ' ' + user.last_name;
        }
        if (user.email) {
            document.getElementById('dropdownUserEmail').textContent = user.email;
        }
    });

    // Navigation avec changement d'état actif et redirection réelle
    document.querySelectorAll('.menu-item, .mobile-menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Fermer le menu mobile si ouvert
            const mobileMenu = document.getElementById('mobileMenu');
            if (!mobileMenu.classList.contains('hidden')) {
                toggleMobileMenu();
            }

            //console.log('Navigation vers:', this.getAttribute('href'));
        });
    });
</script>