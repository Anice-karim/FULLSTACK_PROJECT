<?php
include('../security.php'); 

// Function to send email with new password
function sendPasswordEmail($email, $name, $new_password) {
    $subject = "Your Account Password";
    $message = "Hello $name,\n\n";
    $message .= "Your account has been created successfully.\n\n";
    $message .= "Your password is: " . $new_password . "\n\n";
    $message .= "Please login with this password and change it immediately for security reasons.\n\n";
    $message .= "Regards,\nYour Support Team";
    
    $sender_email = isset($_SESSION['email']) ? $_SESSION['email'] : "noreply@yourdomain.com";
    $headers = "From: " . $sender_email . "\r\n";
    
    // Using PHP's mail function - replace with PHPMailer or other library for production
    return mail($email, $subject, $message, $headers);
}

// Process client registration
if(isset($_POST['registerbtn'])) {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $cin = mysqli_real_escape_string($connection, $_POST['CIN_as']);
    $rib = mysqli_real_escape_string($connection, $_POST['RIB_as']);
    $des = mysqli_real_escape_string($connection, $_POST['designation']);
    $salaire = mysqli_real_escape_string($connection, $_POST['salaire']);
    $immatr = mysqli_real_escape_string($connection, $_POST['N_immatriculation_assure']);
    $id_assu = mysqli_real_escape_string($connection, $_POST['assu_id']);
    
    // Basic validation
    if(empty($name) || empty($last_name) || empty($email) || empty($cin) || empty($rib) || 
       empty($des) || empty($salaire) || empty($immatr) || empty($id_assu)) {
        $_SESSION['status'] = "All fields are required";
        header('Location: assure_register.php');
        exit();
    }
    
    // Check if email already exists
    $check_query = "SELECT * FROM assure WHERE email = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    
    if(!$check_stmt) {
        $_SESSION['status'] = "Database error. Please try again.";
        header('Location: assure_register.php');
        exit();
    }
    
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if(mysqli_num_rows($check_result) > 0) {
        $_SESSION['status'] = "Email already registered";
        header('Location: assure_register.php');
        exit();
    }
    
    mysqli_stmt_close($check_stmt);
    
    // Generate a random password using the specified method
    $password_plain = bin2hex(random_bytes(4)); // Generates an 8-character hexadecimal password
    $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);
    
    // Insert new client with prepared statement
    $query = "INSERT INTO assure (name, prenom_as, email, CIN_as, RIB_as, designation, salaire_as, password, N_immatriculation_assure, id_assurance) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($connection, $query);
    
    if(!$stmt) {
        $_SESSION['status'] = "Database error. Please try again.";
        header('Location: assure_register.php');
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssssssi", $name, $last_name, $email, $cin, $rib, $des, $salaire, $hashed_password, $immatr, $id_assu);
    $query_run = mysqli_stmt_execute($stmt);
    
    if($query_run) {
        // Send password email
        $email_sent = sendPasswordEmail($email, $name, $password_plain);
        
        if($email_sent) {
            $_SESSION['success'] = "Client Profile Added Successfully. Password sent to email.";
        } else {
            $_SESSION['success'] = "Client Profile Added Successfully, but failed to send password email.";
            // Log the error for administrator
            error_log("Failed to send password email to: $email");
        }
    } else {
        $_SESSION['status'] = "Client Profile Not Added: " . mysqli_error($connection);
    }
    
    mysqli_stmt_close($stmt);
    header('Location: assure_register.php');
    exit();
}




 if(isset($_POST['registerbtn_beni'])) {
    $fname = $_POST['name1'];
    $lname = $_POST['name2'];
    $cin = $_POST['cin2'];
    $birth = $_POST['date'];
    $chronic = $_POST['chronic'];
    $chronic2 = $_POST['chronic2'];
    $relation = $_POST['relation'];
    $id_as = $_POST['admin_id'];
    
    // Generate barcode value
    $barcode_value = 'BEN-' . $id_as . '-' . substr(md5($id_as . $fname . $lname . time()), 0, 8);
    
    // Use prepared statement for security
    $query = "INSERT INTO beneficiaire (f_name, l_name, cin_ben, chronic, chronic1, id_as, relation, birth, barcode_value) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($connection, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssss", $fname, $lname, $cin, $chronic, $chronic2, $id_as, $relation, $birth, $barcode_value);
        $query_run = mysqli_stmt_execute($stmt);
        
        if ($query_run) {
            // Get the newly inserted beneficiary ID
            $beneficiary_id = mysqli_insert_id($connection);
            
            // Generate and save barcode image
            $barcode_dir = '../barcodes';
            if (!is_dir($barcode_dir)) {
                mkdir($barcode_dir, 0755, true);
            }
            
            $barcode_filename = 'barcode_' . $beneficiary_id . '.png';
            $barcode_path = $barcode_dir . '/' . $barcode_filename;
            
            // Include barcode generator
            require_once('composer_barcode_generator.php');
            
            // Generate the barcode PNG file
            $barcode_generated = generateBarcodePNG($barcode_value, $barcode_path);
            
            if ($barcode_generated) {
                $_SESSION['success'] = "A Family Member added with barcode image saved";
            } else {
                $_SESSION['success'] = "A Family Member added but barcode image could not be saved";
            }
        } else {
            $_SESSION['status'] = "A Family Member Not Added: " . mysqli_error($connection);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Database error: " . mysqli_error($connection);
    }
    
    header('Location: assure_register.php');
    exit();
}

