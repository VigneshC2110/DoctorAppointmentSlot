<?php

$uri=$_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/':
        require 'home.php';
        break;
    case '/index':
        require 'home.php';
        break;
    case '/index.php':
        require 'home.php';
        break;
    case '/home':
        require 'home.php';
        break;
    case '/login':
        require 'login.php';
        break;
    case '/appointment':
        require 'appointment.php';
        break;
    case '/appointmentmembers':
        require 'appointmentmembers.php';
        break;
    case '/logout':
        require 'logout.php';
        break;    
    case '/search':
        require 'search.php';
        break;   
}

?>
