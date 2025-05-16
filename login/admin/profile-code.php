<?php
include('../security.php'); 

//Edit profile

if (isset($_POST['edit_btn'])) {
    $message = ""; // Initialize message

    // ✅ Ensure session email is available
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // ✅ Get current user from DB
        $selectQuery = "SELECT * FROM register WHERE email = '$email'";
        $result = mysqli_query($connection, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        // ✅ Password update
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];

            if ($user && md5($currentPassword) === $user['password']) {
                $newPasswordHash = md5($newPassword);

                $updatePassQuery = "UPDATE register SET password = '$newPasswordHash' WHERE email = '$email'";
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
                    $updatePicQuery = "UPDATE register SET profile_pic = '$filename' WHERE email = '$email'";
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