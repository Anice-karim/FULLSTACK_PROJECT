<?php
include('security.php'); // Ensure this starts session and connects to DB

// Function to generate a secure random password
function generateRandomPassword($length = 12) {
    // Define character sets
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $special = '!@#$%^&*()-_=+';
    
    // Ensure at least one character from each set
    $password = '';
    $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
    $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $special[rand(0, strlen($special) - 1)];
    
    // Fill the rest of the password with random characters from all sets
    $all_chars = $lowercase . $uppercase . $numbers . $special;
    for ($i = 4; $i < $length; $i++) {
        $password .= $all_chars[rand(0, strlen($all_chars) - 1)];
    }
    
    // Shuffle the password to avoid predictable patterns
    $password = str_shuffle($password);
    
    return $password;
}

// Function to send email with new password
function sendPasswordEmail($email, $new_password) {
    $subject = "Your New Password";
    $message = "Hello,\n\n";
    $message .= "You have requested a new password for your account.\n\n";
    $message .= "Your new password is: " . $new_password . "\n\n";
    $message .= "Please login with this password and change it immediately for security reasons.\n\n";
    $message .= "If you did not request this password reset, please contact support immediately.\n\n";
    $message .= "Regards,\nYour Support Team";
    
    $headers = "From: noreply@yourdomain.com\r\n";
    
    // Using PHP's mail function - replace with PHPMailer or other library for production
    return mail($email, $subject, $message, $headers);
}

// Process password reset request
if (isset($_POST['reset_password_btn'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    
    if (empty($email)) {
        $_SESSION['msg'] = "Email address is required.";
        header('Location: forgot_password.php');
        exit();
    }
    
    // Check if email exists in any of the user tables
    $role_tables = [
        'register' => 'Admin',
        'health_professionals' => 'Health Professional',
        'etablissement' => 'Health Facility',
        'assurance' => 'Insurance Company',
        'assure' => 'Client'
    ];
    
    $user_found = false;
    $table_name = '';
    $user_id = '';
    
    foreach ($role_tables as $table => $role) {
        $query = "SELECT id FROM $table WHERE email = ?";
        $stmt = mysqli_prepare($connection, $query);
        
        if (!$stmt) {
            error_log("Prepare failed for table $table: " . mysqli_error($connection));
            continue;
        }
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($user = mysqli_fetch_assoc($result)) {
            $user_found = true;
            $table_name = $table;
            $user_id = $user['id'];
            break;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    if (!$user_found) {
        $_SESSION['msg'] = "No account found with that email address.";
        header('Location: forgot_password.php');
        exit();
    }
    
    // Generate a new random password
    $new_password = generateRandomPassword();
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update the user's password in the database
    $update_query = "UPDATE $table_name SET password = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($connection, $update_query);
    
    if (!$update_stmt) {
        error_log("Prepare failed for password update: " . mysqli_error($connection));
        $_SESSION['msg'] = "System error. Please try again later.";
        header('Location: forgot_password.php');
        exit();
    }
    
    mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);
    $update_result = mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
    
    if (!$update_result) {
        error_log("Failed to update password: " . mysqli_error($connection));
        $_SESSION['msg'] = "Failed to reset password. Please try again.";
        header('Location: forgot_password.php');
        exit();
    }
    
    // Send the new password via email
    $email_sent = sendPasswordEmail($email, $new_password);
    
    if ($email_sent) {
        $_SESSION['msg'] = "A new password has been sent to your email address.";
    } else {
        // Password was updated but email failed
        error_log("Failed to send password email to: $email");
        $_SESSION['msg'] = "Password reset successful but failed to send email. Please contact support.";
    }
    
    header('Location: login.php');
    exit();
} else {
    // If accessed directly without form submission
    header('Location: forgot_password.php');
    exit();
}
?>
