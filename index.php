<?php

/**
 * Front controller
 *
 * -Application.php initialisation
 * -Class autoload
 * - find controller for a client request
 */

include_once('_config.php');

/* initialisation des fichiers TWIG */
require_once 'vendor/autoload.php';
require_once 'vendor/twig/twig/lib/Twig/autoloader.php';


/** Autoload */
MyAutoload::start();

$request = $_GET['r'];

if ($request == "")  {
    $request = "home.html";
}else {
    $request = $_GET['r'] ;

}

// Routeur

$routeur = new Routeur($request);
$routeur ->findController();
