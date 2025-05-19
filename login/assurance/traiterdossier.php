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
    if (isset($_POST['trai_btn'])) {
      $id = intval($_POST['trai_id']);

      $query = "SELECT DISTINCT
                    asr.N_immatriculation_assure,
                    asr.name,
                    asr.prenom_as AS prenom
                FROM assure asr
                JOIN beneficiaire b ON b.id_as = asr.id
                JOIN dossier d ON d.id_benef = b.id
                WHERE  d.id =".$id   ;

      $query_run = mysqli_query($connection, $query);
    ?>
<!-----------------info assure---------------------->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assure Info</h6>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <?php if (mysqli_num_rows($query_run) > 0): ?>
            <form action="code.php" method="POST">
                

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>N` immatriculation</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                     
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
                    
                    <tr>
                      <td><?= htmlspecialchars($row['N_immatriculation_assure']) ?></td>
                      <td><?= htmlspecialchars($row['name']) ?></td>
                      <td><?= htmlspecialchars($row['prenom']) ?></td>
                
                      
                    </tr>
                  <?php endwhile; ?>
                </tbody>
                
              </table>
            </form>
          <?php else: ?>
            <p>No records found for this client.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
<!---------------------------fin info --------------------------------->
 <?php 
      $query1 = "SELECT 
              b.f_name,       
              b.l_name,
              b.relation
          FROM beneficiaire b
          JOIN dossier d ON d.id_benef = b.id
          WHERE d.id = $id";

      $query_run1 = mysqli_query($connection, $query1);
    ?>
<!---------------------benif info -------------------------->
<div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Benif Info</h6>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <?php if (mysqli_num_rows($query_run1) > 0): ?>
            <form action="code.php" method="POST">
                

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Relation</th>
                     
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($query_run1)): ?>
                    
                    <tr>
                      <td><?= htmlspecialchars($row['f_name']) ?></td>
                      <td><?= htmlspecialchars($row['l_name']) ?></td>
                      <td><?= htmlspecialchars($row['relation']) ?></td>
                
                      
                    </tr>
                  <?php endwhile; ?>
                </tbody>
                
              </table>
            </form>
          <?php else: ?>
            <p>No records found for this client.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-------------------fin benif info ----------------->
  <?php 
      $query1 = "SELECT 
              etab.name,       
              etab.inpe_etab AS inpe,
              etab.type_etab AS type1,
              etab.tele_etab AS tele
          FROM etablissement etab
          JOIN dossier d ON d.id_etab = etab.id
          WHERE d.id = $id";

      $query_run1 = mysqli_query($connection, $query1);
    ?>
<!---------------------etab info------------------------>
<div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Etab Info</h6>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <?php if (mysqli_num_rows($query_run1) > 0): ?>
            <form action="code.php" method="POST">
                

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>INPE</th>
                    <th>Type</th>
                    <th>Phone</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($query_run1)): ?>
                    
                    <tr>
                      <td><?= htmlspecialchars($row['name']) ?></td>
                      <td><?= htmlspecialchars($row['inpe']) ?></td>
                      <td><?= htmlspecialchars($row['type1']) ?></td>
                      <td><?= htmlspecialchars($row['tele']) ?></td>
                
                      
                    </tr>
                  <?php endwhile; ?>
                </tbody>
                
              </table>
            </form>
          <?php else: ?>
            <p>No records found for this client.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!--------------------fin etab info ----------------------------->
<!----------------------fin-------------------->
    <?php } ?>
  </div>
</div>
<script src="js/script.js" ></script>
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
