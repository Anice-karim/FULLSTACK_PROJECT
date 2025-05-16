<?php
include('../security.php'); 
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>


<div class="container-fluid">
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"> Job Offers</h6>
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
                  etab.name ,
                  etab.type_etab,
                  etab.email,
                  inv.status,
                  inv.id
              FROM 
                  invitations inv
              JOIN 
                  etablissement etab ON inv.id_etab = etab.id
              WHERE 
                  inv.status = 'pending';
              ";
       $query_run = mysqli_query($connection,$query);
    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Medical Facilities</th>
            <th>Type</th>
            <th>Email </th>
            <th>Accept</th>
            <th>Reject</th>
          </tr>
        </thead>
        <tbody>
     <?php 
       if(mysqli_num_rows($query_run)>0){
         while($row = mysqli_fetch_assoc($query_run))
          {
          ?>
          
          <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['type_etab'] ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <form action="code.php" method="post">
                  <input type="hidden" name="accept_invi_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="accept_invi_btn" class="btn btn-success"> ACCEPT</button>
                </form>
            </td>
            
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="decline_invi_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="decline_invi_btn" class="btn btn-danger"> DECLINE</button>
                </form>
            </td>
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
 
<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>