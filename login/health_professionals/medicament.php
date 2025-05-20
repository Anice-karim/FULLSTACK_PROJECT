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
  <div class="card-body">
    
    <?php 
    if (isset($_POST['med_btn'])) {
      $id = $_POST['med_inf'];

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
                  ordonnance_details od ON od.ordonnance_id = o.id
                WHERE 
                  d.id = '$id'";

      $query_run = mysqli_query($connection, $query);
    ?>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Client Prescription Details</h6>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <?php if (mysqli_num_rows($query_run) > 0): ?>
            <form action="code.php" method="POST">
                

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Medicament</th>
                    <th>Dose</th>
                    <th>Unite</th>
                    <th>Prix</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
                    
                    <tr>
                      <td><?= htmlspecialchars($row['medicament']) ?></td>
                      <td><?= htmlspecialchars($row['dose']) ?></td>
                      <td><?= htmlspecialchars($row['unite']) ?></td>
                      <td>
                        <input type="number" name="prix[]" class="form-control price-input" placeholder="Enter price" oninput="updateTotal()">
                        <input type="hidden" name="ordonnance[]" value="<?= htmlspecialchars($row['ordonnance_id']) ?>">
                        <input type="hidden" name="medicament[]" value="<?= htmlspecialchars($row['medicament']) ?>">
                        <input type="hidden" name="hp[]" value="<?= htmlspecialchars($user['id']) ?>">
                    </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                      <th>Total</th>
                      <th><span id="finalTotal">0</span> MAD</th>
                    </tr>
              </table>

              <div class="modal-footer">
                <input type="hidden" name="dossier_id" value="<?= $id ?>">
                <a href="file_update.php" class="btn btn-danger">CANCEL</a>
                <button type="submit" name="addachat" class="btn btn-primary">Save</button>
              </div>
            </form>
          <?php else: ?>
            <p>No records found for this client.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php } ?>
  </div>
</div>
<script src="js/script.js" ></script>
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
