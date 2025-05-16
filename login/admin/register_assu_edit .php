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
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit A Profile  </h6>
  </div>

  <div class="card-body">

 <?php 

 if(isset($_POST['edit_assu_btn'])){
    $id = $_POST['edit_assu'];
    $query= "SELECT * FROM  assurance WHERE id='$id' ";
    $query_run=mysqli_query($connection,$query);   
    foreach($query_run as $row){
        ?>
        
<div class="modal-body">
<form action="code.php" method="post" id="form">
              
        <input type="hidden" name="edit_id" value="<?php echo $row['id']?>">
        <div class="form-row">
    <div class="form-group col-md-6">
        <label>Patente</label>
        <input type="number" name="patente_edit" class="form-control" value="<?php echo $row['patente_assu']; ?>" required>
    </div>

    <div class="form-group col-md-6">
        <label>Name</label>
        <input type="text" name="name_edit" class="form-control" value="<?php echo $row['name']; ?>" required>
    </div>
</div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub-edit" id="public" value="true" required>
                <label class="form-check-label" for="public">Public</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub-edit" id="private" value="false">
                <label class="form-check-label" for="private">Private</label>
              </div>
              <div class="form-row">
    <div class="form-group col-md-6">
        <label>Email to log in</label>
        <input type="email" name="email_edit" id="email" class="form-control" value="<?php echo $row['email']; ?>" readonly>
    </div>

    <div class="form-group col-md-6">
        <label>Phone</label>
        <input type="tel" name="tel_edit" id="tel" class="form-control" value="<?php echo $row['tele_assu']; ?>" required>
    </div>
</div>
        
        <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="eye-icon">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            <div id="message"></div>
        

        <a href="register_assu.php" class="btn btn-danger">CANCEL</a>
        <button type="submit" name ="updatebtn_assu" class="btn btn-primary" >Update</button>
        </form>
        <?php
    }
 }
 ?>

</div>


    

    </div>
  </div>
</div>



<script src="js/script.js"></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>