<?php
define('ACCESS_ALLOWED', true);
require_once './../../../config.php';

header('Content-Type: application/json');

if (!isset($_GET['type_id'])) {
    echo json_encode([]);
    exit;
}

$typeId = intval($_GET['type_id']);

// Ici tu appelles ta fonction pour récupérer les catégories
$categories = get_categories_by_type($typeId);

echo json_encode($categories);
