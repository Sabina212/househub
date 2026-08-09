<!DOCTYPE html>
<html>
<head>
    <title>My Portfolio - HouseHub</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #263b4d;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #263b4d;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #344f65;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #263b4d;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Create Your Portfolio</h2>

    <form action="saveportfolio.php" method="POST">

        <label>Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Profession</label>
        <input type="text" name="profession" placeholder="Example: Electrician" required>

        <label>Experience</label>
        <input type="text" name="experience" placeholder="Example: 5 years" required>

        <label>Location</label>
        <input type="text" name="location" placeholder="Enter your location" required>

        <label>Phone</label>
        <input type="text" name="phone" placeholder="Enter your phone number" required>

        <label>Services</label>
        <input type="text" name="services" placeholder="Example: Wiring, Repair, Installation" required>

        <label>Availability</label>
        <select name="availability" required>
            <option value="">Select Availability</option>
            <option value="Available">Available</option>
            <option value="Not Available">Not Available</option>
        </select>

        <label>About You</label>
        <textarea name="description"
                  placeholder="Write something about yourself"></textarea>

        <button type="submit">Save Portfolio</button>

    </form>

    <a href="dashboard.php" class="back">
        ← Back to Dashboard
    </a>

</div>

</body>
</html>