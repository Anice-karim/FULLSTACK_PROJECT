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
            <th>Delete</th>
            <th>Add Facture</th>
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
            <td>
              <form action="code.php" method="POST">
                <input type="hidden" name="delete_id_as" value="<?= $row['id']; ?>">
                <button type="submit" name="delete_btn_as" class="btn btn-danger">Delete</button>
              </form>
            </td>
            <td>
              <!-- This is the button -->
              <button 
              type="button"
              class="btn btn-primary" 
              data-toggle="modal" 
              data-target="#AddFacteur">
              Add Facteur
              </button>
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
    <div
      class="modal fade"
      id="AddFacteur"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Facture</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-resposive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Service</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input class="form-control" type="text" name="item[]"></td>
      <td><input class="form-control price-input" type="number" name="price[]" placeholder="Enter price" oninput="updateTotal()"></td>
      
    </tr>
  </tbody>
  <tfoot>
        <tr>
          <th>Total</th>
          <th><span id="finalTotal">0</span> MAD</th>
        </tr>
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
            <button type="button" class="btn btn-primary">Save changes</button>
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