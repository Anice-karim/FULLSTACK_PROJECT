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

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <!-- Content Row -->
  <div class="row">

  <!-- Dossier Card -->
  <div class="col-md-4 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dossier</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
              $query = "SELECT COUNT(*) AS total FROM dossier_hp WHERE id_hp = '" . $_SESSION['user_id'] . "'";
              $query_run = mysqli_query($connection, $query);
              $data = mysqli_fetch_assoc($query_run);
              echo '<h1>' . $data['total'] . '</h1>';
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-md fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Ordonnance Card -->
  <div class="col-md-4 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ordonnance</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
              $query = "SELECT COUNT(*) AS total FROM ordonnance WHERE id_hp = '" . $_SESSION['user_id'] . "'";
              $query_run = mysqli_query($connection, $query);
              $data = mysqli_fetch_assoc($query_run);
              echo '<h1>' . $data['total'] . '</h1>';
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-hospital fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Acts Medicals Card -->
  <div class="col-md-4 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Acts Medicals</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
              $query = "SELECT COUNT(*) AS total FROM Acte WHERE id_hp = '" . $_SESSION['user_id'] . "'";
              $query_run = mysqli_query($connection, $query);
              $data = mysqli_fetch_assoc($query_run);
              echo '<h1>' . $data['total'] . '</h1>';
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


  <!-- Content Row -->







  <?php
include('../includes/scripts.php');

?>
</div>
      <!-- End of Main Content -->
       
    </div>
    <!-- End of Content Wrapper -->
   
    
</body>

</html>