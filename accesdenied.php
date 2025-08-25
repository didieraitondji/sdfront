<?php
// access_denied.php
http_response_code(403); // Code HTTP 403 - Forbidden
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Interdit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .forbidden-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, #FFD700 0%, #0047AB 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gradient {
            background: linear-gradient(to right, #0047AB, #008000);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #008000, #0047AB);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 71, 171, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="text-center p-8 bg-white rounded-xl shadow-2xl border border-gray-100 max-w-md w-full transform transition-all hover:scale-[1.01]">
        <div class="forbidden-icon mb-4">
            <i class="fas fa-ban"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3">Accès Interdit</h1>
        <p class="text-gray-600 mb-6 text-lg">Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cette ressource.</p>
        <div class="mb-6">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                Erreur 403 - Forbidden
            </span>
        </div>
        <a href="./" class="btn-gradient text-white px-6 py-3 rounded-full font-medium shadow-md inline-flex items-center">
            <i class="fas fa-home mr-2"></i>
            Retour à l'accueil
        </a>
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-gray-500 text-sm">Besoin d'aide ? <a href="mailto:support@entreprise.com" class="text-#0047AB hover:underline">Contactez le support</a></p>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>