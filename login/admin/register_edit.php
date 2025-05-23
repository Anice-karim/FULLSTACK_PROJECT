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

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Edit Admin Profile</h1>

  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Edit Admin Details</h6>
        </div>
        <div class="card-body">
          <?php 
          if(isset($_POST['edit_btn'])){
            $id = $_POST['edit_id'];
            $query= "SELECT * FROM register WHERE id='$id'";
            $query_run=mysqli_query($connection,$query);   
            if(mysqli_num_rows($query_run) > 0){
              foreach($query_run as $row){
          ?>
          <form action="update-code.php" method="post" id="form">
            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="edit_username" value="<?php echo $row['name']; ?>" class="form-control" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" name="edit_email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter Email" readonly required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <input type="password" name="edit_password" id="password" class="form-control" placeholder="Enter Password" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="eye-icon">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            <h5 id="message"></h5>

            <div class="d-flex justify-content-between">
              <a href="register.php" class="btn btn-danger">Cancel</a>
              <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
            </div>
          </form>
          <?php
              }
            } else {
              echo "<h5>No record found.</h5>";
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="js/script.js"></script>
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
