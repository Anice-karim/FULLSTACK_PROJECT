<?php
include('../security.php'); 

if(isset($_POST['registerbtn']))
 {
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email= $_POST['email'];
    $cin= $_POST['CIN_as'];
    $rib= $_POST['RIB_as'];
    $des= $_POST['designation'];
    $salaire= $_POST['salaire'];
    $password= $_POST['password'];
    $cpassword= $_POST['confirmpassword'];
   

    if($password === $cpassword){
        $query ="INSERT INTO assure (nom_as,prenom_as,email,CIN_as,RIB_as,designation,salaire_as,password)
                             VALUES('$name','$last_name','$email','$cin','$rib','$des','$salaire','$password')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="Client Profile Added";
            header('Location:assure_register.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="Client Profile Not Added";
            header('Location:assure_register.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:assure_register.php');
    }

    
 }
?>