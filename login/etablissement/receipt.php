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
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Receipt
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
          SELECT DISTINCT 
        hp.name, 
        hp.specialty, 
        a.id,
        a.id_doss,
        a.prix,
        a.id_etab,
        a.code_acts
        FROM employe e
        JOIN 
            health_professionals hp ON e.id_hp = hp.id
        JOIN 
            dossier_hp c ON c.id_hp = hp.id
        JOIN 
            acte a ON a.id_hp = hp.id AND a.id_doss = c.id_doss
        WHERE 
            e.id_etab =" . $user['id'] ;
   $query_run = mysqli_query($connection, $query);
   
?>
    <table class="table table-bordered">
        <thead>
          <tr>

            <th>ID Dossier</th>
            <th>Doctor Name</th>
            <th>specialty</th>
            <th>Add Receipt</th>
        </tr>
        </thead>
        <tbody>
            <?php 
      if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
      ?>
      <tr>
        <td><?= $row['id_doss']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['specialty']; ?></td>
        
            <td>
          <button type="submit" 
          class="btn" 
          style="background-color: #2196f3; color: white;" 
          data-toggle="modal" 
          data-target="#Addreceipts"
          data-id="<?= $row['id']; ?>">Add receipt</button>
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
<!------------modal body----------------------->
 <div class="modal fade" id="Addreceipts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ordonnance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="table-responsive">
            
            <?php 
                $query ="SELECT  a.code_acts
                        FROM acte a
                        WHERE a.id_hp IN (
                            SELECT e.id_hp
                            FROM employe e
                            WHERE e.id_etab =".$user['id']." 
                        );";
               // $query_run = mysqli_query($connection, $query);
                    
                ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Actes</th>
                  <th>Prix</th>
                </tr>
              </thead>
              <tbody>
                <?php //while($row = mysqli_fetch_assoc($query_run)) { ?>
                  <tr>
                    <td><?= htmlspecialchars($row['code_acts']); ?></td>
            
                    <td><input type="number" name="prix" class="form-control price-input" placeholder="Enter price" oninput="updateTotal()"></td>
                  </tr>
                
              </tbody>
              <?php //} ?>
              <tfoot>
                    <tr>
                      <th>Total</th>
                      <th><span id="finalTotal">0</span> MAD</th>
                    </tr>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save_ordonnance" class="btn btn-primary">Save Ordonnance</button>
        </div>
      </form>
</div>
</div>
</div>
<!-----------------end modal------------------------->
</div>
<script src="js/script.js" ></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>