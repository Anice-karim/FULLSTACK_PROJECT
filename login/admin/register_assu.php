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
        <h5 class="modal-title" id="exampleModalLabel">Add  Insurance Company profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label>Patente</label>
                <input type="number" name="patente" class="form-control" placeholder="Enter INPE" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name" required>
            </div>
            
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub" id="public" value="true" required>
                <label class="form-check-label" for="public">Public</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prv-pub" id="private" value="false">
                <label class="form-check-label" for="private">Private</label>
              </div>



             
              <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" readonly  required>
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="generateEmail()">Auto</button>
                    </div>
                </div>
</div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="tel" id="tel" class="form-control" placeholder="06" required>
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
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <div class="input-group">
                  <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="eye-icon-confirm">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn_assu" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Insurance Company
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#addadminprofile">
              Add A Insurance Company Profile
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
      $query ="SELECT * FROM assurance";
      $query_run = mysqli_query($connection,$query);
    ?>
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> Patente </th>
            <th> Name </th>
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
            <td><?php echo $row['patente_assu']; ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['tele_assu']; ?></td>

            <td>
                <form action="register_assu_edit .php" method="post">
                    <input type="hidden" name="edit_assu" value="<?php  echo $row['id_assu']; ?>">
                    <button  type="submit" name="edit_assu_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_assu" value="<?php echo $row['id_assu']; ?>">
                  <button type="submit" name="delete_btn_assu" class="btn btn-danger"> DELETE</button>
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