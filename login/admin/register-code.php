<?php
include('../security.php'); 

function getFirstAvailableName($data, $possibleKeys, $default = 'User') {
    foreach ($possibleKeys as $key) {
        if (!empty($data[$key])) {
            return $data[$key];
        }
    }
    return $default;
}

function registerUser($connection, $table, $data) {
    // 1. Generate password
    $password_plain = bin2hex(random_bytes(4)); // e.g., "a7b3c2f8"
    $data['password'] = password_hash($password_plain, PASSWORD_DEFAULT);

    // 2. Prepare SQL
    $columns = implode(", ", array_keys($data));
    $placeholders = rtrim(str_repeat("?, ", count($data)), ", ");
    $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        return "❌ SQL Error: " . mysqli_error($connection);
    }

    // 3. Bind values dynamically
    $types = str_repeat("s", count($data)); // assuming all string for simplicity
    $values = array_values($data);
    mysqli_stmt_bind_param($stmt, $types, ...$values);

    // 4. Execute and email
    if (mysqli_stmt_execute($stmt)) {
        $email = $data['email'];
        $name = getFirstAvailableName($data, ['name', 'f_name_hp', 'username', 'first_name', 'full_name']);
        $subject = "Your Account Has Been Created";
        $message = "Hello $name,\n\nYour account has been created successfully.\nYour temporary password is: $password_plain\n\nPlease change it after your first login.";
        $headers = "From: admin@health.ma";

        if (mail($email, $subject, $message, $headers)) {
            return "✅ Registered & email sent to $email";
        } else {
            return "⚠️ Registered but email failed.";
        }
    } else {
        return "❌ Insert failed: " . mysqli_error($connection);
    }
}



//Add A Admin Profile

if (isset($_POST["registerbtn"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["confirmpassword"];

    // Basic validation (add more as needed, e.g., email format)
    if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
        $_SESSION["status"] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    if ($password === $cpassword) {
        // Hash the password using the recommended modern standard
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if password hashing failed (rare, but good practice)
        if ($hashedPassword === false) {
            $_SESSION["status"] = "Password hashing failed. Please try again.";
            header("Location: register.php");
            exit();
        }

        // Use prepared statements to prevent SQL injection
        $query = "INSERT INTO register (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);

        if (!$stmt) {
            // Log the detailed error for debugging, show a generic message to user
            error_log("Prepare failed: " . mysqli_error($connection)); 
            $_SESSION["status"] = "Registration failed due to a server error. Please try again later.";
            header("Location: register.php");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
        $query_run = mysqli_stmt_execute($stmt);

        if ($query_run) {
            $_SESSION["success"] = "Admin Profile Added Successfully.";
        } else {
            // Check for duplicate email error (MySQL error code 1062)
            if (mysqli_errno($connection) == 1062) {
                 $_SESSION["status"] = "Email address already registered.";
            } else {
                // Log the detailed error, show generic message
                error_log("Execute failed: " . mysqli_stmt_error($stmt));
                $_SESSION["status"] = "Admin Profile Not Added due to a server error.";
            }
        }
        mysqli_stmt_close($stmt);
        header("Location: register.php");
        exit();

    } else {
        $_SESSION["status"] = "Password and Confirm password do not match.";
        header("Location: register.php");
        exit();
    }
}



//Add A health profissionnals
if (isset($_POST['registerbtn_Hp'])) {
    $data = [
        'inpe'        => $_POST['inpe'],
        'f_name_hp'   => $_POST['name1'],
        'name'        => $_POST['name2'],
        'type'        => $_POST['type'],
        'specialty'   => $_POST['spec'],
        'email'       => $_POST['email'],
    ];

    $_SESSION['status'] = registerUser($connection, 'health_professionals', $data);
    header('Location: register_Hp.php');
}

    


//Add Health Facilitie Profile
if (isset($_POST['registerbtn_etab'])) {
    // Collect input data except password
    $inpe = $_POST['inpe'];
    $name = $_POST['name'];
    $pub = $_POST['prv-pub'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['type'];

    // Prepare data array for registerUser function
    $data = [
        'inpe_etab' => $inpe,
        'name' => $name,
        'pub_prv_etab' => $pub,
        'type_etab' => $type,
        'tele_etab' => $phone,
        'email' => $email,
        // No password here, function will generate it
    ];

    // Call the reusable registerUser function
    $resultMessage = registerUser($connection, 'etablissement', $data);

    if (str_starts_with($resultMessage, '✅')) {
        $_SESSION['success'] = $resultMessage;
    } else {
        $_SESSION['status'] = $resultMessage;
    }
    header('Location: register_etab.php');
    exit();
}

 //Add Insurrance Company
if (isset($_POST['registerbtn_assu'])) {
    $patente = $_POST['patente'];
    $name = $_POST['name'];
    $pub = $_POST['prv-pub'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    // Prepare data array matching your assurance table columns (except password)
    $data = [
        'patente_assu' => $patente,
        'name' => $name,
        'prv_pub_assu' => $pub,
        'tele_assu' => $tel,
        'email' => $email,
        // password will be generated by registerUser()
    ];

    // Call the reusable function
    $resultMessage = registerUser($connection, 'assurance', $data);

    if (str_starts_with($resultMessage, '✅')) {
        $_SESSION['success'] = $resultMessage;
    } else {
        $_SESSION['status'] = $resultMessage;
    }
    header('Location: register_assu.php');
    exit();
}


    
 
?>