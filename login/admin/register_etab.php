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

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Health facilitie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="register-code.php" method="POST" id="form">

        <div class="modal-body">

            <div class="form-group">
                <label>INPE</label>
                <input type="number" id="inpe" name="inpe" class="form-control" placeholder="Enter INPE" required>
            </div>
            <h6 id="msg"></h6>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="typeInstitution" class="form-label">Type of Medical Institution</label>
                <select class="form-control" id="typeInstitution" name="type" required>
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
            <div class="mb-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub" id="public" value="true" required>
                <label class="form-check-label" for="public">Public</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub" id="private" value="false">
                <label class="form-check-label" for="private">Private</label>
              </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"  required>
                
                </div>
              </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="+212 6..." required>
            </div>
            
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn_etab" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Health facilitie Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Health facilitie
            </button>
    </h6>
  </div>

  <div class="card-body">

    <?php 
    if (isset($_SESSION['success']) && $_SESSION['success'] != ''){
      echo '<h2>'.$_SESSION['success'].'</h2';
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['status']) && $_SESSION['status'] != ''){
      echo '<h2>'.$_SESSION['status'].'</h2';
      unset($_SESSION['status']);
    }
    ?>
    <div class="table-responsive">
     <?php 
      $query ="SELECT * FROM etablissement";
      $query_run = mysqli_query($connection,$query);
    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>INPE</th>
            <th>NAME</th>
            <th>Type</th>
            <th>Email </th>
            <th>Phone</th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
     <?php 
       if(mysqli_num_rows($query_run)>0){
        while($row = mysqli_fetch_assoc($query_run))
        {
          ?>
          
          <tr>
            <td><?php echo $row['inpe_etab']; ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['type_etab']; ?></td>
            <td><a href="mailto:<?php echo $row['email']; ?>">
              <?php echo $row['email']; ?>
            </a></td>
            <td><a href="tel:<?php echo $row['tele_etab']; ?>">
              <?php echo $row['tele_etab']; ?>
            </a></td>
            <td>
                <form action="register_etab_edit.php" method="post">
                    <input type="hidden" name="edit_id_etab" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="edit_btn_etab" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="delete-code.php" method="post">
                  <input type="hidden" name="delete_etab" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_btn_etab" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
          </tr>
          <?php
        }
      }
      else {
        echo "No Record Found";
      }
      ?>
        
        </tbody>
      </table> 

    </div>
  </div>
  </div>

</div>
<!-- /.container-fluid -->
<script src="js/script.js"></script>
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>