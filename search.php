<?php
/**
 * HouseHub - Front Controller
 *
 * MVC entry point:
 * Request -> Controller -> View -> Layout
 */

require  __DIR__ . '/app/veiws/home/search.php';

$controller = new HomeController();
$controller->index();
?>