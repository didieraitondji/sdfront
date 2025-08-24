<?php
// vérifier si la session est en cours
session_start();

define('ACCESS_ALLOWED', true);
require_once './../../config.php';

if (isset($_SESSION['user']) && $_SESSION['user'] === true && is_token_valid($_SESSION["token"])) {
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SOUAIBOU DISTRIBUTION - Paramètres</title>
        <link rel="stylesheet" href="/assets/style/output.css">
        <link rel="shortcut icon" href="/assets/images/logo.png" type="image/png">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 font-sans overflow-hidden">

        <!-- En-tête de la page -->
        <div class="fixed top-0 left-0 right-0 h-16 z-50">
            <?php include('./../includes/header.php'); ?>
        </div>

        <!-- Conteneur principal -->
        <div class="fixed top-16 left-0 right-0 bottom-0 flex">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex h-full">

                <!-- Menu latéral gauche -->
                <div class="flex-shrink-0 pr-4">
                    <div class="h-full pt-4 pb-4">
                        <?php include('./../includes/sideMenu.php'); ?>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="flex-1 overflow-hidden">
                    <div class="h-full pt-4 pb-4">
                        <!-- Zone de contenu avec scroll -->
                        <div class="bg-white/70  backdrop-blur-sm rounded-lg shadow-sm border border-emerald-50 h-full overflow-auto">
                            <div class="p-6">
                                dashboard
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="/assets/js/reloadIfPersiste.js"></script>
        <script src="/assets/js/dashboard.js"></script>
        <script src="/assets/js/logout.js"></script>
        <script src="/config.js"></script>
    </body>

    </html>

<?php
} else {
    redirect_to('./../');
    exit();
}
?>