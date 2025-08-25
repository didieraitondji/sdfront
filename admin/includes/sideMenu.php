<!-- Menu latéral universel -->
<div class="bg-white/95 backdrop-blur-sm shadow-sm border border-emerald-50 rounded-lg h-full overflow-hidden flex flex-col transition-all duration-300 w-[270px] -z-10" id="sidebarContainer">
    <!-- En-tête du menu avec bouton de réduction -->
    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex-1 min-w-0" id="sidebarHeaderContent">
            <h2 class="text-lg font-semibold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent truncate" id="sidebarTitle">
                Navigation
            </h2>
            <p class="text-xs text-gray-500 mt-1 truncate" id="sidebarSubtitle">Menu principal</p>
        </div>

        <!-- Bouton de réduction/expansion -->
        <button
            id="sidebarToggle"
            class="p-2 mx-auto cursor-pointer rounded-full bg-gray-100 transition-colors duration-200 flex-shrink-0"
            title="Réduire le menu">
            <i class="fas fa-angle-left text-gray-500 text-sm" id="toggleIcon"></i>
        </button>
    </div>

    <!-- Contenu du menu -->
    <div class="flex-1 overflow-y-auto py-2" id="sidebarContent">
        <!-- Menu par défaut - sera remplacé dynamiquement -->
        <div class="px-2">
            <div class="mb-4">
                <h3 class="px-3 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider sidebar-section-title">
                    Menu Principal
                </h3>
                <nav class="mt-2 space-y-1">
                    <a href="/admin/dashboard/" class="sidebar-item group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Tableau de bord">
                        <i class="fas fa-tachometer-alt mr-3 w-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0"></i>
                        <span class="sidebar-text">Tableau de bord</span>
                    </a>
                    <a href="/admin/products/" class="sidebar-item group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Produits">
                        <i class="fas fa-box mr-3 w-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0"></i>
                        <span class="sidebar-text">Produits</span>
                    </a>
                    <a href="/admin/deliverers/" class="sidebar-item group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Livreurs">
                        <i class="fas fa-motorcycle mr-3 w-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0"></i>
                        <span class="sidebar-text">Livreurs</span>
                    </a>
                    <a href="/admin/orders/" class="sidebar-item group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Commandes">
                        <i class="fas fa-shopping-cart mr-3 w-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0"></i>
                        <span class="sidebar-text">Commandes</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Pied du menu (optionnel) -->
    <div class="p-3 border-t border-gray-100 bg-gray-50/50" id="sidebarFooter">
        <div class="flex items-center text-xs text-gray-500">
            <i class="fas fa-info-circle mr-2 flex-shrink-0"></i>
            <span id="sidebarInfo" class="sidebar-text">Menu contextuel</span>
        </div>
    </div>
</div>

<style>
    /* Styles pour le menu réduit */
    .sidebar-collapsed {
        width: 60px !important;
        min-width: 60px !important;
    }

    .sidebar-collapsed .sidebar-text,
    .sidebar-collapsed .sidebar-section-title {
        opacity: 0;
        width: 0;
        overflow: hidden;
        white-space: nowrap;
    }

    .sidebar-collapsed #sidebarHeaderContent {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar-collapsed .sidebar-item {
        justify-content: center;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .sidebar-collapsed .sidebar-item i {
        margin-right: 0 !important;
    }

    .sidebar-collapsed #sidebarFooter {
        padding-left: 1rem;
        padding-right: 1rem;
        justify-content: center;
    }

    .sidebar-collapsed #sidebarFooter>div {
        justify-content: center;
    }

    .sidebar-collapsed #sidebarFooter i {
        margin-right: 0;
    }

    /* Animation des icônes */
    .sidebar-item i,
    #toggleIcon {
        transition: all 0.3s ease;
    }

    /* Style pour les éléments actifs */
    .sidebar-item-active {
        background-color: rgb(229 231 235) !important;
        /* bg-gray-200 */
        color: rgb(37 99 235) !important;
        /* text-blue-600 */
    }

    .sidebar-item-active i {
        color: rgb(37 99 235) !important;
        /* text-blue-600 */
    }
</style>

