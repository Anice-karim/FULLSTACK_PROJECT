<?php
include('../security.php'); 
function execute_update_query($connection, $query, $params, $types, $success_msg, $failure_msg, $redirect_url) {
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection));
        $_SESSION["status"] = "Database error during prepare. Please try again.";
        header("Location: $redirect_url");
        exit();
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    $query_run = mysqli_stmt_execute($stmt);

    if ($query_run) {
        $_SESSION["success"] = $success_msg;
    } else {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        $_SESSION["status"] = $failure_msg;
    }
    mysqli_stmt_close($stmt);
    header("Location: $redirect_url");
    exit();
}

//Update A Admin Profile
if (isset($_POST['updatebtn'])) {
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT); // Secure hashing

    $query = "UPDATE register SET name='$username', email='$email', password='$password' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Your Data is Updated";
        header('Location: register.php');
    } else {
        $_SESSION['status'] = "Your Data is NOT Updated";
        header('Location: register.php');
    }
}

// --- Update Health Professional Profile (Password Editing Removed) --- 
if (isset($_POST["updatebtn_hp"])) {
    $id = $_POST["edit_id"];
    $inpe = $_POST["inpe_edit"];
    $fname = $_POST["name1_edit"];
    $lname = $_POST["name2_edit"];
    $email = $_POST["edit_email"];
    $type = $_POST["type_edit"];
    $spec = $_POST["edit_spec"];

    // Basic validation
    if (empty($id) || empty($inpe) || empty($fname) || empty($lname) || empty($email) || empty($type) || empty($spec)) {
         $_SESSION["status"] = "All fields are required.";
         header("Location: register_Hp.php");
         exit();
    }

    $params = [$inpe, $fname, $lname, $email, $type, $spec, $id];
    $types = "ssssssi";
    $query = "UPDATE health_professionals SET inpe=?, f_name_hp=?, name=?, email=?, type=?, specialty=? WHERE id=?";

    execute_update_query(
        $connection, 
        $query, 
        $params, 
        $types, 
        "Health Professional Data Updated Successfully.", 
        "Health Professional Data Update Failed.", 
        "register_Hp.php"
    );
}

// --- Update Health Facility Profile (Password Editing Removed) --- 
if (isset($_POST["updatebtn_etab"])) {
    $id = $_POST["edit_id"];
    $inpe = $_POST["inpe_edit"];
    $name = $_POST["name_edit"];
    $type = $_POST["type_edit"];
    $pub = $_POST["prv-pub_edit"];
    $email = $_POST["edit_email"];
    $tele = $_POST["edit_tele"];

    // Basic validation
    if (empty($id) || empty($inpe) || empty($name) || empty($type) || empty($pub) || empty($email) || empty($tele)) {
         $_SESSION["status"] = "All fields are required.";
         header("Location: register_etab.php");
         exit();
    }

    $params = [$inpe, $name, $type, $email, $pub, $tele, $id];
    $types = "ssssssi";
    $query = "UPDATE etablissement SET inpe_etab=?, name=?, type_etab=?, email=?, pub_prv_etab=?, tele_etab=? WHERE id=?"; 

    execute_update_query(
        $connection, 
        $query, 
        $params, 
        $types, 
        "Establishment Data Updated Successfully.", 
        "Establishment Data Update Failed.", 
        "register_etab.php"
    );
}

// --- Update Insurance Company Profile (Password Editing Removed) --- 
if (isset($_POST["updatebtn_assu"])) {
    $id = $_POST["edit_id"];
    $patente = $_POST["patente_edit"];
    $name = $_POST["name_edit"];
    $pub = $_POST["prv-pub-edit"];
    $email = $_POST["email_edit"];
    $tel = $_POST["tel_edit"];

    // Basic validation
    if (empty($id) || empty($patente) || empty($name) || empty($pub) || empty($email) || empty($tel)) {
         $_SESSION["status"] = "All fields are required.";
         header("Location: register_assu.php");
         exit();
    }

    $params = [$patente, $name, $pub, $tel, $email, $id];
    $types = "sssssi";
    $query = "UPDATE assurance SET patente_assu=?, name=?, prv_pub_assu=?, tele_assu=?, email=? WHERE id=?";

    execute_update_query(
        $connection, 
        $query, 
        $params, 
        $types, 
        "Insurance Company Data Updated Successfully.", 
        "Insurance Company Data Update Failed.", 
        "register_assu.php"
    );
}


?>