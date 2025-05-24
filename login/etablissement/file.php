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

<!-- Modal to add dossier -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="Add client" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addclient">Add dossier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <input type="hidden" name="id_etab" value="<?= $user['id'] ;?>">
        <div class="modal-body">
          <div class="form-group">
            <label>ID</label>
            <input type="text" name="id_client" class="form-control" placeholder="Enter id" required>
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

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Dossier folders</h6>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" id="add">
        Add dossier 
      </button>
    </div>
    <div class="card-body">
      <?php 
      if (!empty($_SESSION['success'])) {
          echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success']).'</div>';
          unset($_SESSION['success']);
      }
      if (!empty($_SESSION['status'])) {
          echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['status']).'</div>';
          unset($_SESSION['status']);
      }
      ?>

      <div class="table-responsive">
        <?php 
        $query = "SELECT 
                    doc.id,
                    bn.id AS id_ben,
                    bn.f_name,
                    bn.l_name
                  FROM 
                    dossier doc
                  JOIN 
                    beneficiaire bn ON doc.id_benef = bn.id;";
        $query_run = mysqli_query($connection, $query);
        ?>

        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th>ID</th>
              <th>ID beneficiaire</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Barcode</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($query_run) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']); ?></td>
                  <td><?= htmlspecialchars($row['id_ben']); ?></td>
                  <td><?= htmlspecialchars($row['f_name']); ?></td>
                  <td><?= htmlspecialchars($row['l_name']); ?></td>
                  <td>
                    <svg
                      class="barcode"
                      data-id="<?= htmlspecialchars($row['id']); ?>"
                      data-name="<?= htmlspecialchars($row['f_name'] . ' ' . $row['l_name']); ?>"
                      style="cursor:pointer;"
                      onclick="showDetails(this)">
                    </svg>
                  </td>
                  <td>
                    <form action="code.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this dossier?');">
                      <input type="hidden" name="delete_id_as" value="<?= htmlspecialchars($row['id']); ?>">
                      <button type="submit" name="delete_btn_as" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center">No Records Found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="print-area">
      <div class="modal-header">
        <h5 class="modal-title">Dossier Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between py-2 border-bottom">
          <strong>ID:</strong>
          <span id="info-id" class="text-primary"></span>
        </div>
        <div class="d-flex justify-content-between py-2 border-bottom">
          <strong>Name:</strong>
          <span id="info-name" class="font-italic"></span>
        </div>
        <div class="text-center mt-4">
          <strong>Barcode:</strong><br>
          <svg id="modal-barcode" style="margin:auto;"></svg>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="printModal()">Print</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
  // Generate barcodes for all in-table SVGs on page load
  document.querySelectorAll('.barcode').forEach(function(svg) {
    const id = svg.getAttribute('data-id');
    JsBarcode(svg, id, {
      format: "CODE128",
      displayValue: true,
      fontSize: 14,
      height: 40,
      lineColor: "#008000",
      margin: 0
    });
  });

  // Show modal with info and barcode when clicking barcode svg
  function showDetails(elem) {
    document.getElementById('info-id').textContent = elem.dataset.id;
    document.getElementById('info-name').textContent = elem.dataset.name;

    JsBarcode("#modal-barcode", elem.dataset.id, {
      format: "CODE128",
      displayValue: true,
      fontSize: 14,
      height: 40,
      lineColor: "#008000"
    });

    $('#infoModal').modal('show');
  }

  // Print modal content only
  function printModal() {
    const content = document.getElementById("print-area").innerHTML;
    const original = document.body.innerHTML;

    document.body.innerHTML = content;
    window.print();

    // Restore page after printing
    document.body.innerHTML = original;
    location.reload();
  }
</script>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
