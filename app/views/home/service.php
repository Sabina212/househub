<?php

include("connection.php");

$search = "";
$location = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if (isset($_GET['location'])) {
    $location = trim($_GET['location']);
}

if ($search == "" && $location == "") {
    header("Location: index.php");
    exit();
}


/* =====================================================
   SEARCH PROVIDERS
   ===================================================== */

$search_safe = mysqli_real_escape_string($conn, $search);
$location_safe = mysqli_real_escape_string($conn, $location);

$sql = "
    SELECT
        u.id AS provider_id,
        u.name AS provider_name,
        u.email,
        u.city,

        ps.service_type_id,

        st.service_name,

        pp.`profile-img`,
        pp.about

    FROM user u

    INNER JOIN provider_services ps
        ON u.id = ps.provider_id

    INNER JOIN service_type st
        ON ps.service_type_id = st.id

    LEFT JOIN provider_profile pp
        ON u.id = pp.provider_id

    WHERE u.role = 'provider'
";


/* SERVICE SEARCH */

if ($search != "") {

    $sql .= "
        AND (
            st.service_name LIKE '%$search_safe%'
            OR u.name LIKE '%$search_safe%'
            OR u.city LIKE '%$search_safe%'
        )
    ";

}


/* LOCATION SEARCH */

if ($location != "") {

    $sql .= "
        AND u.city = '$location_safe'
    ";

}


$sql .= "
    ORDER BY u.name ASC
";


$result = mysqli_query($conn, $sql);


if (!$result) {

    die(
        "Database Error: " .
        mysqli_error($conn)
    );

}


/* =====================================================
   GET ALL SERVICES FOR SIDEBAR
   ===================================================== */

$service_sql = "
    SELECT id, service_name
    FROM service_type
    ORDER BY service_name ASC
";

