var logoutButton = document.getElementById("logoutButton");

logoutButton.addEventListener("click", function () {
  // suppression du token
  const token = localStorage.getItem("token");
  fetch(API_URL + "logout", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token }),
  });

  // destructions des données stocker dans le localstorage
  localStorage.removeItem("user");
  localStorage.removeItem("token");

  // redirection vers la page de connexion
  window.location.href = "/admin/logout.php";
});
