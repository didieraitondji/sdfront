<?php

define('ACCESS_ALLOWED', true);
require_once './../config.php';

// script de deconnexion
session_start();
session_unset();
session_destroy();

redirect_to('./');
