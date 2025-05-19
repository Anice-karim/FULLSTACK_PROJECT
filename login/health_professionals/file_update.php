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
      id="add_dossier" 
      tabindex="-1" 
      role="dialog" 
      aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addclient">update dossier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <input type="hidden" name="id_hp" value="<?php echo $user['id'] ;?>">

        <div class="modal-body">
        
            <div class="form-group">
                <label>ID</label>
                <input type="text" name="id_dossier" class="form-control" id="id" placeholder="Enter folder id" required>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addbtn" class="btn btn-primary">Save</button>

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
    <h6 class="m-0 font-weight-bold text-primary">dossier folders
            <button 
            type="button" 
            class="btn btn-primary" 
            data-toggle="modal" 
            data-target="#add_dossier" 
            >
              Add dossier 
            </button>
    </h6>
  </div>

  <div class="card-body">

    <?php 
    if (isset($_SESSION['success']) && $_SESSION['success'] != ''){
      echo '<h2>'.$_SESSION['success'].'</h2>';
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['status']) && $_SESSION['status'] != ''){
      echo '<h2>'.$_SESSION['status'].'</h2>';
      unset($_SESSION['status']);
    }
    ?>
    <div class="table-responsive">
      <?php 
   $query = "
          SELECT 
              doc.id,
              bn.id AS id_ben,
              bn.f_name,
              bn.l_name 
          FROM 
              dossier doc
          JOIN 
              dossier_hp dhp ON doc.id = dhp.id_doss
          JOIN 
              beneficiaire bn ON doc.id_benef = bn.id  
          WHERE 
              dhp.id_hp = " . $user['id'] ;
   $query_run = mysqli_query($connection, $query);
   
?>
      <table class="table table-bordered">
        <thead>
          <tr>

            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            
            <?php if($user['type'] == 'doctor') { ?>
              <th>Add ordonnance</th>
              <th>Actes medecins</th>
             
            <?php } ?>

            <?php if($user['type'] == 'pharmacy') { ?>
              <th>Edits et Achats des medicaments</th>
            <?php } ?>

            <th>Delete</th>
           
          </tr>
        </thead>
        <tbody>
          <?php 
      if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
      ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['f_name']; ?></td>
            <td><?= $row['l_name']; ?></td>
            
            <?php if($user['type'] == 'doctor') { ?>
        <td>
          <input type="hidden" name="ord1" value="<?= $row['id']; ?>">
          <button type="submit"
              name="addordonnance"
              class="btn" 
              style="background-color: #bbdefb; color: white;" 
              data-toggle="modal" 
              data-target="#Addordonnance"
              data-id="<?= $row['id']; ?>">Add ordonnance</button>
          
        </td>
        <td>
          <button type="submit" 
          class="btn" 
          style="background-color:rgb(79, 127, 166); color: white;" 
          data-toggle="modal" 
          data-target="#Acts"
          data-id="<?= $row['id']; ?>">Add acts effectues</button>
        </td>
        
      <?php } ?>


      <?php if($user['type'] == 'pharmacy') { ?>
        <td>
          <form action="medicament.php" method="POST">
          <input type="hidden" name ='med_inf' value="<?= $row['id']; ?>">
          <button type="submit"
          name="med_btn" 
          class="btn" 
          style="background-color: #2196f3; color: white;" 
          >Add achats medicaments</button>
          </form>
        </td>
      <?php } ?>

      
      <td>
              <form action="code.php" method="POST">
                <input type="hidden" name="delete_hp"  value="<?= $user['id']; ?>">
                <input type="hidden" name="delete_doss"  value="<?= $row['id']; ?>">
                <button type="submit" name="deletebtn_doss" class="btn btn-danger">Delete</button>
              </form>
            </td>
    </tr>
    <?php
      }
    } else {
      echo "<tr><td colspan='5'>No Records Found</td></tr>";
    }
    ?>
  </tbody>
</table>
    </div>

    <!-- This is the modal for add ordonnance -->
  <div class="modal fade" id="Addordonnance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!--  Start form before modal-body -->
      <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ordonnance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="table-responsive">
            <input type="hidden" name="addordonnace" value="1">
             <input type="hidden" id="ord1_input" name="ord1" value="">
            <input type="hidden" name="id_hp" value="<?php echo $user['id']; ?>">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Medicaments</th>
                  <th>Dose</th>
                  <th>Unité</th>
                  <th>Recommandation</th>
                </tr>
              </thead>
              <tbody>
                <!-- JavaScript will add rows here -->
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save_ordonnance" class="btn btn-primary">Save Ordonnance</button>
        </div>
      </form>
      <!-- ✅ End of form -->

    </div>
  </div>
</div>


    <!--modal acte medecin dentiste-->
    <div class="modal fade" id="Acts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Acte Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action ="code.php" method = POST >
          <input type="hidden" id="acts_input" name="ord1" value="">
          <input type="hidden" name="id_hp" value="<?php echo $user['id']; ?>">
        <div class="form-group">
        <label> CODE DES ACTES </label>
        <input type="text" name="act" class="form-control" placeholder="Enter ACTES" id="name"required>
        </div>

        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addacte" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>


                </div>
                </div>
                </div>
                </div>

<!-- /.container-fluid -->
<script src="js/script.js" ></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>