
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
    <h6 class="m-0 font-weight-bold text-primary">Edit Client  family Profile  </h6>
  </div>
<div class="modal-body">
    <div class="table-responsive"> 
         <?php 
      $query ="SELECT 
    a.id AS assure_id,
    a.name AS assure_name, 
    ass.id AS assurance_id,
    ass.name AS assurance_name,
    ass.email AS assurance_email, 
    b.cin_ben AS cin_ben,
    b.id AS benef_id,
    b.l_name AS benef_l_name,
    b.f_name AS benef_f_name,
    d.id AS dossier_id,
    d.date AS dossier_date,
    d.status AS d_status

FROM 
    assure a
JOIN 
    assurance ass ON ass.id = a.id_assurance
JOIN 
    beneficiaire b ON b.id_as = a.id
JOIN 
    dossier d ON d.id_benef = b.id
WHERE 
    ass.email = '$email'";
      $query_run = mysqli_query($connection,$query);
    ?>    
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <th>Name</th>
            <th>Last Name</th>
            <th>CIN</th>
            <th>id dossier</th>
            <th>date de creation</th>
            <th>status</th>
            <th>ACCEPTER</th>
            <th>REFUSER</th>
        </thead>
        <tbody>
             <?php 
       if(mysqli_num_rows($query_run)>0){
         while($row = mysqli_fetch_assoc($query_run))
         {
          ?>
          <tr>
            <td><?php echo $row['benef_f_name'] ?></td>
            <td><?php echo $row['benef_l_name']; ?></td>
            <td><?php echo $row['cin_ben']; ?></td>
            <td><?php echo $row['dossier_id']; ?></td>
            <td><?php echo $row['dossier_date'] ?></td>
             <td>
            <?php 
                $status = $row['d_status'];
                $badgeClass = '';

                if ($status == 'pending') {
                    $badgeClass = 'badge badge-warning';
                } elseif ($status == 'reimbursed') {
                    $badgeClass = 'badge badge-success';
                } elseif ($status == 'refused') {
                    $badgeClass = 'badge badge-danger';
                } else {
                    $badgeClass = 'badge badge-secondary'; // default/fallback
                }

                echo "<span class='$badgeClass'>" . ucfirst($status) . "</span>";
              ?>
            </td>
            
            <td>
                <form action="code.php" method="POST" >
                <input type="hidden" name="accept_id" value="<?php echo $row['dossier_id']; ?>">
                <button  type="submit" name="accept_btn" class="btn btn-success"  data-toggle="modal" data-target="#editfamily"> ACCEPTER</button>
                </form>
            </td>
            <td>
                 <form action="code.php" method="post">
                  <input type="hidden" name="refuse_id_as" value="<?php echo $row['dossier_id']; ?>">
                  <button type="submit" name="refuse_btn_as" class="btn btn-danger"> REFUSER</button>
                </form>
            </td>
            
               
             <?php
         }
      }
       else {
         echo "No Record Found";
   }
      ?>
        </tbody>
      </table>
      <?php //}?>
      <?php //}?>
      </div> 






<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>