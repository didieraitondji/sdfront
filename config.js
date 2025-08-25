// url de l'api
const API_URL = "http://dev-sdapi.com/api/";

// Afficher les notifications
function showNotification(message, type = "info") {
  const notification = document.getElementById("notification");
  if (!notification) return;
  const icon = document.getElementById("notificationIcon");
  const messageSpan = document.getElementById("notificationMessage");

  // Configuration selon le type
  const configs = {
    success: {
      bgClass: "bg-green-500 text-white",
      iconClass: "fas fa-check-circle text-white",
    },
    error: {
      bgClass: "bg-red-500 text-white",
      iconClass: "fas fa-exclamation-circle text-white",
    },
    info: {
      bgClass: "bg-blue-500 text-white",
      iconClass: "fas fa-info-circle text-white",
    },
  };

  const config = configs[type] || configs.info;

  notification.className = `fixed bottom-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${config.bgClass}`;
  icon.className = config.iconClass;
  messageSpan.textContent = message;

  // Afficher
  notification.classList.remove("hidden");
  setTimeout(() => {
    notification.style.transform = "translateX(0)";
  }, 100);

  // Masquer après 5 secondes
  setTimeout(() => {
    notification.style.transform = "translateX(100%)";
    setTimeout(() => {
      notification.classList.add("hidden");
    }, 300);
  }, 5000);
}

// Vérifier la validité du token
async function isTokenValid(token, apiUrl) {
  try {
    const response = await fetch(`${apiUrl}check-token`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
    });

    // Vérifier si la requête a réussi
    if (!response.ok) {
      return false;
    }

    const data = await response.json();
    return data.valid;
  } catch (error) {
    return false;
  }
}

// Vérifier le token
async function checkTokenOnly() {
  const token = localStorage.getItem("token");

  if (!token) {
    return false;
  }

  return await isTokenValid(token, API_URL);
}

// fonction pour récupérer le chemin actuel
function getCurrentPath() {
  return window.location.pathname;
}

// fonction pour formater le chemin récupérer pour pouvoir l'envoyer à travers l'url de connexion
function formatPathForUrl(path) {
  return encodeURIComponent(path);
}

// fonction pour reconstruire le chemin
function rebuildPathFromUrl(url) {
  return decodeURIComponent(url);
}

// fonction pour stocker l'url dans le localstorage
function storeUrlInLocalStorage() {
  const currentPath = formatPathForUrl(getCurrentPath());
  localStorage.setItem("currentPath", currentPath);
}

const pathInUrl = getCurrentPath();

if (pathInUrl !== "/admin/" && pathInUrl !== "/register") {
  storeUrlInLocalStorage();
}

/* console.log(getCurrentPath());
console.log(formatPathForUrl(getCurrentPath()));
console.log(localStorage.getItem("currentPath")); */
