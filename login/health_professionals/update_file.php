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
              dhp.id_hp = " . $user['id'];

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

                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
              <?php 
      if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
          echo $row['id'].'hello';
      ?>
      
      <tr>
              <td>hello</td>
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
            </tbody>
        </tr>
        <?php
        }
      }
      else {
        echo "No Record Found";
      }
      ?>
        </table>
    </div>
</div>
</div>












<script src="js/script.js"></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>