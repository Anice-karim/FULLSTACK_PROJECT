<?php
include('../security.php'); 

if (isset($_POST['send_invite_btn'])) {
    $Hp = $_POST['hp_inpe'];
    $etab = $_POST['etab_id'];
    $message = $_POST['message'] ?? null;

    // First, get the HP internal ID
    $query_get_id = "SELECT id FROM health_professionals WHERE inpe = '$Hp'"; 
    $result = mysqli_query($connection, $query_get_id);

    if ($result) {
        $Hp1 = mysqli_fetch_assoc($result);
        if ($Hp1) {
            $id = $Hp1['id']; // the internal user ID
            $status = "pending";

            // 🔍 Check if invitation already exists for this HP and etablissement
            $check_query = "SELECT * FROM invitations WHERE id_etab = '$etab' AND id_Hp = '$id'";
            $check_result = mysqli_query($connection, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $_SESSION['status'] = "Invitation already sent to this Health Professional.";
                header('Location: invitation.php');
                exit();
            }

            // ✅ If not already invited, insert new invitation
            $sent = "INSERT INTO invitations (id_etab, id_Hp, message, status, created_at) 
                     VALUES ('$etab', '$id', '$message', '$status', NOW())";
            $run = mysqli_query($connection, $sent);

            if ($run) {
                $_SESSION['success'] = "Invitation sent successfully!";
            } else {
                $_SESSION['status'] = "Failed to send invitation.";
            }
        } else {
            $_SESSION['status'] = "Health Professional not found with this INPE.";
        }
    } else {
        $_SESSION['status'] = "Error while fetching user data.";
    }

    header('Location: invitation.php');
    exit();
}

if(isset($_POST['delete_invi_btn'])){
    $id =$_POST['delete_invi_id'];
    $query="DELETE  FROM invitations WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your invitation is Unsended";
        header('Location:invitation.php');
    }else{
        $_SESSION['status']="Your invitation is NOT Unsended";
        header('Location:invitation.php');
    }

 }
 ///////edit profile
 if (isset($_POST['edit_btn'])) {
    $message = ""; // Initialize message

    // ✅ Ensure session email is available
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // ✅ Get current user from DB
        $selectQuery = "SELECT * FROM etablissement WHERE email = '$email'";
        $result = mysqli_query($connection, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        // ✅ Password update
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];

            if ($user && md5($currentPassword) === $user['password']) {
                $newPasswordHash = md5($newPassword);

                $updatePassQuery = "UPDATE etablissement SET password = '$newPasswordHash' WHERE email = '$email'";
                $query_run = mysqli_query($connection, $updatePassQuery);

                if ($query_run) {
                    $message .= "✅ Password updated successfully. ";
                } else {
                    $message .= "❌ Error updating password. ";
                }
            } else {
                $message .= "❌ Incorrect current password. ";
            }
        }
       
        // ✅ Profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
            $targetPath = $uploadDir . $filename;

            $fileType = mime_content_type($_FILES['profile_pic']['tmp_name']);
            if (strpos($fileType, 'image') === false) {
                $message .= "❌ Only image files are allowed. ";
            } else {
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
                    $updatePicQuery = "UPDATE etablissement SET profile_pic = '$filename' WHERE email = '$email'";
                    $query_run = mysqli_query($connection, $updatePicQuery);

                    if ($query_run) {
                        $message .= "✅ Profile picture updated successfully. ";
                    } else {
                        $message .= "❌ Error updating profile picture. ";
                    }
                } else {
                    $message .= "❌ Error uploading the image. ";
                }
            }
        } else {
            $message .= "⚠️ No profile picture uploaded or error occurred. ";
        }

    } else {
        $message .= "⚠️ Session expired. Please log in again.";
    }

    $_SESSION['message'] = $message;
    header('Location: profile_edit.php');
    exit();
}
//add dossier
if(isset($_POST['addbtn']))
 {
    $id_client= $_POST['id_client'];
    $etab =$_POST['id_etab'];
    $date = date("Y-m-d");

    $query1 = "SELECT * FROM beneficiaire WHERE id = '$id_client'";
    $query_run1=mysqli_query($connection,$query1);
    
    if($query_run1){
        $run2 = mysqli_fetch_assoc($query_run1);
        if($run2){
        $query ="INSERT INTO dossier (id_benef, id_etab, date) VALUES('$id_client','$etab','$date')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            $_SESSION['success']="dossier Added";
            header('Location:file.php');
        }else{
            $_SESSION['status']="dossier Not Added";
            header('Location:file.php');
        }
    }else{
        $_SESSION['status']="id not found";
        header('Location:file.php');
    }
    }else{
        $_SESSION['status']="ERROR FETCHING";
        header('Location:file.php');
    }

   
 }





















?>