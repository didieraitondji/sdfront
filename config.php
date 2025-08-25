<?php
if (!defined('ACCESS_ALLOWED')) {
    header("HTTP/1.0 403 Forbidden");
    require_once 'accesdenied.php';
    exit;
}

// variable globale représentant l'url de l'api
define('API_URL', 'http://dev-sdapi.com/api/');

// fonction pour récupérer les types de produits depuis l'api et les retourner sous forme de tableau associatif
function get_product_types()
{
    return json_decode(file_get_contents(API_URL . 'type-produits'), true);
}

// fonction pour retourner les catégories associée à un type de produit
function get_categories_by_type($type_id)
{
    $categories = get_categories();
    $filtered_categories = [];
    foreach ($categories as $category) {
        if ($category['tp_id'] == $type_id) {
            $filtered_categories[] = $category;
        }
    }
    return $filtered_categories;
}

// fonction pour récupérer les produits depuis l'api dans l'ordre décroissant
function get_products()
{
    return json_decode(file_get_contents(API_URL . 'produits'), true);
}

// fonction pour retourner un produit par son id
function get_product_by_id($id)
{
    $products = get_products();
    foreach ($products as $product) {
        if ($product['p_id'] == $id) {
            return $product;
        }
    }
    return null;
}

// fonction pour retourner une catégorie par son id
function get_category_by_id($id)
{
    $categories = get_categories();
    foreach ($categories as $category) {
        if ($category['c_id'] == $id) {
            return $category;
        }
    }
    return null;
}

// fonction pour récupérer les 10 derniers produits ajoutés
function get_latest_products($limit = 10)
{
    $products = get_products();

    // Trier par p_id en ordre décroissant
    usort($products, function ($a, $b) {
        return $b['p_id'] <=> $a['p_id'];
    });

    return array_slice($products, 0, $limit);
}


// fonction récupérer les categories depuis l'api
function get_categories()
{
    // On récupère les catégories depuis l'API dans une variable
    $categories = json_decode(file_get_contents(API_URL . 'categories'), true);

    // on change les c_image des catégories qui n'ont pas d'image en /assets/images/cat.png
    foreach ($categories as &$category) {
        if (empty($category['c_image'])) {
            $category['c_image'] = '/assets/images/cat.png';
        }
    }

    // On retourne les catégories
    return $categories;
}

// fonction pour récupérer les catégories dans l'ordre decroissant de l'id
function get_recent_categories()
{
    $categories = get_categories();
    usort($categories, function ($a, $b) {
        return $b['c_id'] <=> $a['c_id'];
    });

    // ajout de numéro à chaque ligne de catégorie
    foreach ($categories as $index => &$category) {
        $category['number'] = $index + 1;
    }

    return $categories;
}

// fonction pour retourner le nom d'une catégorie par son id
function get_category_name($id)
{
    $categories = get_categories();
    foreach ($categories as $category) {
        if ($category['c_id'] == $id) {
            return $category['c_name'];
        }
    }
    return '';
}

// fonction récupérer les utilisateurs depuis l'api
function get_users()
{
    return json_decode(file_get_contents(API_URL . 'users'), true);
}

// fonction récupérer les commandes depuis l'api
function get_orders()
{
    return json_decode(file_get_contents(API_URL . 'orders'), true);
}

// fonction pour récupérer tout les types de produits
function get_types()
{
    return json_decode(file_get_contents(API_URL . 'type-produits'), true);
}

// fonction pour retourner le nom d'un type de produit par son id
function get_type_name($id)
{
    $types = get_types();
    foreach ($types as $type) {
        if ($type['tp_id'] == $id) {
            return $type['tp_name'];
        }
    }
    return '';
}

// fonction de redirection
function redirect_to($url, $permanent = false)
{
    if (!headers_sent()) {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    } else {
        echo "<script>window.location.href='" . $url . "';</script>";
        exit();
    }
}

// fonction pour vérifier si le token de l'utilisateur est toujours valide
function is_token_valid($token)
{
    try {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json'
                ],
                'ignore_errors' => true // Important pour gérer les erreurs HTTP
            ]
        ]);

        $response = file_get_contents(API_URL . 'check-token', false, $context);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);
        return $data['valid'] ?? false;
    } catch (Exception $e) {
        return false;
    }
}


//
/**
 * Valide un path de redirection contre une liste de chemins autorisés
 * 
 * @param string|null $path Le path à valider
 * @param string $default_path Path par défaut en cas d'échec
 * @return string Path validé et sécurisé
 */
function validate_redirect_path($path = null, $default_path = '/admin/dashboard/')
{
    // Liste des chemins autorisés (définis par défaut dans la fonction)
    $allowed_paths = [
        '/admin/dashboard/',
        '/admin/dashboard/stats/',
        '/admin/dashboard/reports/',
        '/admin/dashboard/notifications/',
        '/admin/dashboard/activities/',
        '/admin/products/',
        '/admin/products/add/',
        '/admin/products/list/',
        '/admin/products/categories/',
        '/admin/products/stock/',
        '/admin/products/promotions/',
        '/admin/deliverers/',
        '/admin/orders/',
        '/admin/profile/',
        '/admin/settings/',
    ];

    // Si pas de path fourni, retourner le défaut
    if (!$path) {
        return $default_path;
    }

    // Nettoyer le path
    $path = trim($path);
    $path = filter_var($path, FILTER_SANITIZE_URL);

    // Vérifications de sécurité de base
    if (empty($path)) {
        return $default_path;
    }

    // Empêcher les redirections externes
    if (preg_match('/^https?:\/\//', $path) || strpos($path, '//') === 0) {
        return $default_path;
    }

    // Empêcher les caractères dangereux
    if (preg_match('/[<>"\'&\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $path)) {
        return $default_path;
    }

    // Empêcher la traversée de répertoires
    if (strpos($path, '..') !== false) {
        return $default_path;
    }

    // S'assurer que le path commence par /
    if (!str_starts_with($path, '/')) {
        $path = '/' . $path;
    }

    // Vérifier que le path est dans la liste des chemins autorisés
    if (!in_array($path, $allowed_paths, true)) {
        return $default_path;
    }

    return $path;
}
