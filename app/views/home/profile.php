
<?php
$title = 'Become a Provider - HouseHub';
ob_start();
?>

<main>
    <section class="section">
        <div class="container">
            <div style="max-width:800px;margin:0 auto;background:#fff;border:1px solid var(--line);border-radius:14px;padding:28px;">
                <h2 style="color:var(--green);margin-bottom:12px;">Create your Provider Profile</h2>
                <p style="color:var(--muted);margin-bottom:18px;">Provide details so customers can discover your services.</p>

               <form class="provider-form" action="saveprofile.php" method="POST" enctype="multipart/form-data">

    <!-- Username + Phone -->
    <div class="row g-3">

        <div class="col-12 col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email    " required>
        </div>

        <div class="col-12 col-md-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required >
        </div>
    </div>

    <!-- Profession + Address -->
    <div class="row g-3 mt-1">
        <div class="col-12 col-md-6">
            <label for="profession" class="form-label">Profession</label>
            <select class="form-select" id="profession" name="profession" required>
                <option value=""> -- Select Profession --</option>
                <option value="Plumber">Plumber
                </option>

                <option value="Electrician">
                    Electrician
                </option>

                <option value="Carpenter">
                    Carpenter
                </option>

                <option value="Internet and Wifi setup">
                    Internet and Wifi setup
                </option>

                <option value="Home Renovation">
                    Home Renovation
                </option>
            </select>
        </div>

        <div class="col-12 col-md-6">
            <label for="address" class="form-label">Address</label>
            <input
                type="text"
                class="form-control"
                id="address"
                name="address"
                placeholder="Enter your address"
                required
            >
        </div>

    </div>


    <!-- Profile Picture -->
    <div class="mt-3">

        <label
            for="profile_image"
            class="form-label"
        >
            Profile Picture
        </label>

        <input
            type="file"
            class="form-control"
            id="profile_image"
            name="profile_image"
            accept="image/*"
        >

        <div class="form-text">
            Upload a clear profile picture.
        </div>

    </div>


    <!-- About -->
    <div class="mt-3">

        <label for="about" class="form-label"> About Me </label>

        <textarea
            class="form-control"
            id="about"
            name="about"
            rows="6"
            placeholder="Tell customers about your experience, skills and services..."
        ></textarea>

    </div>

    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
        <button class="btn btn-primary px-4" type="submit"> Save Profile</button>
        <a href="index.php" class="btn btn-light border px-4">Cancel</a>
    </div>
</form>
            </div>
        </div>
    </section>
</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>



