<?php

include('../security.php');
include('../includes/header.php');


$email = $_SESSION['email'];
$table = $_SESSION['table'];

$query = "SELECT * FROM $table WHERE email = '$email'";
$query_run = mysqli_query($connection, $query);

if (!$query_run || mysqli_num_rows($query_run) == 0) {
    echo "User not found!";
    exit();
}

$user = mysqli_fetch_assoc($query_run);
include('../includes/navbar.php');

?>

<div class="container profile-container mt-5 mb-5">
    <div class="card shadow profile-card">
        <div class="profile-header">
            <!-- Display user profile photo -->
            <img src="uploads/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" alt="Profile Picture"
                 alt="Profile Photo" 
                 class="profile-image">
            <div class="user-info">
                <h4><?php echo $user['name']; ?></h4>
                <p class="text-muted"><?php echo $user['email']; ?></p>
                <!-- Link to edit profile page -->
                <a href="profile_edit.php" class="profile-button">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
