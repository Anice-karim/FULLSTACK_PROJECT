<?php
include('../security.php');
include('../includes/header.php');

// Check if client ID is provided
if (!isset($_GET['client_id']) || empty($_GET['client_id'])) {
    $_SESSION['status'] = "No client specified";
    header('Location: assure_register.php');
    exit();
}

$client_id = mysqli_real_escape_string($connection, $_GET['client_id']);

// Get client details
$client_query = "SELECT * FROM assure WHERE id = ?";
$client_stmt = mysqli_prepare($connection, $client_query);

if (!$client_stmt) {
    $_SESSION['status'] = "Database error. Please try again.";
    header('Location: assure_register.php');
    exit();
}

mysqli_stmt_bind_param($client_stmt, "i", $client_id);
mysqli_stmt_execute($client_stmt);
$client_result = mysqli_stmt_get_result($client_stmt);

if (mysqli_num_rows($client_result) == 0) {
    $_SESSION['status'] = "Client not found";
    header('Location: assure_register.php');
    exit();
}

$client = mysqli_fetch_assoc($client_result);
mysqli_stmt_close($client_stmt);

// Get all beneficiaries for this client
$beneficiary_query = "SELECT * FROM beneficiaire WHERE id_as = ? ORDER BY f_name, l_name";
$beneficiary_stmt = mysqli_prepare($connection, $beneficiary_query);

if (!$beneficiary_stmt) {
    $_SESSION['status'] = "Database error. Please try again.";
    header('Location: assure_register.php');
    exit();
}

mysqli_stmt_bind_param($beneficiary_stmt, "i", $client_id);
mysqli_stmt_execute($beneficiary_stmt);
$beneficiary_result = mysqli_stmt_get_result($beneficiary_stmt);
mysqli_stmt_close($beneficiary_stmt);

include('../includes/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary List for <?php echo htmlspecialchars($client['name'] . ' ' . $client['prenom_as']); ?></title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                font-size: 12pt;
            }
            .container-fluid {
                width: 100%;
                margin: 0;
                padding: 0;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th, .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .barcode-image {
                max-width: 150px;
                height: auto;
            }
            .navbar-nav,.sticky-footer{
                display:none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Beneficiaries for <?php echo htmlspecialchars($client['name'] . ' ' . $client['prenom_as']); ?>
                </h6>
                <div class="no-print">
                    <button onclick="window.print();" class="btn btn-info">
                        <i class="fas fa-print"></i> Print This List
                    </button>
                    <a href="assure_register.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Clients
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="client-info mb-4">
                    <h4>Client Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($client['name'] . ' ' . $client['prenom_as']); ?></p>
                            <p><strong>CIN:</strong> <?php echo htmlspecialchars($client['CIN_as']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($client['email']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Registration Number:</strong> <?php echo htmlspecialchars($client['N_immatriculation_assure']); ?></p>
                            <p><strong>Designation:</strong> <?php echo htmlspecialchars($client['designation'] ?? 'N/A'); ?></p>
                            <p><strong>RIB:</strong> <?php echo htmlspecialchars($client['RIB_as']); ?></p>
                        </div>
                    </div>
                </div>

                <h4>Beneficiary List</h4>
                <?php if (mysqli_num_rows($beneficiary_result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>CIN</th>
                                    <th>Birth Date</th>
                                    <th>Relationship</th>
                                    <th>Chronic Disease</th>
                                    <th>Barcode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($beneficiary = mysqli_fetch_assoc($beneficiary_result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($beneficiary['id']); ?></td>
                                        <td><?php echo htmlspecialchars($beneficiary['f_name']); ?></td>
                                        <td><?php echo htmlspecialchars($beneficiary['l_name']); ?></td>
                                        <td><?php echo htmlspecialchars($beneficiary['cin_ben'] ?? 'N/A'); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($beneficiary['birth'])); ?></td>
                                        <td><?php echo htmlspecialchars($beneficiary['relation']); ?></td>
                                        <td>
                                            <?php 
                                            if ($beneficiary['chronic'] == 'true' && !empty($beneficiary['chronic1'])) {
                                                echo htmlspecialchars($beneficiary['chronic1']);
                                            } else {
                                                echo 'None';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($beneficiary['barcode_value'])): ?>
                                                <img class="barcode-image" src="../barcodes/barcode_<?php echo $beneficiary['id']; ?>.png" alt="Barcode">
                                            <?php else: ?>
                                                No barcode
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No beneficiaries found for this client.
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center">
                <p>Printed on: <?php echo date('d/m/Y H:i:s'); ?></p>
            </div>
        </div>
    </div>

<?php
include('../includes/scripts.php');
include('../includes/footer.php');
?>
