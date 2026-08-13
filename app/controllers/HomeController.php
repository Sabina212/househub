<?php

require_once "connection.php";

require_once "app/views/home/index.php";
/**
 * HouseHub Home Controller
 * 
 */
class HomeController
{
    public function index(): void
    {
        $services = [
            [
                'name' => 'Electrician',
                'icon' => '⚡',
                'description' => 'Wiring, switches, sockets, lights and electrical repairs.',
                'price' => 'From Rs. 500'
            ],
            [
                'name' => 'Plumber',
                'icon' => '🔧',
                'description' => 'Pipe fitting, leakage repair, taps, sinks and bathroom work.',
                'price' => 'From Rs. 400'
            ],
            [
                'name' => 'Mechanic',
                'icon' => '🔩',
                'description' => 'Reliable vehicle inspection, repair and maintenance services.',
                'price' => 'From Rs. 700'
            ],
            [
                'name' => 'Washing Machine',
                'icon' => '🧺',
                'description' => 'Washing machine diagnosis, repair, installation and servicing.',
                'price' => 'From Rs. 500'
            ],
            [
                'name' => 'Carpenter',
                'icon' => '🪚',
                'description' => 'Furniture repair, custom work, doors and wooden installations.',
                'price' => 'From Rs. 600'
            ],
            [
                'name' => 'Internet & WiFi',
                'icon' => '📶',
                'description' => 'Router installation, WiFi setup and home network support.',
                'price' => 'From Rs. 350'
            ],
        ];

        $featuredProviders = [];

        // Use existing database when available.
        $connectionFile = __DIR__ . '/../../connection.php';
        if (file_exists($connectionFile)) {
            require_once $connectionFile;

            if (isset($conn) && $conn instanceof mysqli) {
                $sql = "SELECT id, about
                        FROM provider_profile
                        ORDER BY id DESC
                        LIMIT 6";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $featuredProviders[] = $row;
                    }
                }
            }
        }

        require __DIR__ . '/../views/home/index.php';
    }
}
?>
