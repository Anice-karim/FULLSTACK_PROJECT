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
    <h6 class="m-0 font-weight-bold text-primary">Edit Client family Profile</h6>
  </div>
  <div class="modal-body">
    <div class="table-responsive"> 
        <?php 
        // Requête SQL pour récupérer les dossiers
        $query = "SELECT 
            b.cin_ben AS cin_ben,
            b.id AS benef_id,
            b.l_name AS benef_l_name,
            b.f_name AS benef_f_name,
            d.id AS dossier_id,
            d.date AS dossier_date,
            d.status AS d_status,
            b.relation AS benef_relat
        FROM 
            beneficiaire b
        JOIN 
            assure a ON a.id = b.id_as
        JOIN 
           dossier d ON d.id_benef = b.id
        WHERE 
            a.email = '$email'";
            
        $query_run = mysqli_query($connection, $query);
        
        // Vérification des erreurs SQL
        if (!$query_run) {
            echo "Erreur MySQL : " . mysqli_error($connection);
            exit();
        }
        ?>    
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>CIN</th>
                    <th>id dossier</th>
                    <th>relation</th>
                    <th>date de creation</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                        <tr>
                            <td><?php echo $row['benef_f_name']; ?></td>
                            <td><?php echo $row['benef_l_name']; ?></td>
                            <td><?php echo $row['cin_ben']; ?></td>
                            <td><?php echo $row['dossier_id']; ?></td>
                            <td><?php echo $row['benef_relat']; ?></td>
                            <td><?php echo $row['dossier_date']; ?></td>
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
                        </tr>
                        <?php
                    }
                } else {
                    // Message si aucun dossier n'est trouvé
                    echo "<tr><td colspan='6' class='text-center'>Aucun dossier trouvé pour cet utilisateur</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div> 
  </div>
</div>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
