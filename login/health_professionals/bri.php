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
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">ADD ACT BRI  </h6>
  </div>

  <div class="card-body">

 <?php 

 if(isset($_POST['btn_bri'])){
    $id = $_POST['input_bri'];
    $query= "SELECT * FROM  dossier WHERE id='$id' ";
    $query_run=mysqli_query($connection,$query);   
    foreach($query_run as $row){
        ?>
        
<div class="modal-body">
        <div class="table-responsive">
           <input type="hidden" id="anarad" name="anarad" value="">
            <input type="hidden" name="id_hp" value="<?php echo $user['id']; ?>">
            <?php $query = "SELECT 
                        ar.id AS ana_rad_id,
                        d.id AS dossier_id,
                        ard.anarad
                    FROM 
                        ana_rad ar
                    JOIN 
                        dossier d ON ar.id_doss = d.id
                    JOIN 
                        ana_rad_details ard ON ard.ana_rad_id = ar.id";

$query_run = mysqli_query($connection, $query);
        ?>
        
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Actes</th>
                <th>Description des actes</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($query_run)) { ?>
                <tr>
                  <td><?= htmlspecialchars($row['anarad']); ?></td>
                  <td>
                    <input type="text" name="descrip[]" class="form-control" placeholder="Description" required>
                    <input type="hidden" name="ana_rad_id[]" value="<?= $row['ana_rad_id']; ?>">
                    <input type="hidden" name="anarad[]" value="<?= htmlspecialchars($row['anarad']); ?>">
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
          </table>
          <?php } ?>
           <?php } ?>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save_bri" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>







<script src="js/script.js"></script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>