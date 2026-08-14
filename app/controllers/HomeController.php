<?php

require_once __DIR__ . '/../../connection.php';

class HomeController
{
    private mysqli $conn;

    public function __construct()
    {
        global $conn;

        $this->conn = $conn;
    }

    public function index(): void
    {
        $iconMap = [
            'Electrician' => '⚡',
            'Plumber' => '🚰',
            'Networking Service Provider' => '🌐',
            'Washing Machine Repairer' => '🧺',
            'Painter' => '🎨',
            'Carpenter' => '🪛',
            'Automobile Mechanic' => '🔧',
        ];

        $services = [];
        $featuredProviders = [];

        $sql = "
            SELECT id, service_name
            FROM service_type
            ORDER BY id ASC
        ";

        $result = mysqli_query($this->conn, $sql);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                $services[] = [
                    'id'   => $row['id'],
                    'name' => $row['service_name'],
                    'icon' => $iconMap[$row['service_name']] ?? '🔧'
                ];

            }
        }

        // Other queries...
        // ==============================
        // FETCH FEATURED PROVIDERS
        // ==============================

        $sql = "
            SELECT
                u.id,
                u.name AS username,
                u.city AS address,
                pp.`profile-img` AS profile_img,

                GROUP_CONCAT(
                    DISTINCT st.service_name
                    ORDER BY st.service_name
                    SEPARATOR ', '
                ) AS profession,

                MAX(pp.about) AS about

            FROM `user` u

            INNER JOIN provider_services ps
                ON u.id = ps.provider_id

            INNER JOIN service_type st
                ON ps.service_type_id = st.id

            LEFT JOIN provider_profile pp
                ON u.id = pp.provider_id

            WHERE u.role = 'provider'

            GROUP BY
                u.id,
                u.name,
                u.city,
                pp.`profile-img`

            ORDER BY u.id DESC

            LIMIT 6
        ";

        $result = mysqli_query($this->conn, $sql);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {
                $featuredProviders[] = $row;
            }

        } else {

            die("Provider query failed: " . mysqli_error($conn));

        }


        require __DIR__ . '/../views/home/index.php';
    }
}
?>