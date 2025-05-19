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

<!--Create A Dossier-->
<!--Modal Start-->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="Add clent" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addclient">Add dossier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <input type="hidden" name="id_etab" value="<?php echo $user['id'] ;?>">
        <!--modal body-->
        <div class="modal-body">
          <!--Benifi ID-->        
            <div class="form-group">
                <label>ID</label>
                <input type="text" name="id_client" class="form-control" id="id" placeholder="Enter id" required>
            </div>
        </div>
        <!--modal footer-->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addbtn" class="btn btn-primary">Save</button>
        </div>       
      </form>
    </div>
  </div>
</div>
<!-- end of creat a dossier -->
<div class="container-fluid">

<!-- Button of modal -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">dossier folders
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" id="add">
              Add dossier 
            </button>
    </h6>
  </div>
<!--Dossier added-->
  <div class="card-body">

    <?php 
    // Affiche un message de succès si une action s'est bien passée (ex: ajout ou suppression)
    if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
        echo '<h2>' . $_SESSION['success'] . '</h2>';
        unset($_SESSION['success']); // Nettoie la session après affichage
    }

    // Affiche un message d'erreur ou d'échec
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        echo '<h2>' . $_SESSION['status'] . '</h2>';
        unset($_SESSION['status']);
    }
    ?>

    <div class="table-responsive">
      <?php 
      // Requête SQL pour récupérer tous les dossiers et les informations de leurs bénéficiaires associés
      $query = "SELECT 
                  doc.id,
                  bn.id AS id_ben,
                  bn.f_name,
                  bn.l_name 
                FROM 
                  dossier doc
                JOIN 
                  beneficiaire bn ON doc.id_benef = bn.id;";
      $query_run = mysqli_query($connection, $query);
      ?>
      
      <!-- Tableau affichant les dossiers -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ID beneficiaire</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Delete</th>
            
          </tr>
        </thead>
        <tbody>
          <?php 
          // Vérifie s'il y a des résultats à afficher
          if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_assoc($query_run)) {
          ?>
          <tr>
            <!-- Affiche les données du dossier et du bénéficiaire -->
            <td><?= $row['id']; ?></td>
            <td><?= $row['id_ben']; ?></td>
            <td><?= $row['f_name']; ?></td>
            <td><?= $row['l_name']; ?></td>

            <!-- Formulaire pour supprimer un dossier -->
            <td>
              <form action="code.php" method="POST">
                <!-- Champ caché contenant l'ID du dossier à supprimer -->
                <input type="hidden" name="delete_id_as" value="<?= $row['id']; ?>">
                <button type="submit" name="delete_btn_as" class="btn btn-danger">Delete</button>
              </form>
            </td>

            <!-- Bouton pour ajouter une facture au dossier -->
            
          </tr>
          <?php  
              } // fin du while
          ?>
        </tbody>
      </table>
    </div> <!-- Fin de table-responsive -->
    <?php 
      } else {
        // S'il n'y a pas de dossier trouvé
        echo "<tr><td colspan='6'>No Records Found</td></tr>";
      }
    ?>
</div> <!-- Fin de card-body -->



    
    </div>
      </div>
    </div>
    
      
<!-- /.container-fluid -->
<script src="js/script.js" ></script>


<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>