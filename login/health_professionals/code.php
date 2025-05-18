<?php
include('../security.php'); 
// responds to invitation accept
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



// responds to invitation refuse


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

// update the dossier
if (isset($_POST['addbtn'])) {
    $id_dossier = $_POST['id_dossier'];
    $hp = $_POST['id_hp'];

    $query1 = "SELECT * FROM dossier WHERE id = '$id_dossier'";
    $query_run1 = mysqli_query($connection, $query1);

    if ($query_run1) {
        $run2 = mysqli_fetch_assoc($query_run1);
        if ($run2) {
            
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
    $id_doss = $_POST['ord1']; 
    $id_hp = $_POST['id_hp']; // Health professional ID

    $medicaments = $_POST['item'];
    $doses = $_POST['dose'];
    $unites = $_POST['unite'];
    $recommendations = $_POST['recommendation'];

    $query = "INSERT INTO ordonnance (id_doss, id_hp) VALUES('$id_doss','$id_hp')";
    $query_run = mysqli_query($connection , $query);

    if ($query_run) {
        // Get the inserted ID
        $ordonnance_id = mysqli_insert_id($connection);

        // Insert details only if at least one of the fields is not empty
        for ($i = 0; $i < count($medicaments); $i++) {
            if (
                trim($medicaments[$i]) !== '' || 
                trim($doses[$i]) !== '' || 
                trim($unites[$i]) !== '' || 
                trim($recommendations[$i]) !== ''
            ) {
                $med = mysqli_real_escape_string($connection, $medicaments[$i]);
                $dose = mysqli_real_escape_string($connection, $doses[$i]);
                $unite = mysqli_real_escape_string($connection, $unites[$i]);
                $rec = mysqli_real_escape_string($connection, $recommendations[$i]);

                $query_detail = "INSERT INTO ordonnance_details (ordonnance_id, medicament, dose, unite, recommendation)
                                 VALUES ('$ordonnance_id', '$med', '$dose', '$unite', '$rec')";
                mysqli_query($connection, $query_detail);
            }
            // else skip empty row
        }

        $_SESSION['success'] = "Ordonnance Added";
        header('Location:file_update.php');
        exit;
    } else {
        $_SESSION['status'] = "Ordonnance Not Added";
        header('Location:file_update.php');
        exit;
    }
}
//BACKEND POUR Add acts ------------------------------------------------------------------------------------
if (isset($_POST['addacte'])) {
        $id_doss = $_POST['ord1']; 
        $id_hp = $_POST['id_hp']; 

        $act = $_POST['act'];
        

        $query ="INSERT INTO acte (id_doss, id_hp,code_acts) VALUES('$id_doss','$id_hp','$act')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            $_SESSION['success']="Act  Added";
            header('Location:file_update.php');
        }else{
            $_SESSION['status']="Act Not Added";
            header('Location:file_update.php');
        }
}
//BACKEND to add analyse t radd a faire===============
if (isset($_POST['addana'])) {
    $id_doss = $_POST['imag_input']; 
    $id_hp = $_POST['id_hp']; // Health professional ID

    $ana = $_POST['analyse'];
    $rcd = $_POST['recommendation_analyse'];

    $query = "INSERT INTO ana_rad (id_doss, id_hp) VALUES('$id_doss','$id_hp')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $ana_id = mysqli_insert_id($connection);

        if (is_array($ana) && is_array($rcd)) {
            for ($i = 0; $i < count($ana); $i++) {
                // Check that neither ana nor rcd are empty (trim removes spaces)
                if (trim($ana[$i]) !== '' || trim($rcd[$i]) !== '') {
                    $ana_val = mysqli_real_escape_string($connection, $ana[$i]);
                    $rcd_val = mysqli_real_escape_string($connection, $rcd[$i]);

                    $query_detail = "INSERT INTO ana_rad_details (id_ana, anarad, recommendations)
                                     VALUES ('$ana_id', '$ana_val', '$rcd_val')";
                    mysqli_query($connection, $query_detail);
                }
                // Otherwise, ignore this row because it is empty
            }
        } else {
            // Case where ana and rcd are not arrays (single entry)
            if (trim($ana) !== '' || trim($rcd) !== '') {
                $ana_val = mysqli_real_escape_string($connection, $ana);
                $rcd_val = mysqli_real_escape_string($connection, $rcd);

                $query_detail = "INSERT INTO ana_rad_details (id_ana, anarad, recommendations)
                                 VALUES ('$ana_id', '$ana_val', '$rcd_val')";
                mysqli_query($connection, $query_detail);
            }
        }

        $_SESSION['success'] = "Analyse Or Rad Added";
        header('Location:file_update.php');
        exit;
    } else {
        $_SESSION['status'] = "Analyse Or Rad Not Added";
        header('Location:file_update.php');
        exit;
    }
}


?>