$service_result = mysqli_query(
    $conn,
    $service_sql
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        HouseHub - Search Results
    </title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {

            font-family: Arial, sans-serif;

            background: #ffffff;

            color: #17231d;

        }


        /* ==========================================
           HEADER
        ========================================== */

        .header {

            height: 65px;

            border-bottom: 1px solid #eeeeee;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 55px;

        }


        .logo {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 22px;

            font-weight: bold;

        }


        .logo-box {

            width: 35px;

            height: 35px;

            background: #159447;

            color: white;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

        }


        .logo-text span {

            color: #159447;

        }


        .nav {

            display: flex;

            align-items: center;

            gap: 30px;

        }


        .nav a {

            text-decoration: none;

            color: #59635e;

            font-size: 14px;

        }


        .nav a:hover {

            color: #159447;

        }


        .login {

            color: #17231d !important;

            font-weight: bold;

        }


        .join {

            background: #159447;

            color: white !important;

            padding: 12px 18px;

            border-radius: 10px;

            font-weight: bold;

        }


        /* ==========================================
           SEARCH BOX
        ========================================== */

        .search-container {

            width: 90%;

            max-width: 1000px;

            margin: 30px auto;

        }


        .search-form {

            width: 100%;

            min-height: 60px;

            display: flex;

            align-items: center;

            background: white;

            border: 1px solid #dce7e1;

            border-radius: 15px;

            overflow: hidden;

            box-shadow:
                0 5px 20px rgba(0,0,0,0.06);

        }


        .search-input-area {

            flex: 1;

            display: flex;

            align-items: center;

            padding-left: 18px;

        }


        .search-icon {

            font-size: 22px;

            margin-right: 12px;

            color: #527064;

        }


        .search-form input {

            flex: 1;

            height: 55px;

            border: none;

            outline: none;

            padding: 0 10px;

            font-size: 16px;

        }


        /* ==========================================
           LOCATION
        ========================================== */

        .location-area {

            width: 230px;

            border-left: 1px solid #dce7e1;

            padding-left: 10px;

        }


        .location-area select {

            width: 100%;

            height: 55px;

            border: none;

            outline: none;

            background: white;

            padding: 0 12px;

            font-size: 16px;

            cursor: pointer;

        }


        /* ==========================================
           SEARCH BUTTON
        ========================================== */

        .search-form button {

            height: 52px;

            margin-right: 5px;

            padding: 0 25px;

            border: none;

            border-radius: 11px;

            background: #159447;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

        }


        .search-form button:hover {

            background: #0d7738;

        }


        /* ==========================================
           CONTENT
        ========================================== */

        .content {

            width: 90%;

            max-width: 1200px;

            margin: 40px auto;

        }


        .result-title {

            font-size: 24px;

            margin-bottom: 30px;

        }


        .result-title span {

            color: #159447;

        }


        .main {

            display: flex;

            gap: 35px;

        }


        /* ==========================================
           CATEGORIES
        ========================================== */

        .categories {

            width: 210px;

            flex-shrink: 0;

        }


        .categories h4 {

            font-size: 12px;

            color: #87938c;

            margin-bottom: 20px;

        }


        .categories a {

            display: block;

            text-decoration: none;

            color: #274d3a;

            font-size: 14px;

            margin-bottom: 15px;

            padding: 9px 10px;

            border-radius: 7px;

        }


        .categories a:hover {

            background: #e9f8ee;

            color: #159447;

        }


        /* ==========================================
           SERVICES AREA
        ========================================== */

        .services-area {

            flex: 1;

        }


        .services-area h2 {

            margin-top: 0;

            font-size: 20px;

            margin-bottom: 20px;

        }


        .services {

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 20px;

        }


        /* ==========================================
           PROVIDER CARD
        ========================================== */

        .service-card {

            border: 1px solid #eeeeee;

            border-radius: 14px;

            padding: 20px;

            background: white;

            box-shadow:
                0 3px 12px rgba(0,0,0,0.06);

            transition: 0.2s;

        }


        .service-card:hover {

            transform: translateY(-3px);

            box-shadow:
                0 8px 20px rgba(0,0,0,0.10);

        }


        .provider-top {

            display: flex;

            align-items: center;

            gap: 15px;

            margin-bottom: 15px;

        }


        /* ==========================================
           PROFILE IMAGE
        ========================================== */

        .provider-image {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid #e9f8ee;

        }


        .no-image {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            background: #e9f8ee;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 30px;

        }


        /* ==========================================
           PROVIDER DETAILS
        ========================================== */

        .provider-name {

            font-size: 18px;

            font-weight: bold;

            margin-bottom: 5px;

        }


        .service-name {

            color: #159447;

            font-weight: bold;

            margin-bottom: 5px;

        }


        .location {

            color: #666;

            font-size: 14px;

        }


        .about {

            color: #777;

            font-size: 14px;

            line-height: 1.5;

            margin: 12px 0;

        }


        /* ==========================================
           VIEW PROFILE
        ========================================== */

        .view-profile {

            display: inline-block;

            margin-top: 5px;

            padding: 10px 16px;

            background: #159447;

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-size: 14px;

            font-weight: bold;

        }


        .view-profile:hover {

            background: #0d7738;

        }


        /* ==========================================
           NO RESULT
        ========================================== */

        .no-result {

            padding: 40px;

            background: #f8faf9;

            border-radius: 12px;

            color: #666;

            font-size: 17px;

            text-align: center;

        }


        /* ==========================================
           RESPONSIVE
        ========================================== */

        @media(max-width: 900px) {

            .header {

                padding: 0 20px;

            }


            .nav {

                gap: 12px;

            }


            .main {

                flex-direction: column;

            }


            .categories {

                width: 100%;

            }


            .services {

                grid-template-columns: 1fr;

            }

        }


        @media(max-width: 650px) {

            .nav a {

                display: none;

            }


            .search-form {

                flex-direction: column;

                padding: 8px;

            }


            .search-input-area {

                width: 100%;

            }


            .location-area {

                width: 100%;

                border-left: none;

                border-top: 1px solid #eeeeee;

            }


            .search-form input {

                width: 100%;

            }


            .search-form button {

                width: 100%;

                margin: 8px 0 0 0;

            }

        }

    </style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<div class="header">


    <div class="logo">

        <div class="logo-box">

            H

        </div>


        <div class="logo-text">

            House<span>Hub</span>

        </div>

    </div>


    <div class="nav">

        <a href="index.php">
            Home
        </a>

        <a href="service.php">
            Services
        </a>

        <a href="providers.php">
            Providers
        </a>

        <a href="#">
            How It Works
        </a>

        <a href="login.php" class="login">
            Login
        </a>

        <a href="register.php" class="join">
            Join HouseHub
        </a>

    </div>

</div>



<!-- ==========================================
     SEARCH
========================================== -->

<div class="search-container">


    <form action="find_provider.php" method="GET" class="hero-search">

    <div class="search-service">
        <span>⌕</span>

        <input
            type="text"
            name="service"
            placeholder="What service do you need?"
            required
        >
    </div>

    <div class="search-location">

        <select name="location">

            <option value="">Your location</option>

            <option value="Kathmandu">
                Kathmandu
            </option>

            <option value="Lalitpur">
                Lalitpur
            </option>

            <option value="Bhaktapur">
                Bhaktapur
            </option>

        </select>

    </div>

    <button type="submit">
        Find a Provider
    </button>

</form>

</div>



<!-- ==========================================
     RESULTS
========================================== -->

<div class="content">


    <div class="result-title">

        Search Results

        <?php if ($search != ""): ?>

            for

            <span>
                "<?php echo htmlspecialchars($search); ?>"
            </span>

        <?php endif; ?>


        <?php if ($location != ""): ?>

            in

            <span>
                "<?php echo htmlspecialchars($location); ?>"
            </span>

        <?php endif; ?>

    </div>



    <div class="main">


        <!-- ======================================
             SERVICE LIST
        ======================================= -->

        <div class="categories">

            <h4>
                SERVICES
            </h4>


            <?php

            if (
                $service_result &&
                mysqli_num_rows($service_result) > 0
            ):

                while (
                    $service =
                    mysqli_fetch_assoc($service_result)
                ):

            ?>

                <a
                    href="search.php?search=<?php
                        echo urlencode(
                            $service['service_name']
                        );
                    ?>"
                >

                    <?php
                    echo htmlspecialchars(
                        $service['service_name']
                    );
                    ?>

                </a>


            <?php

                endwhile;

            endif;

            ?>

        </div>



        <!-- ======================================
             PROVIDER RESULTS
        ======================================= -->

        <div class="services-area">


            <h2>
                Available Providers
            </h2>


            <?php

            if (
                mysqli_num_rows($result) > 0
            ):

            ?>


                <div class="services">


                    <?php

                    while (
                        $row =
                        mysqli_fetch_assoc($result)
                    ):

                    ?>


                        <div class="service-card">


                            <!-- PROVIDER TOP -->

                            <div class="provider-top">


                                <?php

                                if (
                                    !empty(
                                        $row['profile-img']
                                    )
                                ):

                                ?>

                                    <img
                                        src="uploads/<?php
                                            echo htmlspecialchars(
                                                $row['profile-img']
                                            );
                                        ?>"
                                        class="provider-image"
                                        alt="Provider"
                                    >

                                <?php else: ?>

                                    <div class="no-image">

                                        👤

                                    </div>

                                <?php endif; ?>



                                <div>


                                    <!-- PROVIDER NAME -->

                                    <div class="provider-name">

                                        <?php

                                        echo htmlspecialchars(
                                            $row['provider_name']
                                        );

                                        ?>

                                    </div>


                                    <!-- SERVICE -->

                                    <div class="service-name">

                                        <?php

                                        echo htmlspecialchars(
                                            $row['service_name']
                                        );

                                        ?>

                                    </div>


                                    <!-- LOCATION -->

                                    <div class="location">

                                        📍

                                        <?php

                                        echo htmlspecialchars(
                                            $row['city']
                                        );

                                        ?>

                                    </div>


                                </div>


                            </div>



                            <!-- ABOUT -->

                            <?php

                            if (
                                !empty($row['about'])
                            ):

                            ?>

                                <div class="about">

                                    <?php

                                    echo htmlspecialchars(
                                        substr(
                                            $row['about'],
                                            0,
                                            120
                                        )
                                    );

                                    ?>

                                </div>

                            <?php endif; ?>



                            <!-- PROFILE BUTTON -->

                            <a
                                href="provider_profile.php?id=<?php
                                    echo $row['provider_id'];
                                ?>"
                                class="view-profile"
                            >

                                View Profile

                            </a>


                        </div>


                    <?php

                    endwhile;

                    ?>


                </div>


            <?php else: ?>


                <div class="no-result">

                    <h3>
                        No Provider Found
                    </h3>


                    <br>


                    No provider found for

                    <strong>

                        "<?php
                        echo htmlspecialchars($search);
                        ?>"

                    </strong>


                    <?php if ($location != ""): ?>

                        in

                        <strong>

                            <?php
                            echo htmlspecialchars(
                                $location
                            );
                            ?>

                        </strong>

                    <?php endif; ?>


                    <br><br>


                    Try searching for:

                    <br><br>

                    Electrician • Plumber • Painter •
                    Carpenter • Networking •
                    Washing Machine Repairer •
                    Automobile Mechanic

                </div>


            <?php endif; ?>


        </div>


    </div>

</div>


</body>

</html>