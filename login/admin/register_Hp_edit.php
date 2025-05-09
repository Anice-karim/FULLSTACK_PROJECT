<?php
include('../security.php'); 
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit A Profile  </h6>
  </div>

  <div class="card-body">

 <?php 

 if(isset($_POST['edit_btn_hp'])){
    $id = $_POST['edit_hp'];
    $query= "SELECT * FROM  health_professionals WHERE id_Hp='$id' ";
    $query_run=mysqli_query($connection,$query);   
    foreach($query_run as $row){
        ?>
        
<div class="modal-body">
<form action="code.php" method="post">
          
        <input type="hidden" name="edit_id" value="<?php echo $row['id_Hp']?>">
        <div class="form-group">
                <label>INPE</label>
                <input type="number" name="inpe_edit" value="<?php echo $row['inpe']?>" class="form-control" placeholder="Enter INPE" required>
            </div>
        <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="name1_edit" value="<?php echo $row['f_name_hp']?>"  class="form-control" placeholder="Enter First Name" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="name2_edit" class="form-control" value="<?php echo $row['name']?>" placeholder="Enter Last Name" required>
                  </div>
                </div>
              </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="edit_email" value="<?php echo $row['email']?>" class="form-control" placeholder="Enter Email" readonly>
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
        <div class="mb-3">
                <label class="form-label d-block">Designation</label>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type_edit" id="doctor" value="doctor" required>
                  <label class="form-check-label" for="doctor">Doctor</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type_edit" id="bri" value="Bio_Rad_Imag">
                  <label class="form-check-label" for="bri">BRI</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type_edit" id="paramedical" value="paramedical">
                  <label class="form-check-label" for="paramedical">Paramedical</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type_edit" id="pharmacy" value="pharmacy">
                  <label class="form-check-label" for="pharmacy">Pharmacy</label>
                </div>
              </div>
              <div class="mb-3" id="specialtyContainer" style="display: none;">
                <label for="specialty" class="form-label">Specialty</label>
                <select class="form-control" name="edit_spec" id="specialty">
                  <!-- options will be added dynamically -->
                </select>
              </div>

        <a href="register_Hp.php" class="btn btn-danger">CANCEL</a>
        <button type="submit" name ="updatebtn_hp" class="btn btn-primary" >Update</button>
        </form>
        <?php
    }
 }
 ?>

</div>


    

    </div>
  </div>
</div>



<script src="js/scripthp.js"></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>