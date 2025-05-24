<?php
include('../security.php');
include('../includes/header.php');

$email = $_SESSION['email'];
$table = $_SESSION['table'];

// Fetch user info
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
    <h6 class="m-0 font-weight-bold text-primary">Receipt</h6>
  </div>

  <div class="card-body">

    <?php 
    if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
      echo '<h2>' . $_SESSION['success'] . '</h2>';
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
      echo '<h2>' . $_SESSION['status'] . '</h2>';
      unset($_SESSION['status']);
    }
    ?>

    <div class="table-responsive">
      <?php 
      $query = "SELECT DISTINCT 
                   hp.name, 
                   hp.specialty,
                   d.id_doss
                FROM 
                   health_professionals hp
                JOIN 
                   employe e ON e.id_hp = hp.id
                JOIN 
                   dossier_hp d ON d.id_hp = hp.id
                WHERE 
                   e.id_etab = " . intval($user['id']);
      $query_run = mysqli_query($connection, $query);
      ?>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID Dossier</th>
            <th>Doctor Name</th>
            <th>Specialty</th>
            <th>Add Receipt</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(mysqli_num_rows($query_run) > 0){
            while($row = mysqli_fetch_assoc($query_run)){
          ?>
          <tr>
            <td><?= htmlspecialchars($row['id_doss']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['specialty']); ?></td>
            <td>
              <button type="button" 
                      class="btn btn-primary open-receipt-modal" 
                      data-toggle="modal" 
                      data-target="#Addreceipts"
                      data-doss="<?= $row['id_doss']; ?>">
                Add Receipt
              </button>
            </td>
          </tr>
          <?php
           }
          } else {
            echo "<tr><td colspan='4'>No Records Found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Addreceipts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="code.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Receipt</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <input type="hidden" name="dossier_id" id="dossier_id">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Actes</th>
                      <th>Prix</th>
                    </tr>
                  </thead>
                  <tbody id="actes-table-body">
                    <!-- Actes will be loaded here dynamically -->
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total</th>
                      <th><span id="finalTotal">0</span> MAD</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="receipt_btn" class="btn btn-primary">Save Receipt</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateTotal() {
  let total = 0;
  $('.price-input').each(function () {
    const val = parseFloat($(this).val());
    if (!isNaN(val)) total += val;
  });
  $('#finalTotal').text(total.toFixed(2));
}

$(document).on('click', '.open-receipt-modal', function () {
  const dossId = $(this).data('doss');
  $('#dossier_id').val(dossId);
  $('#actes-table-body').html('<tr><td colspan="2">Loading...</td></tr>');

  $.ajax({
    url: 'fetch_actes.php',
    method: 'POST',
    data: { id_doss: dossId },
    success: function (response) {
      $('#actes-table-body').html(response);
      updateTotal();
    }
  });
});

$(document).on('input', '.price-input', updateTotal);
</script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
