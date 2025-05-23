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


<div class="modal fade" 
    id="addadminprofile" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="exampleModalLabel" 
    aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add HP profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="register-code.php" method="POST" id="form">

        <div class="modal-body">

            <div class="form-group" id="registerForm">
                <label>INPE</label>
                <input type="text" id="inpe" name="inpe" class="form-control" placeholder="Enter INPE" required>
            </div>
            <h6 id="msg"></h6>
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="name1" class="form-control" placeholder="Enter First Name" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="name2" class="form-control" placeholder="Enter Last Name" id="name" required>
                  </div>
                </div>
              </div>
            <div class="mb-3">
                <label class="form-label d-block">Designation</label>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="doctor" value="doctor" required>
                  <label class="form-check-label" for="doctor">Doctor</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="pharmacy" value="pharmacy">
                  <label class="form-check-label" for="pharmacy">Pharmacy</label>
                </div>
              </div>
              <div class="mb-3" id="specialtyContainer" style="display: none;">
                <label for="specialty" class="form-label">Specialty</label>
                <select class="form-control" name="spec" id="specialty" required>
                  <!-- options will be added dynamically -->
                </select>
              </div>
              <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"  required>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn_Hp" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Health professionals
            <button type="button" 
            class="btn btn-primary " 
            data-toggle="modal" 
            data-target="#addadminprofile">
              Add A profile Medical
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
      $query ="SELECT * FROM health_professionals";
      $query_run = mysqli_query($connection,$query);
    ?>
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> INPE </th>
            <th> Name </th>
            <th>Email </th>
            <th>Type</th>
            <th>Specialty</th>
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
            <td><?php echo $row['inpe']; ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><a href="mailto:<?php echo $row['email']; ?>">
              <?php echo $row['email']; ?>
            </a></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['specialty']; ?></td>
            <td>
                <form action="register_Hp_edit.php" method="post">
                    <input type="hidden" name="edit_hp" value="<?php  echo $row['id']; ?>">
                    <button  type="submit" name="edit_btn_hp" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="delete-code.php" method="post">
                  <input type="hidden" name="delete_hp" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_btn_hp" class="btn btn-danger"> DELETE</button>
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