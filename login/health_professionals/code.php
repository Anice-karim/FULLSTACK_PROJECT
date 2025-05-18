<?php
include('../security.php'); 

if(isset($_POST['accept_invi_btn'])){
    $id =$_POST['accept_invi_id'];
    $status="accepted";
    $query="UPDATE invitations SET status ='$status' WHERE id = '$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        header('Location:joboffer.php');
        $fetch_query = "SELECT id_etab, id_Hp FROM invitations WHERE id = '$id'";
        $result = mysqli_query($connection, $fetch_query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $id_etab = $row['id_etab'];
            $id_Hp = $row['id_Hp'];
            $joined_at = date("Y-m-d H:i:s");;
            $insert = "INSERT INTO employe (id_etab, id_Hp, joined_at) VALUES ('$id_etab', '$id_Hp', '$joined_at')";
            $insert_run = mysqli_query($connection, $insert);
            if ($insert_run) {
                $_SESSION['success'] = " You are now an employee!";
            } else {
                $_SESSION['status'] = "Error adding to the employee table.";
            }
        } else {
            $_SESSION['status'] = "Error fetching invitation data.";
        }
    }else{
        $_SESSION['status']="Your invitation is NOT accepted";
        header('Location:joboffer.php');
    }
 }





 if(isset($_POST['decline_invi_btn'])){
    $id =$_POST['decline_invi_id'];
    $status="rejected";
    $query="UPDATE invitations SET status ='$status' WHERE id = '$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your invitation is rejected";
        header('Location:joboffer.php');
    }else{
        $_SESSION['status']="Your invitation is NOT rejected";
        header('Location:joboffer.php');
    }

 }


if (isset($_POST['addbtn'])) {
    $id_dossier = $_POST['id_dossier'];
    $hp = $_POST['id_hp'];

    $query1 = "SELECT * FROM dossier WHERE id = '$id_dossier'";
    $query_run1 = mysqli_query($connection, $query1);

    if ($query_run1) {
        $run2 = mysqli_fetch_assoc($query_run1);
        if ($run2) {
            // ✅ Use UPDATE instead of INSERT
            $query = "UPDATE dossier SET id_hp = '$hp' WHERE id = '$id_dossier'";
            $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                $_SESSION['success'] = "Dossier updated successfully";
                header('Location: file_update.php');
                exit();
            } else {
                $_SESSION['status'] = "Failed to update dossier";
                header('Location: file_update.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Dossier not found";
            header('Location: file_update.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Error fetching dossier";
        header('Location: file_update.php');
        exit();
    }
}

//BACKEND POUR ORDONNANCE 1 ------------------------------------------------------------------------------------
 
if (isset($_POST['save_ordonnance'])) {
    $id_doss = $_POST['ord1'];         // dossier ID from hidden input
    $id_hp = $_POST['id_hp'];          // health professional ID

    $medicaments = $_POST['item'];
    $doses = $_POST['dose'];
    $unites = $_POST['unite'];
    $recommendations = $_POST['recommendation'];

    $success = true;

    for ($i = 0; $i < count($medicaments); $i++) {
        $med = trim($medicaments[$i]);
        $dose = trim($doses[$i]);
        $unit = trim($unites[$i]);
        $rec = trim($recommendations[$i]);

        if ($med === "") continue;

        // Only insert what's needed (without id_ben)
        $query = "INSERT INTO ordonnance (id_doss, id_hp, medicament, unites, recommendation)
                  VALUES ('$id_doss', '$id_hp', '$med' , '$dose','$unit' , '$rec')";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("iisss", $id_doss, $id_hp, $med, $unit, $rec);

        if (!$stmt->execute()) {
            $success = false;
            break;
        }
    }

    $_SESSION[$success ? 'success' : 'status'] = $success
        ? "Ordonnance enregistrée avec succès."
        : "Erreur lors de l'enregistrement de l'ordonnance.";

    header("Location: ordonnance_page.php");
    exit();
}






?>