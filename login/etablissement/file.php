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
        <h5 class="modal-title" id="addclient">Add dossier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <input type="hidden" name="id_etab" value="<?php echo $user['id'] ;?>">

        <div class="modal-body">
        
            <div class="form-group">
                <label>ID</label>
                <input type="text" name="id_client" class="form-control" id="id" placeholder="Enter id" required>
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
 <!-- add a family member form -->

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
       $query ="SELECT 
                  doc.id ,
                  bn.id_ben ,
                  bn.f_name ,
                  bn.l_name 
              FROM 
                  dossier doc
              JOIN 
                  beneficiaire bn ON doc.id_benef = bn.id_ben;
              ";
       $query_run = mysqli_query($connection,$query);
    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Last name</th>
             <th>DELETE</th>
            <th>ADD FACTURE</th>


          </tr>
        </thead>
        <tbody>
     <?php 
      if(mysqli_num_rows($query_run)>0){
        while($row = mysqli_fetch_assoc($query_run))
        {
          ?>
          
          <tr>
            <td><?php echo $row['id_ben']; ?></td>
            <td><?php echo $row['f_name']; ?></td>
            <td><?php echo $row['l_name'] ?></td>
      
      
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_id_as" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_btn_as" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
           <td>
  <button type="button" name="add_fac" class="add_fac-btn btn btn-primary" data-toggle="modal" data-target="#addfacture1" id="addfactureBtn">Add Facture</button>
</td>

<div class="modal fade" id="addfacture1" tabindex="-1" role="dialog" aria-labelledby="addfactureLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="addfactureLabel">Add Facture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="code.php" method="POST">
        <div class="modal-body">
        <input type="hidden" id="admin_id_modal" name="admin_id" class="form-control" value="<?php echo $row['id_as']; ?>">

          <table>
            <thead>
              <tr>
                <th>SERVICES</th>
                <th>PRICE</th>
                <th>Total (MAD)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" name="SERV[]" /></td>
                <td><input type="text" name="PRICE[]" class="price-input" /></td>
                <td><span class="total">0</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="registerbtn_beni" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>
</tr>


          <?php
        }
      }
      else {
        echo "No Record Found";
      }
      ?>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->
<script src="script.js" ></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>