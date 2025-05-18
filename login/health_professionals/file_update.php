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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" id="add">
              Add dossier 
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
   $query = "SELECT 
                doc.id,
                bn.id AS id_ben,
                bn.f_name,
                bn.l_name 
            FROM 
                dossier doc
            JOIN 
                beneficiaire bn ON doc.id_benef = bn.id  WHERE id_hp = " . $user['id'] ;
   $query_run = mysqli_query($connection, $query);
?>
      <table class="table table-bordered">
        <thead>
          <tr>

            <th>ID</th>
            <th>ID beneficiaire</th>
            <th>First Name</th>
            <th>Last Name</th>
            
            <?php if($user['type'] == 'doctor') { ?>
              <th>Add ordonnance</th>
              <th>Actes medecins</th>
              <th>Add analyses/imageries</th>
            <?php } ?>

            <?php if($user['type'] == 'BRI') { ?>
              <th>Actes bri</th>
            <?php } ?>

            <?php if($user['type'] == 'pharmacy') { ?>
              <th>Achats des medicaments</th>
            <?php } ?>

            <?php if($user['type'] == 'paramedical') { ?>
              <th>Actes paramedicaux</th>
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
            <td><?= $row['id_ben']; ?></td>
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
          data-id="<?= $row['id']; ?>">Add acts</button>
        </td>
        <td>
          <button type="submit" 
          class="btn" 
          style="background-color: #0d47a1; color: white;" 
          data-toggle="modal" 
          data-target="#Addimag"
          data-id="<?= $row['id']; ?>">Add analyse/imagerie</button>
        </td>
      <?php } ?>

      <?php if($user['type'] == 'BRI') { ?>
        <td>
          <button type="submit" 
          class="btn" 
          style="background-color:rgb(125, 41, 210); color: white;" 
          data-toggle="modal" 
          data-target="#Addactsbri"
          data-id="<?= $row['id']; ?>">Add acts bri</button>
        </td>
      <?php } ?>

      <?php if($user['type'] == 'pharmacy') { ?>
        <td>
          <button type="submit" 
          class="btn" 
          style="background-color: #2196f3; color: white;" 
          data-toggle="modal" 
          data-target="#Addachats"
          data-id="<?= $row['id']; ?>">Add achats medicaments</button>
        </td>
      <?php } ?>

      <?php if($user['type'] == 'paramedical') { ?>
        <td>
          <button type="button" 
          class="btn" 
          style="background-color: #0d47a1; color: white;" 
          data-toggle="modal" 
          data-target="#Addpara"
          data-id="<?= $row['id']; ?>">Add acts paramed</button>
        </td>
      <?php } ?>
      <td>
              <form action="code.php" method="POST">
                <input type="hidden" name="delete_doss"  value="<?= $user['id']; ?>">
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

    <!-- This is the modal (outside the <tr>) -->
  <div class="modal fade" id="Addordonnance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- ✅ Start form before modal-body -->
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
          <!-- ✅ Submit button -->
          <button type="submit" name="save_ordonnance" class="btn btn-primary">Save Ordonnance</button>
        </div>
      </form>
      <!-- ✅ End of form -->

    </div>
  </div>
</div>

     <!-- ordonnance analyse et imagerie -->
    <div
      class="modal fade"
      id="Addimag"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ordonnance</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="code.php" method="post">
             <input type="text" id="imag_input" name="imag_input" value="">
            <input type="hidden" name="id_hp" value="<?php echo $user['id']; ?>">
            <div class="table-resposive">
               <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>analyse/radio</th>
                <th>Recommandation</th>
              </tr>
            </thead>
            <tbody>
    <!-- JavaScript will manage rows here -->
            </tbody>
          </table>

          </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" name="addana" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--modal medecin dentiste-->
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
          <input type="text" id="acts_input" name="ord1" value="">
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


 <!--modal BRI-->
    <div class="modal fade" id="Addactsbri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">actes BRI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action ="code.php" method = POST >
        <div class="form-group">
        <label> CODE DES ACTES </label>
        <input type="text" name="ACTES" class="form-control" placeholder="Enter ACTES" id="name"required>
        </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>

 <!-- Pharmacien -->
  <div class="modal fade" id="Addachats" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- ✅ Start form before modal-body -->
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
            
           <?php 
$query = "SELECT 
    o.id AS ordonnance_id,
    d.id AS dossier_id,
    od.medicament,
    od.unite,
    od.dose
FROM 
    ordonnance o
JOIN 
    dossier d ON o.id_doss = d.id
JOIN 
    ordonnance_details od ON od.ordonnance_id = o.id";

$query_run = mysqli_query($connection, $query);
?>

<table class="table table-bordered" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Medicaments</th>
      <th>Dose</th>
      <th>Unité</th>
      <th>Prix</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($query_run)) { ?>
      <tr>
        <td><?= htmlspecialchars($row['medicament']); ?></td>
        <td><?= htmlspecialchars($row['dose']); ?></td>
        <td><?= htmlspecialchars($row['unite']); ?></td>
        <td><input type="number" name="prix" class="form-control price-input" placeholder="Enter price" oninput="updateTotal()"></td>
      </tr>
  </tbody>
  <tfoot>
        <tr>
          <th>Total</th>
          <th><span id="finalTotal">0</span> MAD</th>
        </tr>
</table>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- ✅ Submit button -->
          <button type="submit" name="confirm_buy" class="btn btn-primary">Confirmer l'achat</button>
        </div>
      </form>
      
      <!-- ✅ End of form -->

    </div>
  </div>
</div>
<?php } ?>

<!-- /.container-fluid -->
<script src="js/script.js" ></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>