<?php
include('../security.php'); 
include('../includes/header.php');
include('../includes/navbar.php'); 
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add CLIENT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> name </label>
                <input type="text" name="name" class="form-control" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label>last_name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter last name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label>CIN</label>
                <input type="text" name="CIN_as" class="form-control" placeholder="Enter CIN">
            </div>
            <div class="form-group">
                <label>RIB</label>
                <input type="text" name="RIB_as" class="form-control" placeholder="Enter RIB">
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <select class="form-control" name="designation" id="designation">
                  <option value="" disabled selected>Select type</option>
                  <option value="employed">employed</option>
                  <option value="retired">retired</option>
                  <!-- options will be added dynamically -->
                </select>
              </div>
            <div class="form-group">
                <label>Salaire</label>
                <input type="text" name="salaire" class="form-control" placeholder="Enter salaire">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
            </select>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Admin Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Admin Profile 
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
      $connection=mysqli_connect("localhost","root","","health_assurance");

      $query ="SELECT * FROM assure";
      $query_run = mysqli_query($connection,$query);
    ?>
      <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last name</th>
            <th>name</th>
            <th>Email </th>
            <th>CIN</th>
            <th>RIB</th>
            <th>NR D'IMMATRICULATION</th>
     
          </tr>
        </thead>
        <tbody>
     <?php 
      //if(mysqli_num_rows($query_run)>0){
       // while($row = mysqli_fetch_assoc($query_run))
       // {
          ?>
          
          <tr>
            <td><?php //echo $row['id_as']; ?></td>
            <td><?php //echo $row['nom_as'] ?></td>
            <td><?php //echo $row['prenom_as'] ?></td>
            <td><?php //echo $row['email']; ?></td>
            <td><?php //echo $row['CIN_as']; ?></td>
            <td><?php //echo $row['RIB_as']; ?></td>
            <td><?php //echo $row['N_immatriculation_assure']; ?></td>
      
            <td>
                <form action="assure_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php //echo $row['id']; ?>">
                    <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="assure_edit.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php //echo $row['id']; ?>">
                  <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
          </tr> -->
          <?php
        //}
      //}
      //else {
        //echo "No Record Found";
      //}
      ?>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>