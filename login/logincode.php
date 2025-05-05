<?php

include('security.php');
$connection = mysqli_connect("localhost","root","","assurance");
if(!$connection){
    die("Eroor".mysqli_connect_eroor());
}else{
 if (isset($_POST['login_btn'])) {
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];
    

    $query = "SELECT * FROM register WHERE email = '$email_login' AND password = '$password_login'";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $usertype = mysqli_fetch_array($query_run);

        if ($usertype['usertype'] == 'admin') {
            $_SESSION['username'] = $email_login;
            header('Location: index.php');
            exit();
        } else if ($usertype['usertype'] == 'user') {
            $_SESSION['username'] = $email_login;
            header('Location: welcomepage/index.php');
            exit();
        } else {
            $_SESSION['status'] = "Email or password is invalid";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Email or password is invalid";
        header('Location: login.php');
        exit();
    }
}

}



?>


