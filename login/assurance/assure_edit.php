<?php
include('../security.php'); 
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Client Profile  </h6>
  </div>

  <div class="card-body">

 <?php 

 if(isset($_POST['edit_btn'])){
    $id = $_POST['edit_id'];
    $query= "SELECT * FROM  assure WHERE id_as='$id' ";
    $query_run=mysqli_query($connection,$query);   
    foreach($query_run as $row){
        ?>
        
<div class="modal-body">
    <form action="code.php" method="post">

        <input type="hidden" name="edit_id" value="<?php echo $row['id_as']?>">

        

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>First Name</label>
                <input type="text" name="name_edit" class="form-control" value="<?php echo $row['prenom_as'] ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label>Last Name</label>
                <input type="text" name="nam2_edit" class="form-control" value="<?php echo $row['name'] ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>CIN</label>
                <input type="number" name="cin_edit" class="form-control" value="<?php echo $row['CIN_as'] ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label>RIB</label>
                <input type="text" name="rib_edit" class="form-control" value="<?php echo $row['RIB_as'] ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="designation" class="form-label">Designation</label>
            <select class="form-control" name="designation" id="designation" required>
                <option value="" disabled selected>Select type</option>
                <option value="employed">employed</option>
                <option value="retired">retired</option>  
                </select>
        </div>

        <div class="form-row">
        <div class="form-group col-md-6">
            <label>Salaire</label>
            <input type="text" name="salaire" class="form-control" placeholder="Enter salaire" required>
        </div>

        <div class="form-group col-md-6">
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
            <th>Relation</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
             <?php 
      if(mysqli_num_rows($query_run)>0){
        while($row = mysqli_fetch_assoc($query_run))
        {
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
            <td>
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
            </td>
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




<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>