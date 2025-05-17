   <!-- Sidebar -->
    <?php
    $table = $_SESSION['table'] ?? '';
if (isset($table)) {
  switch ($table) {
      case 'register':
          $sidebar_class = 'bg-gradient-admin'; // Admin
          break;
      case 'etablissement':
          $sidebar_class = 'bg-gradient-etablissement'; // Medical Facilities
          break;
      case 'health_professionals':
          $sidebar_class = 'bg-gradient-health'; // Health Pros
          break;
      case 'assurance':
          $sidebar_class = 'bg-gradient-assurance'; // Insurance
          break;
      default:
          $sidebar_class = 'bg-gradient-dark';
          break;
  }
}
?>
     
   <ul class="navbar-nav <?php echo $sidebar_class; ?> sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon rotate-n-15">
  <i class="fas fa-shield-alt me-3"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Health Assurance</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->


<!-- ADMIN-ONLY LINKS -->
<?php if ($table === 'register'): ?>
    <li class="nav-item">
        <a class="nav-link" href="..\admin\register.php">
            <i class="fas fa-fw fas fa-user-shield"></i>
            <span>Admin</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="..\admin\register_Hp.php">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Health professionals</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="..\admin\register_etab.php">
            <i class="fas fa-fw fa-hospital"></i>
            <span>Medical facilities</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="..\admin\register_assu.php">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Insurance Company</span>
        </a>
    </li>
<?php endif; ?>

<!-- ETABLISSEMENT -->
<?php if ($table === 'etablissement'): ?>
    <li class="nav-item">
        <a class="nav-link" href="..\etablissement\invitation.php">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Join Invitation</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="..\etablissement\file.php">
            <i class="fas fa-fw fa-file"></i>
            <span>File</span>
        </a>
    </li>
<?php endif; ?>

<!-- HEALTH PROFESSIONALS -->
<?php if ($table === 'health_professionals'): ?>
    <li class="nav-item">
        <a class="nav-link" href="..\health_professionals\joboffer.php">
            <i class="fas fa-briefcase"></i>
            <span>Job Offers</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="..\health_professionals\file_update.php">
            <i class="fas fa-file"></i>
            <span>File</span>
        </a>
    </li>
<?php endif; ?>

<!-- ASSURANCE -->
<?php if ($table === 'assurance'): ?>
    <li class="nav-item">
        <a class="nav-link" href="..\assurance\assure_register.php">
            <i class="fas fa-user"></i>
            <span>Client</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="..\assurance\assure_register.php">
            <i class="fas fa-user"></i>
            <span>File</span>
        </a>
    </li>
<?php endif; ?>



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          
          


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
             

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  
               <?php echo $_SESSION['username'];
               
               ?>
               
                  
                </span>
               <img class="img-profile rounded-circle" src="uploads/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" alt="Profile Picture">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="profile_edit.php">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="../logout.php" method="POST"> 
          
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>