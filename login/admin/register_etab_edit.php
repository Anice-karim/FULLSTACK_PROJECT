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
    <h6 class="m-0 font-weight-bold text-primary">Edit Health facilitie Profile  </h6>
  </div>

  <div class="card-body">

 <?php 

 if(isset($_POST['edit_btn_etab'])){
    $id = $_POST['edit_id_etab'];
    $query= "SELECT * FROM  etablissement WHERE id='$id' ";
    $query_run=mysqli_query($connection,$query);   
    foreach($query_run as $row){
        ?>
        
<div class="modal-body">
<form action="update-code.php" method="post" id="form">
        <input type="hidden" name="edit_id" value="<?php echo $row['id']?>">
        <div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>INPE</label>
      <input type="number" name="inpe_edit" class="form-control" value="<?php echo $row['inpe_etab'] ?>" required>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name_edit" class="form-control" value="<?php echo $row['name'] ?>" required>
    </div>
  </div>
</div>
<div class="row">
  <!-- Select Dropdown -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="typeInstitution">Type of Medical Institution</label>
      <select class="form-control" id="typeInstitution" name="type_edit" required>
        <option value="" disabled selected>Select type</option>
        <option value="hospital">Hospital</option>
        <option value="clinic">Clinic</option>
        <option value="medical_center">Medical Center</option>
        <option value="health_post">Health Post</option>
        <option value="polyclinic">Polyclinic</option>
        <option value="maternity">Maternity Hospital</option>
        <option value="rehab">Rehabilitation Center</option>
        <option value="dental">Dental Clinic</option>
        <option value="mental_health">Mental Health Facility</option>
        <option value="diagnostic">Diagnostic Center</option>
        <option value="urgent_care">Urgent Care Center</option>
        <option value="lab">Laboratory</option>
        <option value="nursing_home">Nursing Home</option>
        <option value="pharmacy">Pharmacy</option>
        <option value="blood_bank">Blood Bank</option>
        <option value="specialized">Specialized Care Center</option>
        <option value="mobile">Mobile Health Unit</option>
        <option value="school_office">School Medical Office</option>
        <option value="military">Military Medical Facility</option>
        <option value="community">Community Health Center</option>
      </select>
    </div>
  </div>

  <!-- Radio Buttons -->
  <div class="col-md-6 d-flex align-items-center">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="prv-pub_edit" id="public" value="true" required>
      <label class="form-check-label" for="public">Public</label>
    </div>

    <div class="form-check form-check-inline ms-3">
      <input class="form-check-input" type="radio" name="prv-pub_edit" id="private" value="false">
      <label class="form-check-label" for="private">Private</label>
    </div>
  </div>
</div>
        
<div class="row">
  <!-- Email -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="edit_email" value="<?php echo $row['email']?>" class="form-control" placeholder="Enter Email" required>
    </div>
  </div>

  <!-- Phone -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Phone</label>
      <input type="tel" name="edit_tele" value="<?php echo $row['tele_etab']?>" class="form-control" placeholder="Enter Phone Number" required>
    </div>
  </div>
</div>
        
        
        <a href="register_etab.php" class="btn btn-danger">CANCEL</a>
        <button type="submit" name ="updatebtn_etab" class="btn btn-primary" >Update</button>
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