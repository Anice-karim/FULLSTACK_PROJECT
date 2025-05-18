<?php
include('../security.php');
include('../includes/header.php');


$email = $_SESSION['email'];
$table = $_SESSION['table'];

// Fetch current user data
$query = "SELECT * FROM $table WHERE email = '$email'";
$query_run = mysqli_query($connection, $query);

if (!$query_run || mysqli_num_rows($query_run) == 0) {
    echo "User not found!";
    exit();
}
$user = mysqli_fetch_assoc($query_run);
include('../includes/navbar.php');
?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh; margin-top: 10px; margin-bottom: 50px;">
    <div class="card shadow profile-card mx-3 my-5" style="width: 100%; max-width: 600px;">
        <div class="profile-header text-center">
            <h3>Edit Profile</h3>
        </div>
        <p class="message"><?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; unset($_SESSION['message']); } ?></p>

        <!-- Profile Edit Form -->
        <form action="profile-code.php" method="POST" enctype="multipart/form-data" id="form">
        <fieldset>
        <legend>Change Password</legend>
        <div class="form-group">
            <label for="current_password">Current Password:</label>
            <div class="input-group">
            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter Current Password" >
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="eye-icon-1">
                <i class="fas fa-eye"></i>
                </button>
            </div>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password">New Password:</label>
            <div class="input-group">
            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter New Password" >
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="eye-icon-2">
                <i class="fas fa-eye"></i>
                </button>
            </div>
            </div>
        </div>
        </fieldset>

            <fieldset>
                <legend>Change Profile Picture</legend>
                <div class="form-group text-center">
                    <input type="file" class="form-control" name="profile_pic" accept="image/*"><br><br>
                </div>
            </fieldset>

            <!-- Submit Button -->
            <button type="submit" name="edit_btn" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>



<script src="js/script.js"></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
