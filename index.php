<?php
/**
 * HouseHub - Front Controller
 *
 * MVC entry point:
 * Request -> Controller -> View -> Layout
 */

require_once __DIR__ . '/app/controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
?>
