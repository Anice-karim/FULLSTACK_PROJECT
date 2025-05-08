<?php
include('../security.php'); 
include('../includes/header.php');
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
        


            <div class="form-group">
                <label> First Name </label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
                <label for="uniqueIdInput">N° Immatriculation</label>
                <!-- Input for immatriculation -->
                <input type="text" name="N_immatriculation_assure" id="uniqueIdInput" class="form-control" placeholder="Generated ID will appear here" readonly>
                <!-- Button to generate ID -->
                <button type="button" class="btn btn-primary" id="generateIdButton">Generate ID</button>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
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
                  <!-- options will be added dynamically -->
                </select>
              </div>
            <div class="form-group">
                <label>Salaire</label>
                <input type="text" name="salaire" class="form-control" placeholder="Enter salaire" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
            </select>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>

        </div>
        
      </form>

    </div>
  </div>
</div>
 <!-- add a family member form -->
<div class="modal fade" id="addfamily" tabindex="-1" role="dialog" aria-labelledby="ADD family" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addfamily">Add Family</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
            
        

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
                  <input type="checkbox" name="chronic" value="true" class="form-check-input" id="chronicCheck">
                  <label class="form-check-label"  for="chronicCheck">Do you have a chronic disease?</label>
              </div>

              <!-- Select input shown only if checkbox is checked -->
              <div class="form-group" id="chronicSelectGroup" style="display: none;">
                  <label for="chronicSelect">Select Chronic Disease</label>
                  <select name="chronic2" id="chronicSelect" class="form-control">
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
                      <input class="form-check-input" type="radio" name="relation" id="relationSpouse" value="Spouse">
                      <label class="form-check-label" for="relationSpouse">Spouse</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="relation" id="relationChild" value="Child">
                      <label class="form-check-label" for="relationChild">Child</label>
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
      $query ="SELECT * FROM assure";
      $query_run = mysqli_query($connection,$query);
    ?>
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
            <th>Benificiary</th>
          </tr>
        </thead>
        <tbody>
     <?php 
      if(mysqli_num_rows($query_run)>0){
        while($row = mysqli_fetch_assoc($query_run))
        {
          ?>
          
          <tr>
            <td><?php echo $row['nom_as']; ?></td>
            <td><?php echo $row['prenom_as'] ?></td>
            <td><?php echo $row['CIN_as']; ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['N_immatriculation_assure']; ?></td>
      
            <td>
                <form action="assure_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['id_as']; ?>">
                    <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="assure_edit.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['id_as']; ?>">
                  <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
            <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addfamily" id="addAdminButton" value="<?php echo $row['id_as']; ?>">
                  Add Family member
              </button>

              <!-- Modal -->
              
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
<script>
      document.addEventListener('DOMContentLoaded', function () {
    // Handling the "Add Admin Profile" button click event
    const addAdminButton = document.getElementById('addAdminButton');
    const uniqueIdInput = document.getElementById('uniqueIdInput');
    const addButton = document.getElementById('generateIdButton');
    const chronicCheck = document.getElementById('chronicCheck');
    const cinInput = document.getElementById('cin');
    const birthInput = document.getElementById('birth');
    const chronicSelectGroup = document.getElementById('chronicSelectGroup');

    // Ensure all elements exist before adding event listeners
    if (addAdminButton) {
        addAdminButton.addEventListener('click', function () {
            const adminId = this.value;
            document.getElementById('admin_id').value = adminId;
        });
    }

    if (chronicCheck) {
        chronicCheck.addEventListener('change', function () {
            chronicSelectGroup.style.display = this.checked ? 'block' : 'none';
        });
    }

    if (birthInput) {
        birthInput.addEventListener('change', function () {
            const birthDate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age >= 18) {
                cinInput.setAttribute('required', 'required');
            } else {
                cinInput.removeAttribute('required');
            }
        });
    }

    if (addButton && uniqueIdInput) {
        addButton.addEventListener('click', function () {
            console.log("Button clicked!");
            generateUniqueId();
        });
    } else {
        console.log("Button or input field for unique ID not found.");
    }

    // Function to generate a unique ID
    function generateUniqueId() {
        // Create a unique ID using timestamp and a random number
        const uniqueNum = Date.now().toString() + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        uniqueIdInput.value = uniqueNum;
        console.log("Generated immatr: " + uniqueNum); // Log the generated ID for debugging
    }
});

</script>
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>