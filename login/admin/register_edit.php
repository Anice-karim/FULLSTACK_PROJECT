<?php
include('../security.php'); 
include('../includes/header.php'); 
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
          <form action="code.php" method="post">
            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="edit_username" value="<?php echo $row['name']; ?>" class="form-control" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" name="edit_email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter Email" required>
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="edit_password" class="form-control" placeholder="Enter Password" required>
            </div>

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

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
