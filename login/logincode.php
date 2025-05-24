<?php
include('security.php'); // Start session and DB connection here

if (!$connection) {
    die("Error: Database connection failed - " . mysqli_connect_error());
}

if (isset($_POST['login_btn'])) {
    $email_login = $_POST['email'];
    $password_login = $_POST['password']; // plain password from form

    // Basic validation
    if (empty($email_login) || empty($password_login)) {
        $_SESSION['msg'] = "Email and password are required.";
        header('Location: login.php');
        exit();
    }

    $role_tables = [
        'assurance' => 'assurance',
        'etablissement' => 'etablissement',
        'health_professionals' => 'health_professionals',
        'register' => 'admin', // Table used by your registration script
        'assure' => 'client'
    ];

    $authenticated = false;
    $user_found_in_any_table = false;

    foreach ($role_tables as $table => $folder) {
        // Use prepared statements for security
        // Select only needed columns for efficiency and security
        $query = "SELECT id, name, email, password FROM $table WHERE email = ? LIMIT 1"; 
        $stmt = mysqli_prepare($connection, $query);

        if (!$stmt) {
             error_log("Prepare failed for table $table: " . mysqli_error($connection));
             continue; // Skip this table if prepare fails
        }

        mysqli_stmt_bind_param($stmt, "s", $email_login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            $user_found_in_any_table = true; // Found a user with this email in this table
            $stored_hash = $user['password'];
            $user_id = $user['id']; // Get user ID for potential update

            // 1. Try modern password_verify first (Handles hashes from password_hash)
            if (password_verify($password_login, $stored_hash)) {
                $authenticated = true;

                // Optional but recommended: Check if the hash uses an outdated algorithm/cost factor
                if (password_needs_rehash($stored_hash, PASSWORD_DEFAULT)) {
                    $new_hash = password_hash($password_login, PASSWORD_DEFAULT);
                    // Update the hash in the database (use prepared statement)
                    $update_query = "UPDATE $table SET password = ? WHERE id = ?";
                    $update_stmt = mysqli_prepare($connection, $update_query);
                    if ($update_stmt) {
                        mysqli_stmt_bind_param($update_stmt, "si", $new_hash, $user_id);
                        mysqli_stmt_execute($update_stmt);
                        mysqli_stmt_close($update_stmt);
                        error_log("Rehashed password for user ID $user_id in table $table");
                    } else {
                         error_log("Failed to prepare password rehash statement for table $table, user ID $user_id: " . mysqli_error($connection));
                    }
                }
            }
            // 2. If password_verify failed, check for legacy MD5 (ONLY if it looks like MD5)
            // WARNING: This is for transition only. Remove this block once all users are migrated.
            else if (strlen($stored_hash) === 32 && ctype_xdigit($stored_hash)) { // Basic check for MD5 format (32 hex chars)
                 if (md5($password_login) === $stored_hash) {
                     $authenticated = true;
                     // CRITICAL: Upgrade the hash immediately to the modern standard
                     $new_hash = password_hash($password_login, PASSWORD_DEFAULT);
                     $update_query = "UPDATE $table SET password = ? WHERE id = ?";
                     $update_stmt = mysqli_prepare($connection, $update_query);
                     if ($update_stmt) {
                         mysqli_stmt_bind_param($update_stmt, "si", $new_hash, $user_id);
                         mysqli_stmt_execute($update_stmt);
                         mysqli_stmt_close($update_stmt);
                         error_log("Upgraded legacy MD5 password hash for user ID $user_id in table $table"); // Log the upgrade
                     } else {
                          error_log("Failed to prepare password upgrade statement for table $table, user ID $user_id: " . mysqli_error($connection));
                     }
                 }
            }

            // If authenticated in this table, set session and redirect
            if ($authenticated) {
                // Regenerate session ID upon successful login to prevent session fixation
                session_regenerate_id(true);

                $_SESSION['email'] = $user['email']; // Use email from DB for consistency
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['table'] = $table; // Store the table they logged in from
                $_SESSION['profile_pic'] = $user['profile_pic'] ?? null;
                $_SESSION['user_type'] = $user['type'] ?? null; // Store user type if available

                mysqli_stmt_close($stmt); // Close the select statement
                header("Location: $folder/index.php");
                exit();
            }
            // If user was found in this table but password didn't match (neither new nor legacy), stop checking.
            // This prevents login if email exists in multiple tables with different passwords.
            mysqli_stmt_close($stmt);
            break; // Exit the foreach loop
        }
        // Close statement if no user found in this table
        mysqli_stmt_close($stmt); 
    }

    // If the loop completes without authenticating
    $_SESSION['msg'] = "Email or password is invalid";
    header('Location: login.php');
    exit();

} else {
    // Redirect if accessed directly without POST data
    header('Location: login.php');
    exit();
}

?>
