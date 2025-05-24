<?php
include('../security.php'); 

if (isset($_POST['send_invite_btn'])) {
    $Hp = $_POST['hp_inpe'];
    $etab = $_POST['etab_id'];
    $message = $_POST['message'] ?? null;

    // Get HP id and email using prepared statement
    $stmt = $connection->prepare("SELECT id, email FROM health_professionals WHERE inpe = ?");
    $stmt->bind_param("s", $Hp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $Hp1 = $result->fetch_assoc()) {
        $id = $Hp1['id'];
        $hpEmail = $Hp1['email'];
        $status = "pending";

        // Check for existing invitation
        $check_stmt = $connection->prepare("SELECT id FROM invitations WHERE id_etab = ? AND id_Hp = ?");
        $check_stmt->bind_param("ii", $etab, $id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $_SESSION['status'] = "Invitation already sent to this Health Professional.";
        } else {
            // Insert invitation
            $insert_stmt = $connection->prepare(
                "INSERT INTO invitations (id_etab, id_Hp, message, status, created_at) VALUES (?, ?, ?, ?, NOW())"
            );
            $insert_stmt->bind_param("iiss", $etab, $id, $message, $status);

            if ($insert_stmt->execute()) {
                // Send email
                $fromEmail = $_SESSION['email'];
                $subject = "New Invitation";
                $messageBody = "Hello,\n\nYou have received a new invitation:\n\n$message\n\nBest regards.";
                $headers = "From: $fromEmail\r\n" .
                           "Reply-To: $fromEmail\r\n" .
                           "X-Mailer: PHP/" . phpversion();

                if (mail($hpEmail, $subject, $messageBody, $headers)) {
                    $_SESSION['success'] = "Invitation sent successfully and email notification sent!";
                } else {
                    $_SESSION['success'] = "Invitation sent but failed to send email notification.";
                    // Optional: Log the failure
                    error_log("Mail function failed for $hpEmail");
                }
            } else {
                $_SESSION['status'] = "Failed to send invitation.";
            }
        }
    } else {
        $_SESSION['status'] = "Health Professional not found with this INPE.";
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
 //delete table
 if (isset($_POST['delete_btn_as'])) {
    $id_to_delete = $_POST['delete_id_as'];

    // SQL DELETE query
    $delete_query = "DELETE FROM dossier WHERE id = '$id_to_delete'";
    $delete_run = mysqli_query($connection, $delete_query);

    if ($delete_run) {
        $_SESSION['success'] = "Dossier deleted successfully";
        header("Location: file.php"); // redirect to your page
        exit();
    } else {
        $_SESSION['status'] = "Failed to delete assurance";
        header("Location: file.php");
        exit();
    }
}
// receipts pay

  if (isset($_POST['receipt_btn'])) {
    $medicaments = $_POST['acts']; 
    $prixs = $_POST['prix'];
    $ordonnance_ids = $_POST['ordonnance'];
    $hps=$_POST['hp'];

    

    for ($i = 0; $i < count($medicaments); $i++) {
        $medicament = mysqli_real_escape_string($connection, $medicaments[$i]); // escape string
        $prix = floatval($prixs[$i]);
        $ordonnance_id = intval($ordonnance_ids[$i]);
        $hp=floatval($hps[$i]);

        $query = "UPDATE ordonnance_details 
                  SET prix = '$prix' , id_hp='$hp'
                  WHERE ordonnance_id = '$ordonnance_id' AND medicament = '$medicament'";

        mysqli_query($connection, $query);
    }

    header("Location: receipt.php");
    exit();}























?>