<script>
    /**
     * Gestionnaire universel pour le menu latéral
     */
    class SidebarManager {
        constructor() {
            this.currentPath = window.location.pathname;
            this.isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            this.init();
        }

        init() {
            this.setupToggleButton();
            this.setActiveMenuItem();
            this.loadContextualMenu();

            // Appliquer l'état initial
            if (this.isCollapsed) {
                this.collapseSidebar(false);
            }
        }

        /**
         * Configuration du bouton de réduction/expansion
         */
        setupToggleButton() {
            const toggleButton = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');

            if (toggleButton && toggleIcon) {
                toggleButton.addEventListener('click', () => {
                    this.toggleSidebar();
                });
            }
        }

        /**
         * Basculer l'état du menu
         */
        toggleSidebar() {
            if (this.isCollapsed) {
                this.expandSidebar();
            } else {
                this.collapseSidebar();
            }
        }

        /**
         * Réduire le menu
         */
        collapseSidebar(animate = true) {
            const container = document.getElementById('sidebarContainer');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleButton = document.getElementById('sidebarToggle');

            if (container && toggleIcon && toggleButton) {
                container.classList.add('sidebar-collapsed');
                toggleIcon.className = 'fas fa-angle-right text-gray-500 text-sm';
                toggleButton.title = 'Étendre le menu';

                this.isCollapsed = true;
                localStorage.setItem('sidebarCollapsed', 'true');

                // Déclencher un événement personnalisé pour que la page parent puisse réagir
                window.dispatchEvent(new CustomEvent('sidebarCollapsed', {
                    detail: {
                        isCollapsed: this.isCollapsed
                    }
                }));
            }
        }

        /**
         * Étendre le menu
         */
        expandSidebar(animate = true) {
            const container = document.getElementById('sidebarContainer');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleButton = document.getElementById('sidebarToggle');

            if (container && toggleIcon && toggleButton) {
                container.classList.remove('sidebar-collapsed');
                toggleIcon.className = 'fas fa-angle-left text-gray-500 text-sm';
                toggleButton.title = 'Réduire le menu';

                this.isCollapsed = false;
                localStorage.setItem('sidebarCollapsed', 'false');

                // Déclencher un événement personnalisé
                window.dispatchEvent(new CustomEvent('sidebarExpanded', {
                    detail: {
                        isCollapsed: this.isCollapsed
                    }
                }));
            }
        }

        /**
         * Marque l'élément de menu actif avec arrière-plan gris
         */
        setActiveMenuItem() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                const href = item.getAttribute('href');
                // Suppression de toutes les classes d'état actif
                item.classList.remove('text-blue-600', 'bg-blue-50', 'border-r-2', 'border-blue-600');

                const icon = item.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-blue-600');
                    icon.classList.add('text-gray-400');
                }

                // Vérification de l'URL active
                if (this.currentPath === href ||
                    this.currentPath.startsWith(href) ||
                    (href.includes('dashboard') && (this.currentPath.includes('dashboard') || this.currentPath === '/admin/' || this.currentPath === '/admin')) ||
                    (href.includes('products') && this.currentPath.includes('products')) ||
                    (href.includes('deliverers') && this.currentPath.includes('deliverers')) ||
                    (href.includes('orders') && this.currentPath.includes('orders'))) {

                    // Application du style actif
                    item.classList.add('text-blue-600');
                    if (icon) {
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-blue-600');
                    }
                }
            });

            // Trouver l'élément le plus spécifique qui correspond
            let activeItem = null;
            let bestMatch = '';

            sidebarItems.forEach(item => {
                const href = item.getAttribute('href');
                // console.log('Comparaison:', href, 'avec', this.currentPath); // Pour debug

                let isMatch = false;

                // on vérifie si l'href est contenu dans l'URL actuelle
                if (this.currentPath.includes(href)) {
                    isMatch = true;
                }

                // Si c'est un match et qu'il est plus spécifique que le précédent
                if (isMatch && href.length > bestMatch.length) {
                    activeItem = item;
                    bestMatch = href;
                }
            });

            // Appliquer le style actif uniquement à l'élément le plus spécifique
            if (activeItem) {
                activeItem.classList.add('sidebar-item-active');
            }
        }

        /**
         * Charge le menu contextuel selon la page
         */
        loadContextualMenu() {
            const menuConfigs = {
                '/admin/dashboard/': {
                    title: 'Tableau de bord',
                    subtitle: 'Vue d\'ensemble',
                    items: [{
                            icon: 'fas fa-chart-line',
                            text: 'Statistiques',
                            href: '/admin/dashboard/stats/'
                        },
                        {
                            icon: 'fas fa-chart-pie',
                            text: 'Rapports',
                            href: '/admin/dashboard/reports/'
                        },
                        {
                            icon: 'fas fa-bell',
                            text: 'Notifications',
                            href: '/admin/dashboard/notifications/'
                        },
                        {
                            icon: 'fas fa-calendar-alt',
                            text: 'Activités récentes',
                            href: '/admin/dashboard/activities/'
                        }
                    ]
                },
                '/admin/products/': {
                    title: 'Gestion Produits',
                    subtitle: 'Catalogue & Stock',
                    items: [{
                            icon: 'fas fa-plus-circle',
                            text: 'Ajouter un produit',
                            href: '/admin/products/add/'
                        },
                        {
                            icon: 'fas fa-list',
                            text: 'Liste des produits',
                            href: '/admin/products/list/'
                        },
                        {
                            icon: 'fas fa-tags',
                            text: 'Catégories',
                            href: '/admin/products/categories/'
                        },
                        {
                            icon: 'fas fa-warehouse',
                            text: 'Stock',
                            href: '/admin/products/stock/'
                        },
                        {
                            icon: 'fas fa-percent',
                            text: 'Promotions',
                            href: '/admin/products/promotions/'
                        }
                    ]
                },
                '/admin/deliverers/': {
                    title: 'Gestion Livreurs',
                    subtitle: 'Équipe de livraison',
                    items: [{
                            icon: 'fas fa-user-plus',
                            text: 'Ajouter un livreur',
                            href: '/admin/deliverers/add/'
                        },
                        {
                            icon: 'fas fa-users',
                            text: 'Liste des livreurs',
                            href: '/admin/deliverers/list/'
                        },
                        {
                            icon: 'fas fa-map-marked-alt',
                            text: 'Zones de livraison',
                            href: '/admin/deliverers/zones/'
                        },
                        {
                            icon: 'fas fa-clock',
                            text: 'Horaires',
                            href: '/admin/deliverers/schedules/'
                        },
                        {
                            icon: 'fas fa-star',
                            text: 'Évaluations',
                            href: '/admin/deliverers/ratings/'
                        }
                    ]
                },
                '/admin/orders/': {
                    title: 'Gestion Commandes',
                    subtitle: 'Suivi & Traitement',
                    items: [{
                            icon: 'fas fa-shopping-bag',
                            text: 'Nouvelles commandes',
                            href: '/admin/orders/new/'
                        },
                        {
                            icon: 'fas fa-truck',
                            text: 'En cours de livraison',
                            href: '/admin/orders/delivery/'
                        },
                        {
                            icon: 'fas fa-check-circle',
                            text: 'Terminées',
                            href: '/admin/orders/completed/'
                        },
                        {
                            icon: 'fas fa-times-circle',
                            text: 'Annulées',
                            href: '/admin/orders/cancelled/'
                        },
                        {
                            icon: 'fas fa-history',
                            text: 'Historique',
                            href: '/admin/orders/history/'
                        }
                    ]
                }
            };

            // Trouver la configuration appropriée
            let config = null;
            for (const [path, cfg] of Object.entries(menuConfigs)) {
                if (this.currentPath.startsWith(path)) {
                    config = cfg;
                    break;
                }
            }

            if (config) {
                this.renderContextualMenu(config);
            }
        }

        /**
         * Rendu du menu contextuel
         */
        renderContextualMenu(config) {
            const titleElement = document.getElementById('sidebarTitle');
            const subtitleElement = document.getElementById('sidebarSubtitle');
            const contentElement = document.getElementById('sidebarContent');
            const infoElement = document.getElementById('sidebarInfo');

            // Mise à jour des titres
            if (titleElement) titleElement.textContent = config.title;
            if (subtitleElement) subtitleElement.textContent = config.subtitle;
            if (infoElement) infoElement.textContent = `${config.items.length} options disponibles`;

            // Génération du contenu du menu
            const menuHTML = `
            <div class="px-2">
                <div class="mb-4">
                    <h3 class="px-3 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider sidebar-section-title">
                        ${config.title}
                    </h3>
                    <nav class="mt-2 space-y-1">
                        ${config.items.map(item => `
                            <a href="${item.href}" class="sidebar-item group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="${item.text}">
                                <i class="${item.icon} mr-3 w-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0"></i>
                                <span class="sidebar-text">${item.text}</span>
                            </a>
                        `).join('')}
                    </nav>
                </div>
            </div>
        `;

            if (contentElement) {
                contentElement.innerHTML = menuHTML;
                // Remettre les styles actifs après le rendu
                setTimeout(() => this.setActiveMenuItem(), 100);
            }
        }

        /**
         * Méthode publique pour mettre à jour le menu depuis l'extérieur
         */
        updateMenu(config) {
            this.renderContextualMenu(config);
        }

        /**
         * Méthode pour ajouter un élément de menu dynamiquement
         */
        addMenuItem(item, section = 'default') {
            // Implementation pour ajouter des éléments dynamiquement
            //console.log('Ajout d\'un élément de menu:', item);
        }

        /**
         * Méthode pour rafraîchir le menu
         */
        refresh() {
            this.currentPath = window.location.pathname;
            this.loadContextualMenu();
            this.setActiveMenuItem();
        }

        /**
         * Obtenir l'état de réduction du menu
         */
        getCollapsedState() {
            return this.isCollapsed;
        }
    }

    // Initialisation du gestionnaire de menu
    let sidebarManager;

    document.addEventListener('DOMContentLoaded', function() {
        sidebarManager = new SidebarManager();
    });

    // Fonction globale pour mettre à jour le menu (accessible depuis PHP)
    function updateSidebarMenu(config) {
        if (sidebarManager) {
            sidebarManager.updateMenu(config);
        }
    }

    // Fonction pour rafraîchir le menu
    function refreshSidebar() {
        if (sidebarManager) {
            sidebarManager.refresh();
        }
    }

    // Fonction pour contrôler manuellement l'état du menu
    function toggleSidebar() {
        if (sidebarManager) {
            sidebarManager.toggleSidebar();
        }
    }

    // Fonction pour obtenir l'état du menu
    function getSidebarState() {
        return sidebarManager ? sidebarManager.getCollapsedState() : false;
    }
</script>