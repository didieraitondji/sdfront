<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion Admin | SOUAIBOU-DISTRIBUTION</title>
  <link rel="shortcut icon" href="/assets/images/logo_sd.png" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      overflow: hidden;
      margin: 0;
      padding: 0;
    }

    /* Background animé moderne */
    .animated-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      overflow: hidden;
    }

    /* Particules flottantes */
    .floating-shapes {
      position: absolute;
      width: 100%;
      height: 100%;
    }

    .shape {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 20s infinite linear;
    }

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      left: 10%;
      animation-delay: -2s;
      animation-duration: 25s;
    }

    .shape:nth-child(2) {
      width: 60px;
      height: 60px;
      left: 20%;
      animation-delay: -4s;
      animation-duration: 20s;
    }

    .shape:nth-child(3) {
      width: 40px;
      height: 40px;
      left: 30%;
      animation-delay: -6s;
      animation-duration: 30s;
    }

    .shape:nth-child(4) {
      width: 100px;
      height: 100px;
      left: 70%;
      animation-delay: -8s;
      animation-duration: 15s;
    }

    .shape:nth-child(5) {
      width: 50px;
      height: 50px;
      left: 80%;
      animation-delay: -10s;
      animation-duration: 22s;
    }

    .shape:nth-child(6) {
      width: 70px;
      height: 70px;
      left: 90%;
      animation-delay: -12s;
      animation-duration: 28s;
    }

    @keyframes float {
      0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      90% {
        opacity: 1;
      }

      100% {
        transform: translateY(-100px) rotate(360deg);
        opacity: 0;
      }
    }

    /* Vagues animées */
    .wave-container {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100px;
      background: linear-gradient(to top, rgba(255, 255, 255, 0.1), transparent);
    }

    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 200%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='rgba(255,255,255,0.05)'/%3E%3C/svg%3E") repeat-x;
      animation: wave 15s linear infinite;
    }

    .wave:nth-child(2) {
      animation-delay: -5s;
      animation-duration: 20s;
      opacity: 0.5;
      bottom: 10px;
    }

    .wave:nth-child(3) {
      animation-delay: -10s;
      animation-duration: 25s;
      opacity: 0.3;
      bottom: 20px;
    }

    @keyframes wave {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }

    /* Gradient pulsant */
    .pulse-gradient {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
      animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
        opacity: 0.5;
      }

      50% {
        transform: scale(1.1);
        opacity: 0.8;
      }
    }

    /* Lignes géométriques */
    .geometric-lines {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .line {
      position: absolute;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      animation: slide 12s linear infinite;
    }

    .line:nth-child(1) {
      width: 2px;
      height: 100%;
      left: 20%;
      animation-delay: -2s;
    }

    .line:nth-child(2) {
      width: 100%;
      height: 2px;
      top: 30%;
      animation-delay: -4s;
      animation-duration: 8s;
    }

    .line:nth-child(3) {
      width: 2px;
      height: 100%;
      left: 80%;
      animation-delay: -6s;
      animation-duration: 10s;
    }

    @keyframes slide {
      0% {
        transform: translateX(-100%);
        opacity: 0;
      }

      50% {
        opacity: 1;
      }

      100% {
        transform: translateX(100%);
        opacity: 0;
      }
    }

    /* Animation d'entrée */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 1s ease-out;
    }
  </style>
</head>

