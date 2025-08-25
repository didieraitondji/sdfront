<?php
// vérifier si la session est en cours
session_start();

define('ACCESS_ALLOWED', true);
require_once './../../config.php';

if (isset($_SESSION['user']) && $_SESSION['user'] === true) {

    redirect_to('./stats/');
} else {
    redirect_to('./../../');
    exit();
}
