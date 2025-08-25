// vérifions s'il existe un token déjà
if (localStorage.getItem("token")) {
  window.location.href = "/connectadm.php?access=true";
} else {
  // Toggle password visibility
  document
    .getElementById("togglePassword")
    .addEventListener("click", function () {
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

  document
    .getElementById("loginForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin mr-2"></i> Authentification en cours...';
      submitBtn.disabled = true;

      // Récupération des données du formulaire
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());

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
          // Connexion réussie : on stocke les infos et le token
          localStorage.setItem("user", JSON.stringify(result.user));
          localStorage.setItem("token", result.token);

          submitBtn.innerHTML =
            '<i class="fas fa-check mr-2"></i> Accès autorisé';
          submitBtn.classList.remove(
            "from-blue-custom",
            "to-green-custom",
            "hover:from-blue-800",
            "hover:to-green-700"
          );
          submitBtn.classList.add("bg-green-custom");

          setTimeout(() => {
            window.location.href = "./../connectadm.php?access=true";
          }, 1000);
        } else {
          // Identifiants invalides
          submitBtn.innerHTML =
            '<i class="fas fa-exclamation-triangle mr-2"></i> Échec de connexion';
          submitBtn.classList.add("bg-red-600");
          submitBtn.disabled = false;
          alert(result.message || "Identifiants incorrects.");

          // affichage des erreurs dans la partie console
          console.error(result);
        }
      } catch (error) {
        // ❌ Erreur serveur ou réseau
        submitBtn.innerHTML =
          '<i class="fas fa-exclamation-triangle mr-2"></i> Erreur serveur';
        submitBtn.classList.add("bg-red-600");
        submitBtn.disabled = false;
        console.error("Erreur lors de la connexion :", error);
        alert("Une erreur est survenue. Veuillez réessayer.");
      }
    });
}
