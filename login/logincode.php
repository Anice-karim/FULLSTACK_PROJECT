<?php
include('security.php'); // Start session and DB connection here

if (!$connection) {
    die("Error: " . mysqli_connect_error());
}

if (isset($_POST['login_btn'])) {
    $email_login = $_POST['email'];
    $password_login = md5($_POST['password']);

    // Map tables to folders
    $role_tables = [
        'assurance' => 'assurance',
        'etablissement' => 'etablissement',
        'health_professionals' => 'health_professionals',
        'register' => 'admin'
    ];

    $authenticated = false;

    foreach ($role_tables as $table => $folder) {
        $query = "SELECT * FROM $table WHERE email = '$email_login'";
        $query_run = mysqli_query($connection, $query);

        if (mysqli_num_rows($query_run) > 0) {
            $user = mysqli_fetch_array($query_run);

            // Plaintext password check (NOT RECOMMENDED — see below)
            if ($user['password'] == $password_login) {
                $_SESSION['email'] = $email_login;
                $_SESSION['username'] = $user['name']; 
                
                $_SESSION['table'] = $table;
                header("Location: $folder/index.php");
                exit();
            }
        }
    }

    // If we reach here, login failed
    $_SESSION['status'] = "Email or password is invalid";
    header('Location: login.php');
    exit();
}
?>
