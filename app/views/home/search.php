<!DOCTYPE html>
<html>
<head>
    <title>HouseHub Services</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 25px;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .filter-group {
            flex: 1;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .result-count {
            margin-bottom: 20px;
            color: #333;
        }

        .services {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .service-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .service-card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .service-info {
            padding: 18px;
        }

        .service-info h3 {
            margin: 0 0 8px;
            color: #111;
        }

        .service-info p {
            color: #666;
            margin: 5px 0;
        }

        .book-btn {
            margin-top: 12px;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        .book-btn:hover {
            background: #0056b3;
        }

        .no-result {
            display: none;
            text-align: center;
            color: #777;
            padding: 30px;
        }

        @media(max-width: 700px) {
            .filter-box {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="filter-box">

        <div class="filter-group">
            <label>Search Services</label>
            <input
                type="text"
                id="search"
                placeholder="Search services..."
                onkeyup="filterServices()"
            >
        </div>

        <div class="filter-group">
            <label>Filter by Category</label>

            <select id="category" onchange="filterServices()">
                <option value="all">All Categories</option>
                <option value="Electrical">Electrical</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Painting">Painting</option>
                <option value="Carpentry">Carpentry</option>
                <option value="Appliance">Appliance Repair</option>
                <option value="Renovation">Home Renovation</option>
            </select>
        </div>

    </div>


    <div class="result-count">
        <span id="count">7</span> services found
    </div>


    <div class="services" id="serviceList">

        <!-- Electrical -->
        <div class="service-card"
             data-name="Electrical Renovation"
             data-category="Electrical">

            <img src="images/electrical.jpg" alt="Electrical Service">

            <div class="service-info">
                <h3>Electrical Renovation</h3>
                <p>विद्युतीय नवीकरण</p>
                <p>Electrical installation and repair services.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Plumbing -->
        <div class="service-card"
             data-name="Plumbing Repair"
             data-category="Plumbing">

            <img src="images/plumbing.jpg" alt="Plumbing Service">

            <div class="service-info">
                <h3>Plumbing Repair</h3>
                <p>प्लम्बिङ मर्मत</p>
                <p>Pipe installation, leakage repair and plumbing work.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Cleaning -->
        <div class="service-card"
             data-name="Home Cleaning"
             data-category="Cleaning">

            <img src="images/cleaning.jpg" alt="Cleaning Service">

            <div class="service-info">
                <h3>Home Cleaning</h3>
                <p>घर सरसफाई</p>
                <p>Professional home and room cleaning services.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Painting -->
        <div class="service-card"
             data-name="House Painting"
             data-category="Painting">

            <img src="images/painting.jpg" alt="Painting Service">

            <div class="service-info">
                <h3>House Painting</h3>
                <p>घर रंगाउने सेवा</p>
                <p>Interior and exterior house painting services.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Carpentry -->
        <div class="service-card"
             data-name="Carpentry Service"
             data-category="Carpentry">

            <img src="images/carpentry.jpg" alt="Carpentry Service">

            <div class="service-info">
                <h3>Carpentry Service</h3>
                <p>काठको काम</p>
                <p>Furniture repair, doors, windows and woodwork.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Appliance -->
        <div class="service-card"
             data-name="Appliance Repair"
             data-category="Appliance">

            <img src="images/appliance.jpg" alt="Appliance Repair">

            <div class="service-info">
                <h3>Appliance Repair</h3>
                <p>उपकरण मर्मत</p>
                <p>Repair services for household electrical appliances.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>


        <!-- Renovation -->
        <div class="service-card"
             data-name="Home Renovation"
             data-category="Renovation">

            <img src="images/renovation.jpg" alt="Home Renovation">

            <div class="service-info">
                <h3>Home Renovation</h3>
                <p>घर नवीकरण</p>
                <p>Complete home renovation and improvement services.</p>

                <button class="book-btn">
                    Book Service
                </button>
            </div>
        </div>

    </div>


    <div class="no-result" id="noResult">
        No services found.
    </div>


    <script>

        function filterServices() {

            let search =
                document.getElementById("search").value.toLowerCase();

            let category =
                document.getElementById("category").value;

            let cards =
                document.querySelectorAll(".service-card");

            let count = 0;

            cards.forEach(function(card) {

                let name =
                    card.getAttribute("data-name").toLowerCase();

                let cardCategory =
                    card.getAttribute("data-category");

                let searchMatch =
                    name.includes(search);

                let categoryMatch =
                    category === "all" ||
                    cardCategory === category;

                if (searchMatch && categoryMatch) {

                    card.style.display = "block";
                    count++;

                } else {

                    card.style.display = "none";

                }

            });

            document.getElementById("count").innerText = count;

            if (count === 0) {
                document.getElementById("noResult").style.display = "block";
            } else {
                document.getElementById("noResult").style.display = "none";
            }
        }

    </script>

</body>
</html>