<body>
  <!-- Background animé -->
  <div class="animated-background">
    <!-- Gradient pulsant -->
    <div class="pulse-gradient"></div>

    <!-- Particules flottantes -->
    <div class="floating-shapes">
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
    </div>

    <!-- Lignes géométriques -->
    <div class="geometric-lines">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>

    <!-- Vagues -->
    <div class="wave-container">
      <div class="wave"></div>
      <div class="wave"></div>
      <div class="wave"></div>
    </div>
  </div>

  <!-- Contenu principal -->
  <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
      <!-- Carte de connexion -->
      <div class="bg-white bg-opacity-95 backdrop-blur-lg border border-white border-opacity-30 rounded-2xl shadow-2xl p-6 transform transition-transform duration-300 hover:-translate-y-1 hover:shadow-3xl fade-in">

        <!-- En-tête -->
        <div class="text-center mb-6">
          <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50 rounded-full mb-3">
            <i class="fas fa-user-shield text-lg text-blue-600"></i>
          </div>
          <h1 class="text-xl font-semibold text-gray-900 mb-1">Connexion Admin</h1>
          <p class="text-sm text-gray-600">Accédez au panneau de contrôle</p>
        </div>

        <!-- Formulaire -->
        <form id="loginForm" method="post" class="space-y-4">

          <!-- Identifiant -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Identifiant
            </label>
            <div class="relative">
              <input
                type="text"
                id="email"
                name="email_or_phone"
                required
                class="w-full pl-10 pr-3 py-2 text-sm rounded-md border border-gray-300 bg-white bg-opacity-80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                placeholder="admin@exemple.com"
                autocomplete="username" />
              <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
          </div>

          <!-- Mot de passe -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
              Mot de passe
            </label>
            <div class="relative">
              <input
                type="password"
                id="password"
                name="user_password"
                required
                class="w-full pl-10 pr-10 py-2 text-sm rounded-md border border-gray-300 bg-white bg-opacity-80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                placeholder="••••••••"
                autocomplete="current-password" />
              <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
              <button
                type="button"
                id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors duration-200 cursor-pointer">
                <i class="fas fa-eye text-sm"></i>
              </button>
            </div>
          </div>

          <!-- Bouton de connexion -->
          <button
            type="submit"
            id="loginBtn"
            class="w-full py-2 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 relative overflow-hidden">
            <span id="loginText">Se connecter</span>
          </button>
        </form>

        <!-- Sécurité -->
        <div class="mt-6 pt-4 border-t border-gray-100">
          <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
            <div class="flex items-center">
              <i class="fas fa-shield-alt text-green-500 mr-1"></i>
              <span>SSL</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-lock text-blue-500 mr-1"></i>
              <span>Sécurisé</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="./../assets/js/reloadIfPersiste.js"></script>
  <script src="./../config.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle password visibility avec votre logique
      document
        .getElementById("togglePassword")
        .addEventListener("click", function() {
          const passwordInput = document.getElementById("password");
          const icon = this.querySelector("i");

          if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
          } else {
            passwordInput.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
          }
        });

      // Form submission avec votre logique API
      document
        .getElementById("loginForm")
        .addEventListener("submit", async function(e) {
          e.preventDefault();

          const submitBtn = this.querySelector('button[type="submit"]');
          submitBtn.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-2"></i> Authentification en cours...';
          submitBtn.disabled = true;

          // Récupération des données du formulaire
          const formData = new FormData(this);
          const data = Object.fromEntries(formData.entries());

          console.log(data);

          try {
            const response = await fetch(API_URL + "login", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {

              // on vérifie si l'utilisateur est un admin
              if (result.user.user_type !== "admin") {
                submitBtn.innerHTML =
                  '<i class="fas fa-exclamation-triangle mr-2"></i> Accès non autorisé';
                submitBtn.classList.remove(
                  "from-blue-600",
                  "to-blue-700",
                  "hover:from-blue-700",
                  "hover:to-blue-800"
                );
                submitBtn.classList.add("bg-red-500", "hover:bg-red-600");
                return;
              }

              // Connexion réussie : on stocke les infos et le token
              localStorage.setItem("user", JSON.stringify(result.user));
              localStorage.setItem("token", result.token);

              submitBtn.innerHTML =
                '<i class="fas fa-check mr-2"></i> Accès autorisé';
              submitBtn.classList.remove(
                "from-blue-600",
                "to-blue-700",
                "hover:from-blue-700",
                "hover:to-blue-800"
              );
              submitBtn.classList.add("bg-green-500", "hover:bg-green-600");

              // Affichage du succès avec SweetAlert
              Swal.fire({
                icon: 'success',
                title: 'Connexion réussie',
                text: 'Redirection en cours...',
                timer: 1000,
                showConfirmButton: false
              });

              const currentPath = localStorage.getItem("currentPath");

              if (currentPath) {
                setTimeout(() => {
                  window.location.href = "./../connectadm.php?access=true&token=" + result.token + "&path=" + currentPath;
                }, 1000);
              } else {
                setTimeout(() => {
                  window.location.href = "./../connectadm.php?access=true&token=" + result.token;
                }, 1000);
              }

            } else {
              // Identifiants invalides
              submitBtn.innerHTML =
                '<i class="fas fa-exclamation-triangle mr-2"></i> Échec de connexion';
              submitBtn.classList.remove(
                "from-blue-600",
                "to-blue-700",
                "hover:from-blue-700",
                "hover:to-blue-800"
              );
              submitBtn.classList.add("bg-red-600", "hover:bg-red-700");

              // Affichage de l'erreur avec SweetAlert
              Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: result.message || 'Identifiants incorrects.',
                confirmButtonText: 'Réessayer',
                confirmButtonColor: '#dc2626'
              }).then(() => {
                // Reset du bouton après fermeture de l'alerte
                submitBtn.innerHTML = 'Se connecter';
                submitBtn.classList.remove("bg-red-600", "hover:bg-red-700");
                submitBtn.classList.add(
                  "from-blue-600",
                  "to-blue-700",
                  "hover:from-blue-700",
                  "hover:to-blue-800"
                );
                submitBtn.disabled = false;
              });

              // affichage des erreurs dans la partie console
              console.error(result);
            }
          } catch (error) {
            // ❌ Erreur serveur ou réseau
            submitBtn.innerHTML =
              '<i class="fas fa-exclamation-triangle mr-2"></i> Erreur serveur';
            submitBtn.classList.remove(
              "from-blue-600",
              "to-blue-700",
              "hover:from-blue-700",
              "hover:to-blue-800"
            );
            submitBtn.classList.add("bg-red-600", "hover:bg-red-700");

            console.error("Erreur lors de la connexion :", error);

            // Affichage de l'erreur avec SweetAlert
            Swal.fire({
              icon: 'error',
              title: 'Erreur serveur',
              text: 'Une erreur est survenue. Veuillez réessayer.',
              confirmButtonText: 'Réessayer',
              confirmButtonColor: '#dc2626'
            }).then(() => {
              // Reset du bouton après fermeture de l'alerte
              submitBtn.innerHTML = 'Se connecter';
              submitBtn.classList.remove("bg-red-600", "hover:bg-red-700");
              submitBtn.classList.add(
                "from-blue-600",
                "to-blue-700",
                "hover:from-blue-700",
                "hover:to-blue-800"
              );
              submitBtn.disabled = false;
            });
          }
        });

      // Auto-focus sur le champ email
      const emailInput = document.getElementById('email');
      if (emailInput) {
        emailInput.focus();
      }
    });
  </script>
</body>

</html>