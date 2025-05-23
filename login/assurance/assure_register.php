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


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="Add clent" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addclient">Add CLIENT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">
        

            <input type="hidden" name="assu_id" value="<?php echo $user['id']; ?>">
            <div class="form-group">
                <label> First Name </label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" id="name" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
              <label for="uniqueIdInput">N° Immatriculation</label>
              <div class="input-group">
                  <input type="text" name="N_immatriculation_assure" id="uniqueIdInput" class="form-control" placeholder="Generated ID will appear here" readonly>
                  <div class="input-group-append">
                      <button type="button" class="btn btn-secondary" id="generateIdButton">Auto</button>
                  </div>
              </div>
          </div>
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"  required>
                </div>
            </div>
            <div class="form-group">
                <label>CIN</label>
                <input type="text" name="CIN_as" class="form-control" placeholder="Enter CIN" required>
            </div>
            <div class="form-group">
                <label>RIB</label>
                <input type="text" name="RIB_as" class="form-control" placeholder="Enter RIB" required>
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <select class="form-control" name="designation" id="designation" required>
                  <option value="" disabled selected>Select type</option>
                  <option value="employed">employed</option>
                  <option value="retired">retired</option>
                  
                </select>
              </div>
            <div class="form-group">
                <label>Salaire</label>
                <input type="text" name="salaire" class="form-control" placeholder="Enter salaire" required>
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


<!-- end of add a family member form -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Client Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" id="add">
              Add Client Profile 
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
      $user_id = (int)$_SESSION['user_id']; 
      $query ="SELECT * FROM assure WHERE id_assurance = $user_id";
      $query_run = mysqli_query($connection,$query);
    ?>
<!-- Modified client table with added print button -->
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Name</th>
      <th>Last name</th>
      <th>CIN</th>
      <th>Email </th>
      <th>NR D'IMMATRICULATION</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>Beneficiaries</th>
    </tr>
  </thead>
  <tbody>
 <?php 
  if(mysqli_num_rows($query_run)>0){
    while($row = mysqli_fetch_assoc($query_run))
    {
      ?>
      
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['prenom_as'] ?></td>
        <td><?php echo $row['CIN_as']; ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $row['N_immatriculation_assure']; ?></td>
  
        <td>
            <form action="assure_edit.php" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
            </form>
        </td>
        <td>
            <form action="code.php" method="post">
              <input type="hidden" name="delete_id_as" value="<?php echo $row['id']; ?>">
              <button type="submit" name="delete_btn_as" class="btn btn-danger"> DELETE</button>
            </form>
        </td>
        <td>
          <!-- Add Family Member Button -->
          <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addfamily<?php echo $row['id']; ?>">
            Add Family member
          </button>
          
          <!-- New Print Beneficiaries Button -->
          <a href="print_beneficiary_list.php?client_id=<?php echo $row['id']; ?>" class="btn btn-info mb-2">
            <i class="fas fa-print"></i> Print Beneficiaries
          </a>
        </td>
        
          <div class="modal fade" id="addfamily<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ADD family" >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Family</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="code.php" method="POST">
                  <div class="modal-body">
                      
                  
                    <input type="hidden" id="admin_id_modal" name="admin_id" readonly class="form-control" value="<?php echo $row['id']; ?>">

                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="name1" class="form-control" placeholder="Enter Name" required>
                      </div>

                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="name2" class="form-control" placeholder="Enter Name" required>
                      </div>

                      <div class="form-group">
                          <label>CIN</label>
                          <input type="text" name="cin2" class="form-control" placeholder="Enter Name" >
                      </div>
              
                        <div class="form-group">
                          <label>Birth</label>
                          <input type="date" name="date"  class="form-control" placeholder="name@health.ma" required>
                      </div>
                      <div class="form-group form-check">
                            <input type="hidden" name="chronic" value="false" >
                            <input type="checkbox" name="chronic" value="true" class="form-check-input" id="chronicCheck<?php echo $row['id']; ?>">
                            <label class="form-check-label" for="chronicCheck<?php echo $row['id']; ?>">Do you have a chronic disease?</label>
                        </div>

                        <!-- Select input shown only if checkbox is checked -->
                        <div class="form-group chronicSelectGroup" id="chronicSelectGroup<?php echo $row['id']; ?>" style="display: none;">
                            <label for="chronicSelect<?php echo $row['id']; ?>">Select Chronic Disease</label>
                            <select name="chronic2" id="chronicSelect<?php echo $row['id']; ?>" class="form-control">
                                <option value="">-- Choose one --</option>
                                <option value="Diabetes">Diabetes</option>
                                <option value="Hypertension">Hypertension</option>
                                <option value="Asthma">Asthma</option>
                                <option value="Cardiopathy">Cardiopathy</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Relationship to Primary Insured:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relation" id="relationSpouse<?php echo $row['id']; ?>" value="Spouse">
                                <label class="form-check-label" for="relationSpouse<?php echo $row['id']; ?>">Spouse</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relation" id="relationChild<?php echo $row['id']; ?>" value="Child">
                                <label class="form-check-label" for="relationChild<?php echo $row['id']; ?>">Child</label>
                            </div>
                        </div>
                        
              
                      
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" name="registerbtn_beni" class="btn btn-primary">Save</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          
        

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
<script src="script.js" ></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>