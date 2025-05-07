<?php
include('../security.php'); 
include('../includes/header.php'); 
include('../includes/navbar.php'); 
?>


<!-- Send Invitation Modal -->
<div class="modal fade" id="sendInvitationModal" tabindex="-1" role="dialog" aria-labelledby="sendInvitationLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="sendInvitationLabel">Send Invitation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="code.php" method="POST">

        <div class="modal-body">

          <div class="form-group">
            <label>Invitee Medical facilities INPE</label>
            <input type="number" name="hp_inpe" class="form-control" placeholder="Enter Medical facilities INPE to Invite">
          </div>

          <!-- Optional: select role or send a note -->
          <div class="form-group">
            <label>Message (optional)</label>
            <textarea name="message" class="form-control" placeholder="Add a message (optional)..."></textarea>
          </div>

          <!-- If you already have the institution ID in session, no need for this -->
          <input type="hidden" name="etab_id" value="8"> <!-- Or set dynamically in PHP -->

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="send_invite_btn" class="btn btn-primary">Send Invitation</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="container-fluid">
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"> Invite Medical facilities 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendInvitationModal">
              Send Invitation 
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
                  hp.l_name_hp ,
                  hp.specialty,
                  hp.email,
                  inv.status,
                  inv.id
              FROM 
                  invitations inv
              JOIN 
                  health_professionals hp ON inv.id_Hp = hp.id_Hp;
              ";
       $query_run = mysqli_query($connection,$query);
    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Last Name</th>
            <th>Specialty</th>
            <th>Email </th>
            <th>Status</th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
     <?php 
       if(mysqli_num_rows($query_run)>0){
         while($row = mysqli_fetch_assoc($query_run))
          {
          ?>
          
          <tr>
            <td><?php echo $row['l_name_hp']; ?></td>
            <td><?php echo $row['specialty'] ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
            <?php 
                $status = $row['status'];
                $badgeClass = '';

                if ($status == 'pending') {
                    $badgeClass = 'badge badge-warning';
                } elseif ($status == 'accepted') {
                    $badgeClass = 'badge badge-success';
                } elseif ($status == 'rejected') {
                    $badgeClass = 'badge badge-danger';
                } else {
                    $badgeClass = 'badge badge-secondary'; // default/fallback
                }

                echo "<span class='$badgeClass'>" . ucfirst($status) . "</span>";
              ?>
            </td>
            
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_invi_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_invi_btn" class="btn btn-danger"> DELETE</button>
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