// Process request to print beneficiary card
if (isset($_POST['print_card_btn'])) {
    $beneficiary_id = $_POST['beneficiary_id'];
    
    // Redirect to the print page with the beneficiary ID
    header("Location: print_beneficiary_card.php?id=$beneficiary_id");
    exit();
}
/////delete
 if(isset($_POST['delete_btn_as'])){
    $id =$_POST['delete_id_as'];
    
    $delete_as_query = "DELETE FROM assure WHERE id = '$id'";
    $delete_ben_query = "DELETE FROM beneficiaire WHERE id_as = '$id'";
  
    
    //all or nothing
    mysqli_begin_transaction($connection);


    try {
        mysqli_query($connection, $delete_as_query);
        mysqli_query($connection, $delete_ben_query );
        mysqli_commit($connection);//Yes, go ahead and apply all the changes.
        
        $_SESSION['success'] = "Ex-client and related records deleted successfully.";
    } catch (Exception $e) {
        // Rollback in case of error
        mysqli_rollback($connection);//cancels all previous deletions
        $_SESSION['status'] = "Error during deletion: " . $e->getMessage();
    }
    header('Location:assure_register.php');  

 }
 /// profile edit
 if (isset($_POST['edit_btn'])) {
    $message = ""; // Initialize message

    //  Ensure session email is available
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        //  Get current user from DB
        $selectQuery = "SELECT * FROM assurance WHERE email = '$email'";
        $result = mysqli_query($connection, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        //  Password update
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];

            if ($user && md5($currentPassword) === $user['password']) {
                $newPasswordHash = md5($newPassword);

                $updatePassQuery = "UPDATE assurance SET password = '$newPasswordHash' WHERE email = '$email'";
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
       
        //  Profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
            $targetPath = $uploadDir . $filename;

            $fileType = mime_content_type($_FILES['profile_pic']['tmp_name']);
            if (strpos($fileType, 'image') === false) {
                $message .= "❌ Only image files are allowed. ";
            } else {
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
                    $updatePicQuery = "UPDATE assurance SET profile_pic = '$filename' WHERE email = '$email'";
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
?>


<?php
// responds to invitation accept
if(isset($_POST['accept_btn'])){
    $id =$_POST['accept_id'];
    $status="reimbursed";
    $query="UPDATE dossier SET status ='$status' WHERE id = '$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Dossier refunded";
        header('Location:file_assur.php');
    }else{
        $_SESSION['status']="Dossier NOT accepted";
        header('Location:file_assur.php');
    }
 }



// responds to invitation refuse


 if(isset($_POST['refuse_btn_as'])){
    $id =$_POST['refuse_id_as'];
    $status="refused";
    $query="UPDATE dossier SET status ='$status' WHERE id = '$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Dossier refused";
        header('Location:file_assur.php');
    }else{
        $_SESSION['status']="Dossier was NOT rejected";
        header('Location:file_assur.php');
    }

 }

// update the dossier
//Update A Admin Profile
 if(isset($_POST['updatebtn'])){
    $id=$_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email= $_POST['edit_email'];
    $password=md5($_POST['edit_password']);
    
    $query ="UPDATE assure SET name='$username',email='$email',password='$password'WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:assure_register.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:assure_.php');
    }
 }


?>