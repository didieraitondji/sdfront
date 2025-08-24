<?php
session_start();

if ($_GET["access"] != "true") {
    header("HTTP/1.0 403 Forbidden");
    require_once 'accesdenied.php';
    exit;
}

define('ACCESS_ALLOWED', true);
require_once 'config.php';

// création de la variable de session
$_SESSION["user"] = true;
$_SESSION["token"] = $_GET["token"] ?? null;

// Vérification du token
if (!is_token_valid($_SESSION["token"])) {
    header("HTTP/1.0 403 Forbidden");
    require_once 'accesdenied.php';
    exit;
}

// on récupère le path
$path = $_GET["path"] ?? null;

// echo "Path reçu : " . $path . "<br>";

$redirect_path = validate_redirect_path($path);


// echo "Redirection vers : " . $redirect_path;

// redirection vers la page d'accueil
redirect_to($redirect_path);
