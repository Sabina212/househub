<?php

include("connection.php");

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search == "") {
    header("Location: index.php");
    exit();
}

/*
    Search service name, category and provider name
*/

$search_safe = mysqli_real_escape_string($conn, $search);

$sql = "SELECT *
        FROM services
        WHERE service_name LIKE '%$search_safe%'
        OR category LIKE '%$search_safe%'
        OR provider_name LIKE '%$search_safe%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HouseHub - Search Results</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #17231d;
        }

        /* HEADER */

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

        /* SEARCH */

        .search-container {
            width: 90%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .search-form {
            width: 650px;
            height: 55px;
            display: flex;
            border: 1px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .search-form input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 20px;
            font-size: 16px;
        }

        .search-form button {
            width: 140px;
            border: none;
            background: #159447;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        /* RESULTS */

        .content {
            width: 90%;
            max-width: 1200px;
            margin: 45px auto;
        }

        .result-title {
            font-size: 24px;
            margin-bottom: 35px;
        }

        .result-title span {
            color: #159447;
        }

        .main {
            display: flex;
            gap: 45px;
        }

        /* CATEGORIES */

        .categories {
            width: 190px;
            flex-shrink: 0;
        }

        .categories h4 {
            font-size: 12px;
            color: #87938c;
            margin-bottom: 25px;
        }

        .categories a {
            display: block;
            text-decoration: none;
            color: #274d3a;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .categories a:hover {
            color: #159447;
        }

        /* SERVICES */

        .services-area {
            flex: 1;
        }

        .services-area h2 {
            margin-top: 0;
            font-size: 20px;
            margin-bottom: 25px;
        }

        .services {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .service-card {
            border: 1px solid #eeeeee;
            border-radius: 12px;
            padding: 20px;
            background: white;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
            transition: 0.2s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.10);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: #e9f8ee;
            color: #159447;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .service-name {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .category {
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        .provider {
            font-size: 14px;
            color: #444;
            margin-bottom: 12px;
        }

        .price {
            color: #f4512a;
            font-size: 16px;
            font-weight: bold;
        }

        .no-result {
            padding: 40px;
            background: #f8faf9;
            border-radius: 12px;
            color: #666;
            font-size: 17px;
        }

        /* RESPONSIVE */

        @media(max-width: 900px) {

            .header {
                padding: 0 20px;
            }

            .nav {
                gap: 12px;
            }

            .search-form {
                width: 100%;
            }

            .main {
                flex-direction: column;
            }

            .categories {
                width: 100%;
            }

            .services {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {

            .nav a {
                display: none;
            }

            .services {
                grid-template-columns: 1fr;
            }

            .search-form button {
                width: 110px;
            }
        }

    </style>

</head>

<body>


<!-- HEADER -->

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

        <a href="index.php">Home</a>

        <a href="service.php">Services</a>

        <a href="providers.php">Providers</a>

        <a href="#">How It Works</a>

        <a href="login.php" class="login">Login</a>

        <a href="register.php" class="join">
            Join HouseHub
        </a>

    </div>

</div>


<!-- SEARCH -->

<div class="search-container">

    <form action="search.php" method="GET" class="search-form">

        <input
            type="text"
            name="search"
            value="<?php echo htmlspecialchars($search); ?>"
            placeholder="What service do you need?"
            required
        >

        <button type="submit">
            Search
        </button>

    </form>

</div>


<!-- RESULTS -->

<div class="content">

    <div class="result-title">

        Available Results for
        "<span><?php echo htmlspecialchars($search); ?></span>"

    </div>


    <div class="main">


        <!-- CATEGORIES -->

        <div class="categories">

            <h4>CATEGORIES</h4>

            <a href="search.php?search=Home Repairs">
                Home Repairs
            </a>

            <a href="search.php?search=Plumbing">
                Plumbing
            </a>

            <a href="search.php?search=Automobile">
                Automobile
            </a>

            <a href="search.php?search=Hire a Driver">
                Hire a Driver
            </a>

            <a href="search.php?search=Tech and Digital Services">
                Tech and Digital Services
            </a>

            <a href="search.php?search=Personal Service">
                Personal Service
            </a>

            <a href="search.php?search=Pet Care">
                Pet Care
            </a>

            <a href="search.php?search=Professional Services">
                Professional Services
            </a>

            <a href="search.php?search=Electrical">
                Electrical
            </a>

            <a href="search.php?search=Carpentry">
                Carpentry
            </a>

        </div>


        <!-- SERVICES -->

        <div class="services-area">

            <h2>Services</h2>


            <?php

            if (mysqli_num_rows($result) > 0) {

            ?>

                <div class="services">

                    <?php

                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                        <div class="service-card">

                            <div class="service-icon">

                                <?php

                                $category = strtolower(
                                    $row['category']
                                );

                                if (
                                    strpos(
                                        $category,
                                        'electric'
                                    ) !== false
                                ) {

                                    echo "⚡";

                                } elseif (
                                    strpos(
                                        $category,
                                        'plumb'
                                    ) !== false
                                ) {

                                    echo "🔧";

                                } elseif (
                                    strpos(
                                        $category,
                                        'carp'
                                    ) !== false
                                ) {

                                    echo "🪚";

                                } else {

                                    echo "🛠️";

                                }

                                ?>

                            </div>


                            <div class="service-name">

                                <?php

                                echo htmlspecialchars(
                                    $row['service_name']
                                );

                                ?>

                            </div>


                            <div class="category">

                                Category:
                                <?php

                                echo htmlspecialchars(
                                    $row['category']
                                );

                                ?>

                            </div>


                            <div class="provider">

                                Provider:
                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $row['provider_name']
                                    );

                                    ?>

                                </strong>

                            </div>


                            <div class="price">

                                From Rs
                                <?php

                                echo htmlspecialchars(
                                    $row['price']
                                );

                                ?>

                            </div>

                        </div>

                    <?php

                    }

                    ?>

                </div>

            <?php

            } else {

            ?>

                <div class="no-result">

                    No services found for

                    <strong>
                        "<?php echo htmlspecialchars($search); ?>"
                    </strong>

                    <br><br>

                    Try searching for:
                    electrician, plumbing, carpenter,
                    automobile, repair, etc.

                </div>

            <?php

            }

            ?>

        </div>

    </div>

</div>


</body>
</html>