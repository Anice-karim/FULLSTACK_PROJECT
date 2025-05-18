<?php
include('../security.php');
include('../includes/header.php');


$email = $_SESSION['email'];
$table = $_SESSION['table'];

// Fetch current user data
$query = "SELECT 
    a.id_as AS assure_id,
    a.name AS assure_name, 
    ass.id_assu AS assurance_id,
    ass.name AS assurance_nom,
    ass.email , 
    b.id AS benef_id,
    b.l_name AS benef_nom,
    d.id AS dossier_id,
    d.date AS dossier_date

FROM 
    assure a
JOIN 
    assurance ass ON ass.id_assu = a.id_as
JOIN 
    beneficiaire b ON b.id_as = a.id_as
JOIN 
    dossier d ON d.id_benef = b.id
 WHERE ass.email = '$email';";
$query_run = mysqli_query($connection, $query);

if (!$query_run || mysqli_num_rows($query_run) == 0) {
    echo "User not found!";
    exit();
}
$user = mysqli_fetch_assoc($query_run);
include('../includes/navbar.php');
?>


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Client  family Profile  </h6>
  </div>
<div class="modal-body">
    <div class="table-responsive"> 
         <?php 
      $query ="SELECT * FROM beneficiaire WHERE id_as='$id'";
      $query_run = mysqli_query($connection,$query);
    ?>    
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <th>Name</th>
            <th>Last Name</th>
            <th>CIN</th>
            <th>id dossier</th>
            <th>date de creation</th>
            <th>status</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
             <?php 
    //   if(mysqli_num_rows($query_run)>0){
    //     while($row = mysqli_fetch_assoc($query_run))
    //     {
          ?>
          <tr>
            <td><?php echo $row['f_name']; ?></td>
            <td><?php echo $row['l_name'] ?></td>
            <td><?php echo $row['cin_ben']; ?></td>
            <td><?php echo $row['relation'] ?></td>
            
            <td>
                 <form action="code.php" method="post">
                  <input type="hidden" name="delete_id_as" value="<?php echo $row['id_as']; ?>">
                  <button type="submit" name="delete_btn_as" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
            <td>
                <input type="hidden" name="edit_id" value="<?php echo $row['id_ben']; ?>">
                <button  type="submit" name="edit_btn" class="btn btn-success"  data-toggle="modal" data-target="#editfamily"> EDIT</button>
            </td>
            
                <div class="modal fade" id="editfamily" tabindex="-1" role="dialog" aria-labelledby="ADD family" >
                 <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addfamily">Edit Family</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="code.php" method="POST">
                      <div class="modal-body">
                           
                        <input type="hidden"  name="id_adit" readonly class="form-control" value="<?php echo $row['id_ben']; ?>">

                          <div class="form-group">
                              <label>First Name</label>
                              <input type="text" name="name1_edit" class="form-control" placeholder="Enter Name" value="<?php echo $row['f_name']; ?>" required>
                          </div>

                          <div class="form-group">
                              <label>Last Name</label>
                              <input type="text" name="name2_edit" class="form-control" placeholder="Enter Name" value="<?php echo $row['l_name']; ?>" required>
                          </div>

                          <div class="form-group">
                              <label>CIN</label>
                              <input type="text" name="cin2_edit" class="form-control" placeholder="Enter Name" value="<?php echo $row['cin_ben']; ?>" >
                          </div>
                  
                            <div class="form-group">
                              <label>Birth</label>
                              <input type="date" name="date"  class="form-control" placeholder="name@health.ma" value="<?php echo $row['birth']; ?>" required>
                          </div>
                          <div class="form-group form-check">
                                <input type="hidden" name="chronic" value="false" >
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
            
             <?php
    //     }
    //   }
    //   else {
    //     echo "No Record Found";
    //   }
      ?>
        </tbody>
      </table>
      <?php //}?>
      <?php //}?>
      </div> 






<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>